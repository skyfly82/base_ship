@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Faktury</h1>
    <table class="table">
        <thead>
            <tr><th>Nr</th><th>Kwota brutto</th><th>Data wystawienia</th><th>Akcja</th></tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->invoice_number }}</td>
                <td>{{ $invoice->amount_gross }}</td>
                <td>{{ $invoice->issue_date }}</td>
                <td>
                    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-primary btn-sm">Szczegóły</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
