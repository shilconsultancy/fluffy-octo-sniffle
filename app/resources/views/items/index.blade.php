@extends('layouts.app')

@section('title', 'Items')

@section('content')
<div class="max-w-7xl mx-auto">

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-macgray-200">
        <div class="p-6 border-b border-macgray-200 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-macgray-800">Items & Services</h2>
                <p class="text-sm text-macgray-500 mt-1">Manage the products and services you sell.</p>
            </div>
            <a href="{{ route('items.create') }}" class="px-4 py-2 bg-macblue-600 text-white rounded-md hover:bg-macblue-700 transition-colors flex items-center space-x-2">
                <i data-feather="plus" class="w-4 h-4"></i>
                <span>Add New Item</span>
            </a>
        </div>

        @if ($items->isEmpty())
            <div class="p-12 text-center">
                <i data-feather="box" class="mx-auto h-12 w-12 text-macgray-400"></i>
                <h3 class="mt-2 text-sm font-medium text-macgray-900">No items found</h3>
                <p class="mt-1 text-sm text-macgray-500">Get started by creating your first item.</p>
                <div class="mt-6">
                    <a href="{{ route('items.create') }}" class="px-4 py-2 bg-macblue-600 text-white rounded-md hover:bg-macblue-700 transition-colors flex items-center space-x-2 mx-auto max-w-xs justify-center">
                        <i data-feather="plus" class="w-4 h-4"></i>
                        <span>Add New Item</span>
                    </a>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-macgray-200">
                    <thead class="bg-macgray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Sale Price</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Purchase Price</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Edit</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-macgray-200">
                        @foreach ($items as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-macgray-900">{{ $item->name }}</div>
                                @if($item->sku) <div class="text-xs text-macgray-500">SKU: {{ $item->sku }}</div> @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-macgray-500 capitalize">{{ $item->type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-macgray-500">{{ setting('financial_base_currency', 'USD') }} {{ number_format($item->sale_price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-macgray-500">{{ $item->purchase_price ? setting('financial_base_currency', 'USD') . ' ' . number_format($item->purchase_price, 2) : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-4">
                                    <a href="{{ route('items.edit', $item) }}" class="text-macblue-600 hover:text-macblue-900">Edit</a>
                                    <form action="{{ route('items.destroy', $item) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-macgray-200">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>
@endsection