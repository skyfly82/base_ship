<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function receive(Request $request)
    {
        Log::info('Webhook received:', $request->all());

        // Możesz tu wywołać własną logikę przetwarzania webhooka
        return response()->json(['status' => 'ok']);
    }
}
