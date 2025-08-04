<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use League\Csv\Reader;
use League\Csv\Writer;
use App\Services\InPostService; // dodaj import serwisu!
use Symfony\Component\HttpFoundation\StreamedResponse;

class ShipmentApiController extends Controller
{
    // GET /api/shipments
    public function index(Request $request)
    {
        $shipments = Shipment::paginate(20);
        return response()->json($shipments);
    }

    // GET /api/shipments/{shipment}
    public function show(Shipment $shipment)
    {
        return response()->json($shipment);
    }

    // POST /api/shipments
    public function store(Request $request, InPostService $inpost)
    {
        $data = $request->validate([
            'customer_id' => 'required|integer',
            'carrier_id' => 'required|integer',
            'tracking_number' => 'nullable|string',
            'length_cm' => 'required|numeric',
            'width_cm' => 'required|numeric',
            'height_cm' => 'required|numeric',
            'weight_kg' => 'required|numeric',
            'billing_weight_kg' => 'required|numeric',
            'details' => 'nullable|json',
        ]);
        $data['status'] = 'created';

        // 1. Wywołanie API InPost i pobranie danych przesyłki
        // Musisz zamapować dane do payloadu oczekiwanego przez InPost (dostosuj do swojego przypadku)
        $inpostPayload = [
            'receiver' => [
                // Przykład: uzupełnij danymi odbiorcy z $request!
                'email' => $request->input('receiver_email', 'test@example.com'),
                'phone' => $request->input('receiver_phone', '500600700'),
                'name'  => $request->input('receiver_name', 'Jan Kowalski'),
            ],
            'parcels' => [
                [
                    'dimensions' => [
                        'length' => (float) $data['length_cm'],
                        'width'  => (float) $data['width_cm'],
                        'height' => (float) $data['height_cm'],
                    ],
                    'weight' => (float) $data['weight_kg'],
                ]
            ],
            // Pamiętaj: type/target_point / service
            'service' => 'inpost_locker_standard',
            'custom_attributes' => [
                // opcjonalnie własne atrybuty
            ],
        ];

        // Uwaga: minimalny payload dla testów! Sprawdź wymagania w dokumentacji ShipX.

        $inpostResponse = $inpost->createShipment($inpostPayload);

        // 2. Zapisz dane w bazie — np. tracking_number i status z odpowiedzi InPost
        $data['tracking_number'] = $inpostResponse['tracking_number'] ?? null;
        $data['details'] = json_encode(['inpost' => $inpostResponse]);
        $shipment = Shipment::create($data);

        return response()->json([
            'message' => 'Shipment created and sent to InPost',
            'shipment' => $shipment,
            'inpost' => $inpostResponse
        ], 201);
    }

    // PUT/PATCH /api/shipments/{shipment}
    public function update(Request $request, Shipment $shipment)
    {
        $data = $request->validate([
            'customer_id' => 'sometimes|integer',
            'carrier_id' => 'sometimes|integer',
            'tracking_number' => 'sometimes|string',
            'length_cm' => 'sometimes|numeric',
            'width_cm' => 'sometimes|numeric',
            'height_cm' => 'sometimes|numeric',
            'weight_kg' => 'sometimes|numeric',
            'billing_weight_kg' => 'sometimes|numeric',
            'details' => 'sometimes|json',
            'status' => 'sometimes|string',
        ]);

        $shipment->update($data);

        return response()->json($shipment);
    }

    // PATCH /api/shipments/{shipment}/cancel
    public function cancel(Request $request, Shipment $shipment)
    {
        if ($shipment->status !== 'created') {
            return response()->json(['error' => 'Shipment cannot be cancelled at this stage.'], 409);
        }

        // Tu możesz dodać anulację po stronie InPost (InPost nie zawsze pozwala!)
        // Przykład:
        // $inpost->cancelShipment($shipment->tracking_number);

        $shipment->status = 'cancelled';
        $shipment->save();

        return response()->json([
            'message' => 'Shipment cancelled',
            'shipment' => $shipment
        ]);
    }

    // GET /api/shipments/{shipment}/label
    public function label(Shipment $shipment, InPostService $inpost)
    {
        $labelPath = "labels/{$shipment->id}.pdf";

        if (!Storage::disk('local')->exists($labelPath)) {
            // Pobierz label z InPost jeśli jeszcze nie ma
            if (!$shipment->tracking_number) {
                return response()->json(['error' => 'No tracking number!'], 404);
            }

            try {
                $pdfContent = $inpost->getLabel($shipment->tracking_number, 'A6');
                Storage::disk('local')->put($labelPath, $pdfContent);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Cannot fetch label: ' . $e->getMessage()], 500);
            }
        }

        return response()->download(storage_path("app/{$labelPath}"), "label-{$shipment->id}.pdf");
    }

    // GET /api/shipments/export (CSV eksport)
    public function exportCsv()
    {
        $shipments = Shipment::all();

        $csv = Writer::createFromString('');
        $csv->insertOne([
            'id', 'customer_id', 'carrier_id', 'tracking_number', 'status',
            'length_cm', 'width_cm', 'height_cm', 'weight_kg', 'billing_weight_kg', 'details', 'created_at', 'updated_at'
        ]);

        foreach ($shipments as $shipment) {
            $csv->insertOne([
                $shipment->id,
                $shipment->customer_id,
                $shipment->carrier_id,
                $shipment->tracking_number,
                $shipment->status,
                $shipment->length_cm,
                $shipment->width_cm,
                $shipment->height_cm,
                $shipment->weight_kg,
                $shipment->billing_weight_kg,
                $shipment->details,
                $shipment->created_at,
                $shipment->updated_at,
            ]);
        }

        $filename = 'shipments_export_' . now()->format('Ymd_His') . '.csv';
        return response($csv->toString(), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    // POST /api/shipments/import (CSV import)
    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $csv = Reader::createFromPath($file->getRealPath());
        $csv->setHeaderOffset(0);

        $imported = 0;
        foreach ($csv->getRecords() as $record) {
            try {
                Shipment::create([
                    'customer_id' => $record['customer_id'] ?? null,
                    'carrier_id' => $record['carrier_id'] ?? null,
                    'tracking_number' => $record['tracking_number'] ?? null,
                    'status' => $record['status'] ?? 'created',
                    'length_cm' => $record['length_cm'] ?? null,
                    'width_cm' => $record['width_cm'] ?? null,
                    'height_cm' => $record['height_cm'] ?? null,
                    'weight_kg' => $record['weight_kg'] ?? null,
                    'billing_weight_kg' => $record['billing_weight_kg'] ?? null,
                    'details' => $record['details'] ?? null,
                ]);
                $imported++;
            } catch (\Throwable $e) {
                continue;
            }
        }

        return response()->json(['message' => "Imported {$imported} shipments"]);
    }
}
