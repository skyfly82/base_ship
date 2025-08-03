<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shipment;

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
}
