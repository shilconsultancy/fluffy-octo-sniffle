<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('invoices.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="customer_id" class="block font-medium text-sm text-gray-700">{{ __('Customer') }}</label>
                                <select id="customer_id" name="customer_id" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="invoice_number" class="block font-medium text-sm text-gray-700">{{ __('Invoice Number') }}</label>
                                <input type="text" id="invoice_number" name="invoice_number" value="{{ old('invoice_number') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('invoice_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="invoice_date" class="block font-medium text-sm text-gray-700">{{ __('Invoice Date') }}</label>
                                <input type="date" id="invoice_date" name="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('invoice_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="due_date" class="block font-medium text-sm text-gray-700">{{ __('Due Date') }}</label>
                                <input type="date" id="due_date" name="due_date" value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('due_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Invoice Items') }}</h3>
                            <div id="invoice-items" class="mt-4 space-y-4">
                                </div>
                            <button type="button" id="add-item-btn" class="mt-4 text-sm text-indigo-600 hover:text-indigo-900">
                                {{ __('Add another item') }}
                            </button>
                        </div>

                        <div class="mt-8">
                            <label for="notes" class="block font-medium text-sm text-gray-700">{{ __('Notes') }}</label>
                            <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Save Invoice') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addItemBtn = document.getElementById('add-item-btn');
        const itemsContainer = document.getElementById('invoice-items');
        let itemIndex = 0;

        const createItemRow = () => {
            const itemRow = document.createElement('div');
            itemRow.className = 'flex space-x-4 items-center';
            itemRow.innerHTML = `
                <div class="w-1/2">
                    <label class="block font-medium text-sm text-gray-700">{{ __('Item Name') }}</label>
                    <input type="text" name="items[${itemIndex}][item_name]" class="mt-1 block w-full rounded-md shadow-sm border-gray-300" required>
                </div>
                <div class="w-1/4">
                    <label class="block font-medium text-sm text-gray-700">{{ __('Quantity') }}</label>
                    <input type="number" name="items[${itemIndex}][quantity]" class="mt-1 block w-full rounded-md shadow-sm border-gray-300" min="1" required>
                </div>
                <div class="w-1/4">
                    <label class="block font-medium text-sm text-gray-700">{{ __('Unit Price') }}</label>
                    <input type="number" step="0.01" name="items[${itemIndex}][unit_price]" class="mt-1 block w-full rounded-md shadow-sm border-gray-300" min="0" required>
                </div>
            `;
            itemsContainer.appendChild(itemRow);
            itemIndex++;
        };

        addItemBtn.addEventListener('click', createItemRow);

        // Add one item row by default
        createItemRow();
    });
</script>