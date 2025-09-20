@extends('layouts.app')

@section('title', 'Edit Quote')

@section('content')
<div class="max-w-7xl mx-auto"
     x-data="quoteForm({
        items: {{ $items->toJson() }},
        lineItems: {{ json_encode(old('quote_items', $quote->items->map(function ($line) {
            return [
                'item_id'    => $line->item_id,
                'quantity'   => (float)$line->quantity,
                'unit_price' => (float)$line->unit_price,
            ];
        }))) }},
        currencySymbol: '{{ currency_symbol() }}'
     })">
    <form action="{{ route('quotes.update', $quote) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-macgray-800">Edit Quote {{ $quote->quote_number }}</h1>
            <div class="flex space-x-2">
                 <a href="{{ route('quotes.index') }}" class="px-5 py-2 text-sm font-medium text-macgray-700 rounded-md hover:bg-macgray-100">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-macblue-600 text-white rounded-md hover:bg-macblue-700 transition-colors">
                    Update Quote
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-macgray-200">
            <div class="p-6">
                {{-- Form content remains the same --}}
                @include('quotes.partials.form')
            </div>
        </div>
    </form>
</div>

{{-- We will create a partial for the JS to keep it clean --}}
@include('quotes.partials.script')

@endsection