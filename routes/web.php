<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ShipmentController;
use App\Services\InPostService;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/shipments', [ShipmentController::class, 'index'])->name('shipments.index');
    Route::get('/shipments/{id}', [ShipmentController::class, 'show'])->name('shipments.show');
});

// ========================================
//      TESTOWY ENDPOINT INPOST SANDBOX
// ========================================
Route::get('/test-inpost-points', function (InPostService $inPost) {
    try {
        // Pobierz pierwsze 20 paczkomatów z sandboxa (tylko do testów!)
        $points = $inPost->getPoints('parcel_locker');
        return response()->json(array_slice($points, 0, 20));
    } catch (\Throwable $e) {
        return response(['error' => $e->getMessage()], 500);
    }
});
// UWAGA: Po testach usuń ten endpoint!

require __DIR__.'/auth.php';
