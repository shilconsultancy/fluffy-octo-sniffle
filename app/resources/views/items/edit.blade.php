@extends('layouts.app')

@section('title', 'Edit Item')

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('items.update', $item) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-xl shadow-sm border border-macgray-200">
            <div class="p-6 border-b border-macgray-200">
                <h2 class="text-xl font-semibold text-macgray-800">Edit Item</h2>
                <p class="text-sm text-macgray-500 mt-1">Update the details for this product or service.</p>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-macgray-700">Item Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $item->name) }}" required class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                        @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                     <div>
                        <label for="sku" class="block text-sm font-medium text-macgray-700">SKU (Stock Keeping Unit)</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $item->sku) }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                        @error('sku') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
                 <div>
                    <label for="description" class="block text-sm font-medium text-macgray-700">Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">{{ old('description', $item->description) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-macgray-700">Type</label>
                    <div class="mt-2 space-x-4">
                        <label class="inline-flex items-center"><input type="radio" name="type" value="product" @checked(old('type', $item->type) == 'product') class="form-radio"> <span class="ml-2">Product</span></label>
                        <label class="inline-flex items-center"><input type="radio" name="type" value="service" @checked(old('type', $item->type) == 'service') class="form-radio"> <span class="ml-2">Service</span></label>
                    </div>
                </div>
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="sale_price" class="block text-sm font-medium text-macgray-700">Sale Price</label>
                        <input type="number" step="0.01" min="0" name="sale_price" id="sale_price" value="{{ old('sale_price', $item->sale_price) }}" required class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                         @error('sale_price') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                     <div>
                        <label for="purchase_price" class="block text-sm font-medium text-macgray-700">Purchase Price (Optional)</label>
                        <input type="number" step="0.01" min="0" name="purchase_price" id="purchase_price" value="{{ old('purchase_price', $item->purchase_price) }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                         @error('purchase_price') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="bg-macgray-50 px-6 py-4 flex items-center justify-end space-x-4 rounded-b-xl border-t">
                <a href="{{ route('items.index') }}" class="px-5 py-2 text-sm font-medium text-macgray-700 rounded-md hover:bg-macgray-100">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-macblue-600 text-white rounded-md hover:bg-macblue-700 transition-colors">
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</div>
@endsection