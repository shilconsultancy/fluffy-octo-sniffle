@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-macgray-800">Customers</h1>
        <a href="{{ route('customers.create') }}" class="px-5 py-2 bg-macblue-600 text-white rounded-md hover:bg-macblue-700 transition-colors">
            Add New Customer
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Primary Contact</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-macgray-500 uppercase tracking-wider">Contact Details</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Edit</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-macgray-200">
                        @forelse($customers as $customer)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-macgray-900">{{ $customer->name }}</div>
                                    <div class="text-sm text-macgray-500">{{ ucfirst($customer->contact_type) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-macgray-500">{{ $customer->primary_contact ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-macgray-500">
                                    <div>{{ $customer->email }}</div>
                                    <div>{{ $customer->phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('customers.edit', $customer) }}" class="text-macblue-600 hover:text-macblue-900">Edit</a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-macgray-500">No customers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection