<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Jobs\ProcessInternalWebhookJob;

class WebhookInternalController extends Controller
{
    public function __construct()
    {
        // Middleware do autoryzacji tylko po system_users, np. Basic Auth lub token:
        // $this->middleware('systemuser.auth'); // Jeśli masz swój middleware (zalecane)
        // $this->middleware('auth.basic:system_users'); // Lub przez built-in (jeśli używasz guardów)
    }

    /**
     * POST /api/webhook/internal
     * Obsługuje wewnętrzne webhooki (np. z BI, ERP, innych mikroserwisów)
     */
    public function receive(Request $request)
    {
        // Jeśli używasz autoryzacji — można pobrać zalogowanego system usera
        $systemUser = Auth::user();

        // Logowanie requestu + usera (dla bezpieczeństwa i historii audytu)
        Log::info("Internal webhook received", [
            'user_id'   => $systemUser?->id,
            'user_email'=> $systemUser?->email,
            'ip'        => $request->ip(),
            'payload'   => $request->all(),
        ]);

        // Walidacja podstawowych danych
        $validated = $request->validate([
            'event_type' => 'required|string|max:255',
            'payload'    => 'required|array',
        ]);

        // Przykład: obsługa try/catch na kolejce – łatwiej debugować
        try {
            // Asynchroniczna obsługa przez job (przykładowy Job do queue)
            ProcessInternalWebhookJob::dispatch(
                $validated['event_type'],
                $validated['payload'],
                $systemUser?->id
            );

            // Sukces – zawsze zwracaj 202/200 i nie pokazuj za dużo szczegółów
            return response()->json([
                'success' => true,
                'message' => 'Webhook (internal) received and dispatched',
            ], Response::HTTP_ACCEPTED);

        } catch (\Throwable $e) {
            Log::error("Webhook internal failed", [
                'error' => $e->getMessage(),
                'user_id' => $systemUser?->id,
                'input' => $request->all(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Internal processing failed',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
