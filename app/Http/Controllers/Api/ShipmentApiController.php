<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use League\Csv\Reader;
use League\Csv\Writer;
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
    public function store(Request $request)
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

        $shipment = Shipment::create($data);

        return response()->json($shipment, 201);
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
        // Możesz dodać logikę: czy anulacja możliwa, np. nie wysłano do kuriera itp.
        if ($shipment->status !== 'created') {
            return response()->json(['error' => 'Shipment cannot be cancelled at this stage.'], 409);
        }

        // Wywołanie API kuriera (opcjonalnie)

        $shipment->status = 'cancelled';
        $shipment->save();

        return response()->json([
            'message' => 'Shipment cancelled',
            'shipment' => $shipment
        ]);
    }

    // GET /api/shipments/{shipment}/label
    public function label(Shipment $shipment)
    {
        // Możesz tu wygenerować labelkę PDF (albo zwrócić wcześniej pobraną z API kuriera)
        // Przykład zwrócenia pliku PDF, który jest na dysku lokalnym:
        $labelPath = "labels/{$shipment->id}.pdf";

        if (!Storage::disk('local')->exists($labelPath)) {
            // Wywołanie do API kuriera, pobranie i zapisanie etykiety
            // Storage::disk('local')->put($labelPath, $labelPdfContent);
            return response()->json(['error' => 'Label not found'], 404);
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
            // Możesz zrobić walidację i mapowanie pól
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
                // Możesz logować błędy walidacji itp.
                continue;
            }
        }

        return response()->json(['message' => "Imported {$imported} shipments"]);
    }
}
