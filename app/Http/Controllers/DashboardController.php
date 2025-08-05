<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shipment;
use App\Models\Order;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        $customer = Auth::user();
        $shipments = Shipment::where('customer_id', $customer->id)->latest()->limit(5)->get();
        $orders = Order::where('customer_id', $customer->id)->latest()->limit(5)->get();
        $invoices = Invoice::where('customer_id', $customer->id)->latest()->limit(5)->get();

        // Zmiana jest tutaj: \compact
        return view('dashboard', \compact('customer', 'shipments', 'orders', 'invoices'));
    }
}
