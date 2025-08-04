<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Shipment;
use App\Services\InPostService;

class ShipmentController extends Controller
{
    // Lista przesyłek klienta
    public function index()
    {
        $customer = Auth::user();
        $shipments = Shipment::where('customer_id', $customer->id)->orderByDesc('created_at')->get();
        return view('shipments.index', compact('shipments'));
    }

    // Szczegóły przesyłki
    public function show($id)
    {
        $customer = Auth::user();
        $shipment = Shipment::where('customer_id', $customer->id)->findOrFail($id);
        return view('shipments.show', compact('shipment'));
    }

    // Formularz nadania paczki
    public function create()
    {
        return view('shipments.create');
    }

    // Obsługa formularza - zapisanie jako “draft”
    public function store(Request $request)
    {
        $customer = Auth::user();

        $data = $request->validate([
            'receiver_first_name' => 'required',
            'receiver_last_name'  => 'required',
            'receiver_email'      => 'required|email',
            'receiver_phone'      => 'required',
            'inpost_point'        => 'required',
            'size'                => 'required|in:A,B,C',
            'weight_kg'           => 'required|numeric|min:0.01',
        ]);

        $shipment = Shipment::create([
            'customer_id' => $customer->id,
            'carrier_id'  => 1, // InPost (jeśli masz carrier_id)
            'status'      => 'draft',
            'weight_kg'   => $data['weight_kg'],
            'details'     => json_encode($data),
        ]);

        return redirect()->route('shipments.payment', $shipment);
    }

    // Strona z “fake” płatnością
    public function payment(Shipment $shipment)
    {
        $customer = Auth::user();
        if ($shipment->customer_id !== $customer->id) {
            abort(403);
        }
        return view('shipments.payment', compact('shipment'));
    }

    // Obsługa “płatności”, wywołanie API InPost, pobranie etykiety, aktualizacja shipmentu
    public function pay(Request $request, Shipment $shipment)
    {
        $customer = Auth::user();
        if ($shipment->customer_id !== $customer->id) {
            abort(403);
        }

        $details = json_decode($shipment->details, true);

        $payload = [
            'service' => 'inpost_locker_standard',
            'reference' => 'ORDER-' . $shipment->id,
            'receiver' => [
                'email'      => $details['receiver_email'],
                'phone'      => $details['receiver_phone'],
                'first_name' => $details['receiver_first_name'],
                'last_name'  => $details['receiver_last_name'],
            ],
            'custom_attributes' => [
                'target_point' => $details['inpost_point'],
            ],
            'parcels' => [
                [
                    'template' => $details['size'],
                    'weight'   => $details['weight_kg'] * 1000,
                ]
            ]
        ];

        try {
            $inpost = app(InPostService::class);
            $result = $inpost->createShipment($payload);

            // Pobierz etykietę
            $inpostShipmentId = $result['id'] ?? null;
            $labelContent = $inpost->getLabel($inpostShipmentId);

            $labelPath = "labels/inpost_{$shipment->id}_{$inpostShipmentId}.pdf";
            Storage::disk('local')->put($labelPath, $labelContent);

            // Zaktualizuj shipment
            $shipment->update([
                'status'          => 'created',
                'tracking_number' => $result['tracking_number'] ?? null,
                'details'         => json_encode(['inpost' => $result] + $details),
            ]);

        } catch (\Throwable $e) {
            return redirect()->route('shipments.index')->with('error', 'Błąd nadawania: ' . $e->getMessage());
        }

        return redirect()->route('shipments.index')->with('success', 'Paczka nadana. Etykieta do pobrania.');
    }

    // Pobieranie etykiety PDF
    public function label($id)
    {
        $customer = Auth::user();
        $shipment = Shipment::where('customer_id', $customer->id)->findOrFail($id);

        $details = json_decode($shipment->details, true);
        $inpostShipmentId = $details['inpost']['id'] ?? 'NIEZNANY';
        $labelPath = "labels/inpost_{$shipment->id}_{$inpostShipmentId}.pdf";

        if (!Storage::disk('local')->exists($labelPath)) {
            abort(404, 'Brak etykiety');
        }

        return response()->download(storage_path("app/{$labelPath}"), "label-{$shipment->id}.pdf");
    }
}
