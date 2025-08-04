@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Moje przesyłki</h2>
    <a href="{{ route('shipments.create') }}" class="btn btn-success mb-3">Nadaj nową paczkę</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Data utworzenia</th>
                <th>Odbiorca</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            @forelse($shipments as $shipment)
            <tr>
                <td>{{ $shipment->id }}</td>
                <td>{{ $shipment->status }}</td>
                <td>{{ $shipment->created_at }}</td>
                <td>{{ $shipment->details ? json_decode($shipment->details, true)['recipient_name'] ?? '-' : '-' }}</td>
                <td>
                    <a href="{{ route('shipments.show', $shipment->id) }}" class="btn btn-primary btn-sm">Szczegóły</a>
                    @if($shipment->status === 'created')
                        <a href="{{ route('shipments.payment', $shipment->id) }}" class="btn btn-warning btn-sm">Opłać</a>
                    @endif
                    @if($shipment->status === 'paid' || $shipment->status === 'registered' || $shipment->status === 'sent')
                        <a href="{{ route('shipments.label', $shipment->id) }}" class="btn btn-info btn-sm">Pobierz etykietę</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Brak przesyłek</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
