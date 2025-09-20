@extends('layouts.app')

@section('title', 'Quotes')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-macgray-800">Quotes</h1>
        <a href="{{ route('quotes.create') }}" class="px-5 py-2 bg-macblue-600 text-white rounded-md hover:bg-macblue-700 transition-colors">
            Create Quote
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-macgray-200">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-macgray-200">
                    <thead class="bg-macgray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Number</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Customer</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-macgray-200">
                        @forelse($quotes as $quote)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-macgray-500">{{ $quote->quote_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-macblue-600">{{ $quote->quote_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-macgray-900">{{ $quote->customer->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ ucfirst($quote->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-macgray-500">{{ currency_symbol() }}{{ number_format($quote->total, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('quotes.show', $quote) }}" class="text-macblue-600 hover:text-macblue-900">View</a>
                                    <a href="{{ route('quotes.edit', $quote) }}" class="text-macblue-600 hover:text-macblue-900 ml-4">Edit</a>
                                    <form action="{{ route('quotes.destroy', $quote) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Are you sure you want to delete this quote?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-macgray-500">No quotes found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             <div class="mt-4">
                {{ $quotes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection