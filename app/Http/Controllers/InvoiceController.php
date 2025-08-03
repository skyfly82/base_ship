<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    // Lista faktur klienta
    public function index()
    {
        $customer = Auth::user();
        $invoices = Invoice::where('customer_id', $customer->id)->orderByDesc('issue_date')->get();
        return view('invoices.index', compact('invoices'));
    }

    // Szczegóły faktury
    public function show($id)
    {
        $customer = Auth::user();
        $invoice = Invoice::where('customer_id', $customer->id)->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }
}
