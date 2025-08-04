@extends('layouts.app')

@section('content')
    <h2>Twoje przesyłki</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Status</th>
            <th>Tracking</th>
            <th>Etykieta</th>
        </tr>
        @foreach($shipments as $s)
        <tr>
            <td>{{ $s->id }}</td>
            <td>{{ $s->status }}</td>
            <td>{{ $s->tracking_number }}</td>
            <td>
                @if($s->status === 'created')
                    <a href="{{ route('shipments.label', $s) }}" target="_blank">Pobierz PDF</a>
                @else
                    -
                @endif
            </td>
        </tr>
        @endforeach
    </table>
@endsection
