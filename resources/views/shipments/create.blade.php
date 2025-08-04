@extends('layouts.app')

@section('content')
    <h1>Nadanie paczki przez InPost</h1>
    <form method="POST" action="{{ route('shipments.store') }}">
        @csrf
        <div>
            <label>Odbiorca: Imię</label>
            <input type="text" name="receiver_first_name" required>
        </div>
        <div>
            <label>Odbiorca: Nazwisko</label>
            <input type="text" name="receiver_last_name" required>
        </div>
        <div>
            <label>Email odbiorcy</label>
            <input type="email" name="receiver_email" required>
        </div>
        <div>
            <label>Telefon odbiorcy</label>
            <input type="text" name="receiver_phone" required>
        </div>
        <div>
            <label>Paczkomat docelowy</label>
            <input type="text" name="inpost_point" required placeholder="np. ADA01M">
            <small>Możesz wybrać z listy na stronie lub wpisać kod.</small>
        </div>
        <div>
            <label>Rozmiar paczki</label>
            <select name="size" required>
                <option value="A">A (max 8 x 38 x 64 cm)</option>
                <option value="B">B (max 19 x 38 x 64 cm)</option>
                <option value="C">C (max 41 x 38 x 64 cm)</option>
            </select>
        </div>
        <div>
            <label>Waga [kg]</label>
            <input type="number" step="0.01" name="weight_kg" required>
        </div>
        <div>
            <button type="submit">Dalej: Przejdź do płatności</button>
        </div>
    </form>
@endsection
