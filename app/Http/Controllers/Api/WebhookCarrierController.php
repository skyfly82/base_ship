<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WebhookCarrierController extends Controller
{
    /**
     * Obsługa webhooków z firm kurierskich.
     * Przykład: POST /api/webhook/carrier/dpd
     */
    public function receive(Request $request, $carrier)
    {
        // TODO: Walidacja, logika obsługi, zapis do bazy, dispatch jobów, itp.
        // $carrier = 'dpd', 'meest', 'inpost', itd.
        // Dane webhooka: $request->all()

        // Przykład zapisu do logów:
        \Log::info("Webhook od kuriera [$carrier]", [
            'ip' => $request->ip(),
            'payload' => $request->all(),
        ]);

        // Tutaj rozpoznajesz firmę i obsługujesz odpowiednio event
        // switch ($carrier) { ... }

        // Odpowiedź dla kuriera
        return response()->json([
            'success' => true,
            'message' => "Webhook od kuriera [$carrier] przyjęty",
        ]);
    }
}
