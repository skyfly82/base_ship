@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Witaj, {{ $customer->name }}</h1>

    <h3 class="mt-4">Twoje ostatnie przesyłki</h3>
    <a href="{{ route('shipments.index') }}" class="btn btn-primary mb-3">
    Zobacz wszystkie przesyłki
</a>

    <table class="table">
        <thead><tr><th>ID</th><th>Status</th><th>Tracking</th><th>Data</th></tr></thead>
        <tbody>
        @foreach($shipments as $shipment)
            <tr>
                <td>{{ $shipment->id }}</td>
                <td>{{ $shipment->status }}</td>
                <td>{{ $shipment->tracking_number }}</td>
                <td>{{ $shipment->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h3 class="mt-4">Ostatnie zamówienia</h3>
    <table class="table">
        <thead><tr><th>ID</th><th>Kwota brutto</th><th>Waluta</th><th>Data</th></tr></thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->amount_gross }}</td>
                <td>{{ $order->currency }}</td>
                <td>{{ $order->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h3 class="mt-4">Ostatnie faktury</h3>
        <a href="{{ route('invoices.index') }}" class="btn btn-primary mb-3">
        Zobacz wszystkie faktury
    </a>
    <table class="table">
        <thead><tr><th>Nr</th><th>Kwota brutto</th><th>Data wystawienia</th></tr></thead>
        <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->invoice_number }}</td>
                <td>{{ $invoice->amount_gross }}</td>
                <td>{{ $invoice->issue_date }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
