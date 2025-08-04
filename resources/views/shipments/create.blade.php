@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nadaj paczkę (InPost)</h2>
    <form action="{{ route('shipments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Imię odbiorcy</label>
            <input type="text" name="receiver_first_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nazwisko odbiorcy</label>
            <input type="text" name="receiver_last_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Telefon odbiorcy</label>
            <input type="text" name="receiver_phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email odbiorcy</label>
            <input type="email" name="receiver_email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kod Paczkomatu (np. WAW100M)</label>
            <input type="text" name="inpost_point" class="form-control" required>
            <small class="text-muted">Kod znajdziesz na <a href="https://inpost.pl/znajdz-paczkomat" target="_blank">inpost.pl/znajdz-paczkomat</a></small>
        </div>
        <div class="mb-3">
            <label class="form-label">Rozmiar paczki</label>
            <select name="size" class="form-control" required>
                <option value="">Wybierz...</option>
                <option value="A">A (8 x 38 x 64 cm)</option>
                <option value="B">B (19 x 38 x 64 cm)</option>
                <option value="C">C (41 x 38 x 64 cm)</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Waga [kg]</label>
            <input type="number" step="0.01" name="weight_kg" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Nadaj paczkę</button>
        <a href="{{ route('shipments.index') }}" class="btn btn-secondary">Anuluj</a>
    </form>
</div>
@endsection
