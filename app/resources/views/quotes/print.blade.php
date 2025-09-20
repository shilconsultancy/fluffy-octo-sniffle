@extends('layouts.print')

@section('title', 'Quote ' . $quote->quote_number)

@section('content')
    @include('quotes.partials.print-layout')

    {{-- SCRIPT TO TRIGGER PRINT DIALOG --}}
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
@endsection