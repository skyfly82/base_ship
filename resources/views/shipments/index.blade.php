@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Twoje przesyłki</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th><th>Status</th><th>Tracking</th><th>Waga</th><th>Data</th><th>Akcja</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shipments as $shipment)
            <tr>
                <td>{{ $shipment->id }}</td>
                <td>{{ $shipment->status }}</td>
                <td>{{ $shipment->tracking_number }}</td>
                <td>{{ $shipment->billing_weight_kg ?? $shipment->weight_kg }} kg</td>
                <td>{{ $shipment->created_at }}</td>
                <td>
                    <a href="{{ route('shipments.show', $shipment->id) }}" class="btn btn-primary btn-sm">Szczegóły</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
