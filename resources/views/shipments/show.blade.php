@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Szczegóły przesyłki #{{ $shipment->id }}</h2>
    <ul class="list-group">
        <li class="list-group-item"><b>Status:</b> {{ $shipment->status }}</li>
        <li class="list-group-item"><b>Data nadania:</b> {{ $shipment->created_at }}</li>
        <li class="list-group-item"><b>Odbiorca:</b> {{ $shipment->details ? json_decode($shipment->details, true)['recipient_name'] ?? '-' : '-' }}</li>
        <li class="list-group-item"><b>Paczkomat docelowy:</b> {{ $shipment->details ? json_decode($shipment->details, true)['target_point'] ?? '-' : '-' }}</li>
        <li class="list-group-item"><b>Wymiary:</b> {{ $shipment->length_cm }} x {{ $shipment->width_cm }} x {{ $shipment->height_cm }} cm</li>
        <li class="list-group-item"><b>Waga:</b> {{ $shipment->weight_kg }} kg</li>
        <li class="list-group-item"><b>Tracking:</b> {{ $shipment->tracking_number ?? '-' }}</li>
    </ul>
    <br>
    <a href="{{ route('shipments.index') }}" class="btn btn-secondary">Powrót do listy</a>
    @if($shipment->status === 'paid' || $shipment->status === 'registered' || $shipment->status === 'sent')
        <a href="{{ route('shipments.label', $shipment->id) }}" class="btn btn-info">Pobierz etykietę</a>
    @endif
</div>
@endsection
