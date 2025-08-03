@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Przesyłka #{{ $shipment->id }}</h1>
    <p><b>Status:</b> {{ $shipment->status }}</p>
    <p><b>Tracking:</b> {{ $shipment->tracking_number }}</p>
    <p><b>Wymiary:</b> {{ $shipment->length_cm }} x {{ $shipment->width_cm }} x {{ $shipment->height_cm }} cm</p>
    <p><b>Waga:</b> {{ $shipment->weight_kg }} kg</p>
    <p><b>Waga do wyceny:</b> {{ $shipment->billing_weight_kg }} kg</p>
    <p><b>Utworzono:</b> {{ $shipment->created_at }}</p>
    <pre>{{ $shipment->details }}</pre>
    <a href="{{ route('shipments.index') }}" class="btn btn-secondary mt-3">Powrót do listy</a>
</div>
@endsection
