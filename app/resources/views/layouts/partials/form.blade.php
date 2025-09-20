{{-- Header --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div>
        <label for="customer_id" class="block text-sm font-medium text-macgray-700">Customer</label>
        <select name="customer_id" id="customer_id" required class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
            <option value="">Select a customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" @selected(old('customer_id', $quote->customer_id ?? null) == $customer->id)>{{ $customer->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="quote_date" class="block text-sm font-medium text-macgray-700">Quote Date</label>
        <input type="date" name="quote_date" id="quote_date" value="{{ old('quote_date', isset($quote) ? $quote->quote_date->format('Y-m-d') : now()->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
    </div>
    <div>
        <label for="expiry_date" class="block text-sm font-medium text-macgray-700">Expiry Date</label>
        <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', isset($quote) ? $quote->expiry_date->format('Y-m-d') : now()->addDays(30)->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
    </div>
</div>

{{-- Line Items Table --}}
<div class="mt-8">
    <table class="min-w-full">
        <thead class="border-b border-macgray-300">
            <tr>
                <th class="py-2 text-left text-sm font-semibold text-macgray-800 w-1/2">Item</th>
                <th class="py-2 text-left text-sm font-semibold text-macgray-800">Quantity</th>
                <th class="py-2 text-left text-sm font-semibold text-macgray-800">Price</th>
                <th class="py-2 text-left text-sm font-semibold text-macgray-800">Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <template x-for="(line, index) in lines" :key="index">
                <tr class="border-b border-macgray-200">
                    <td class="py-4 pr-2">
                        <select :name="`quote_items[${index}][item_id]`" x-model.number="line.item_id" @change="updateLine(index)" class="w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                            <option value="">Select an item</option>
                            <template x-for="item in items">
                                <option :value="item.id" x-text="item.name"></option>
                            </template>
                        </select>
                    </td>
                    <td class="py-4 pr-2">
                        <input type="number" :name="`quote_items[${index}][quantity]`" x-model.number="line.quantity" min="1" class="w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                    </td>
                    <td class="py-4 pr-2">
                        <input type="number" :name="`quote_items[${index}][unit_price]`" x-model.number="line.unit_price" step="0.01" min="0" class="w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                    </td>
                    <td class="py-4 pr-2">
                        <span class="py-2" x-text="formatCurrency(line.quantity * line.unit_price)"></span>
                    </td>
                    <td class="py-4">
                        <button type="button" @click="removeLine(index)" class="text-red-500 hover:text-red-700">&times;</button>
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
    <button type="button" @click="addLine" class="mt-4 px-3 py-1 bg-macgray-200 text-sm font-medium rounded-md hover:bg-macgray-300">
        + Add Line
    </button>
</div>

{{-- Footer Totals --}}
<div class="mt-6 flex justify-end">
    <div class="w-full max-w-sm">
        <div class="flex justify-between py-2 border-b">
            <span class="font-semibold text-macgray-800">Subtotal</span>
            <span x-text="formatCurrency(subtotal)"></span>
        </div>
        <div class="flex justify-between py-2 border-b">
            <span class="font-semibold text-macgray-800">Tax (0%)</span>
            <span x-text="formatCurrency(tax)"></span>
        </div>
        <div class="flex justify-between py-3 font-bold text-lg">
            <span class="text-macgray-900">Total</span>
            <span x-text="formatCurrency(total)"></span>
        </div>
    </div>
</div>