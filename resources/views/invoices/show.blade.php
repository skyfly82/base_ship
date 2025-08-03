@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Faktura {{ $invoice->invoice_number }}</h1>
    <p><b>Data wystawienia:</b> {{ $invoice->issue_date }}</p>
    <p><b>Okres:</b> {{ $invoice->billing_period_start }} - {{ $invoice->billing_period_end }}</p>
    <p><b>Kwota netto:</b> {{ $invoice->amount_net }} {{ $invoice->currency }}</p>
    <p><b>VAT:</b> {{ $invoice->amount_vat }} {{ $invoice->currency }}</p>
    <p><b>Kwota brutto:</b> {{ $invoice->amount_gross }} {{ $invoice->currency }}</p>
    <pre>{{ $invoice->details }}</pre>
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary mt-3">Powrót do listy</a>
</div>
@endsection
