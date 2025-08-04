@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>Płatność za przesyłkę</h2>
    <p>Tu pojawi się integracja z płatnościami (np. Przelewy24, Stripe itd.).</p>
    <form method="POST" action="{{ route('shipments.pay', $shipment->id) }}">
        @csrf
        <button type="submit" class="btn btn-success btn-lg">Symuluj "opłaciłem"</button>
    </form>
    <br>
    <a href="{{ route('shipments.index') }}" class="btn btn-secondary mt-3">Powrót do listy przesyłek</a>
</div>
@endsection
