@extends('layouts.app')

@section('title', 'Quote ' . $quote->quote_number)

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Action Buttons --}}
    <div class="flex justify-end space-x-2 mb-4">
        <a href="{{ route('quotes.index') }}" class="px-4 py-2 text-sm bg-macgray-200 rounded-md hover:bg-macgray-300">Back to Quotes</a>
        <a href="{{ route('quotes.edit', $quote) }}" class="px-4 py-2 text-sm bg-macgray-200 rounded-md hover:bg-macgray-300">Edit</a>
        <a href="{{ route('quotes.print', $quote) }}" target="_blank" class="px-4 py-2 text-sm bg-macblue-600 text-white rounded-md hover:bg-macblue-700">Print / PDF</a>
    </div>

    {{-- We will include the print view directly to avoid code duplication --}}
    <div class="bg-white rounded-xl shadow-sm border border-macgray-200">
        @include('quotes.partials.print-layout')
    </div>
</div>
@endsection