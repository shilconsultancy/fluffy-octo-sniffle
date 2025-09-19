@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('customers.update', $customer) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-xl shadow-sm border border-macgray-200">
            <div class="p-6 border-b border-macgray-200">
                <h2 class="text-xl font-semibold text-macgray-800">Edit Customer</h2>
                <p class="text-sm text-macgray-500 mt-1">Update the details for {{ $customer->name }}.</p>
            </div>
            <div class="p-6 space-y-6">
                 <div>
                    <label class="block text-sm font-medium text-macgray-700">Contact Type</label>
                    <div class="mt-2 space-x-4">
                        <label class="inline-flex items-center"><input type="radio" name="contact_type" value="individual" @checked(old('contact_type', $customer->contact_type) == 'individual') class="form-radio"> <span class="ml-2">Individual</span></label>
                        <label class="inline-flex items-center"><input type="radio" name="contact_type" value="business" @checked(old('contact_type', $customer->contact_type) == 'business') class="form-radio"> <span class="ml-2">Business</span></label>
                    </div>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-macgray-700">Full Name / Company Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" required class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                    @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="primary_contact" class="block text-sm font-medium text-macgray-700">Primary Contact</label>
                    <input type="text" name="primary_contact" id="primary_contact" value="{{ old('primary_contact', $customer->primary_contact) }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                    @error('primary_contact') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-macgray-700">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                        @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-macgray-700">Phone Number</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                        @error('phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
                 <div>
                    <label for="billing_address" class="block text-sm font-medium text-macgray-700">Billing Address</label>
                    <textarea name="billing_address" id="billing_address" rows="3" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">{{ old('billing_address', $customer->billing_address) }}</textarea>
                </div>
                 <div>
                    <label for="shipping_address" class="block text-sm font-medium text-macgray-700">Shipping Address</label>
                    <textarea name="shipping_address" id="shipping_address" rows="3" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">{{ old('shipping_address', $customer->shipping_address) }}</textarea>
                </div>
                 <div>
                    <label for="notes" class="block text-sm font-medium text-macgray-700">Other Important Details</label>
                    <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">{{ old('notes', $customer->notes) }}</textarea>
                </div>
                <div>
                    <label for="tax_id_number" class="block text-sm font-medium text-macgray-700">Tax ID Number (Optional)</label>
                    <input type="text" name="tax_id_number" id="tax_id_number" value="{{ old('tax_id_number', $customer->tax_id_number) }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                </div>
            </div>
            <div class="bg-macgray-50 px-6 py-4 flex items-center justify-end space-x-4 rounded-b-xl border-t">
                <a href="{{ route('customers.index') }}" class="px-5 py-2 text-sm font-medium text-macgray-700 rounded-md hover:bg-macgray-100">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-macblue-600 text-white rounded-md hover:bg-macblue-700 transition-colors">
                    Update Customer
                </button>
            </div>
        </div>
    </form>
</div>
@endsection