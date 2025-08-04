<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShipmentApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\InvoiceApiController;
use App\Http\Controllers\Api\WebhookCarrierController;
use App\Http\Controllers\Api\WebhookInternalController;

// Test endpoint
Route::get('/ping', fn() => response()->json(['pong' => true]));

// ==================
//      SHIPMENTS
// ==================

// Standardowe REST API dla przesyłek
Route::apiResource('shipments', ShipmentApiController::class);

// PATCH /api/shipments/{id}/cancel — anulowanie przesyłki (jeśli możliwe)
Route::patch('shipments/{shipment}/cancel', [ShipmentApiController::class, 'cancel']);

// GET /api/shipments/{id}/label — pobieranie/generowanie etykiety PDF
Route::get('shipments/{shipment}/label', [ShipmentApiController::class, 'label']);

// Export przesyłek do CSV
Route::get('shipments/export', [ShipmentApiController::class, 'exportCsv']);

// Import przesyłek z CSV
Route::post('shipments/import', [ShipmentApiController::class, 'importCsv']);


// ==================
//       ORDERS
// ==================
Route::apiResource('orders', OrderApiController::class);

// ==================
//      INVOICES
// ==================
Route::apiResource('invoices', InvoiceApiController::class);


// ==================
//     WEBHOOKS
// ==================

// Odbieranie webhooków od kurierów (np. zmiana statusu, tracking, label, inne eventy kurierów)
// Przekazujesz np. POST /api/webhook/carrier/dpd lub /api/webhook/carrier/meest
Route::post('webhook/carrier/{carrier}', [WebhookCarrierController::class, 'receive']);

// Odbieranie webhooków od systemów wewnętrznych (np. BI, ERP, inne mikroserwisy)
Route::post('webhook/internal', [WebhookInternalController::class, 'receive']);

// (opcjonalnie) Globalny webhook-in jeśli używasz jednego punktu wejścia do testów/debuingu
// Route::post('webhook/in', [WebhookInternalController::class, 'receive']);

// ==================
//   CATCH-ALL/PING
// ==================

// Ping endpoint dla monitoringu/prostych healthchecków (GET /api/ping)
Route::get('/ping', fn() => response()->json(['pong' => true]));

