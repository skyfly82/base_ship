<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebhookExternalController extends Controller
{
    // POST /api/webhook/external
    public function receive(Request $request)
    {
        // Przykład: logowanie danych lub zapisywanie statusów
        // $requestData = $request->all();
        // Możesz wrzucić do bazy, dodać obsługę zdarzeń itp.
        // Log::info('Received external webhook', $requestData);

        return response()->json(['message' => 'Webhook (external) received'], 200);
    }
}
