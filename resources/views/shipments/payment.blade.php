@extends('layouts.app')

@section('content')
    <h2>Płatność za nadanie paczki</h2>
    <form method="POST" action="{{ route('shipments.pay', $shipment) }}">
        @csrf
        <button type="submit">Opłaciłem – nadaj paczkę</button>
    </form>
@endsection
