<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('invoices.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="customer_id" class="block text-gray-700 text-sm font-bold mb-2">Customer:</label>
                            <select name="customer_id" id="customer_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="invoice_date" class="block text-gray-700 text-sm font-bold mb-2">Invoice Date:</label>
                            <input type="date" name="invoice_date" id="invoice_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label for="due_date" class="block text-gray-700 text-sm font-bold mb-2">Due Date:</label>
                            <input type="date" name="due_date" id="due_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <h3 class="text-lg font-bold mt-6 mb-2">Invoice Items</h3>
                        <div id="invoice-items-container">
                            <div class="item-row flex space-x-4 mb-2">
                                <input type="text" name="items[0][item_description]" placeholder="Description" class="flex-1 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <input type="number" name="items[0][quantity]" placeholder="Qty" class="w-20 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required min="1">
                                <input type="number" name="items[0][unit_price]" placeholder="Unit Price" step="0.01" class="w-32 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required min="0.01">
                            </div>
                        </div>
                        <button type="button" onclick="addItem()" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Item</button>

                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Create Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        let itemIndex = 1;
        function addItem() {
            const container = document.getElementById('invoice-items-container');
            const itemRow = document.createElement('div');
            itemRow.classList.add('item-row', 'flex', 'space-x-4', 'mb-2');
            itemRow.innerHTML = `
                <input type="text" name="items[${itemIndex}][item_description]" placeholder="Description" class="flex-1 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <input type="number" name="items[${itemIndex}][quantity]" placeholder="Qty" class="w-20 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required min="1">
                <input type="number" name="items[${itemIndex}][unit_price]" placeholder="Unit Price" step="0.01" class="w-32 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required min="0.01">
            `;
            container.appendChild(itemRow);
            itemIndex++;
        }
    </script>
</x-app-layout>