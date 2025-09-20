<div class="p-8">
    {{-- Header --}}
    <div class="flex justify-between items-start pb-4 border-b">
        {{-- Company Logo & Name --}}
        <div>
            @if(setting('company_logo'))
                <img src="{{ asset('storage/'. setting('company_logo')) }}" alt="{{ setting('company_name') }} Logo" class="h-16 mb-4">
            @endif
            <h2 class="text-2xl font-bold text-macgray-800">{{ setting('company_name', 'Your Company') }}</h2>
            <p class="text-sm text-macgray-500 mt-1">{!! nl2br(e(setting('company_address'))) !!}</p>
        </div>
        {{-- Quote Details --}}
        <div class="text-right">
            <h1 class="text-4xl font-bold text-macgray-800 uppercase">Quote</h1>
            <table class="mt-4 text-sm">
                <tbody>
                    <tr>
                        <td class="pr-4 font-semibold text-macgray-600">Quote #</td>
                        <td class="text-macgray-800">{{ $quote->quote_number }}</td>
                    </tr>
                    <tr>
                        <td class="pr-4 font-semibold text-macgray-600">Quote Date</td>
                        <td class="text-macgray-800">{{ $quote->quote_date->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td class="pr-4 font-semibold text-macgray-600">Expiry Date</td>
                        <td class="text-macgray-800">{{ $quote->expiry_date->format('M d, Y') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Customer & Company Contact Info --}}
    <div class="mt-8 grid grid-cols-2 gap-6">
        <div>
            <h3 class="text-sm font-semibold text-macgray-400 uppercase tracking-wider">Billed To</h3>
            <p class="mt-2 font-semibold text-macgray-800">{{ $quote->customer->name }}</p>
            <p class="text-sm text-macgray-500">{!! nl2br(e($quote->customer->billing_address)) !!}</p>
        </div>
        <div class="text-right text-sm text-macgray-600">
            <h3 class="text-sm font-semibold text-macgray-400 uppercase tracking-wider">Contact Us</h3>
            <div class="mt-2 space-y-1">
                <p>{{ setting('company_email') }}</p>
                <p>{{ setting('company_phone') }}</p>
                <p>{{ setting('company_website') }}</p>
                <p class="pt-2"><strong>Reg No/BIN:</strong> {{ setting('company_registration_number') }}</p>
            </div>
        </div>
    </div>

    {{-- Line Items Table --}}
    <div class="mt-8">
        <table class="min-w-full">
            <thead class="bg-macgray-50 rounded-t-lg">
                <tr>
                    <th class="p-3 text-left text-sm font-semibold text-macgray-800 w-1/2">Item & Description</th>
                    <th class="p-3 text-center text-sm font-semibold text-macgray-800">Qty</th>
                    <th class="p-3 text-right text-sm font-semibold text-macgray-800">Rate</th>
                    <th class="p-3 text-right text-sm font-semibold text-macgray-800">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-macgray-200">
                @foreach($quote->items as $line)
                <tr>
                    <td class="p-3">
                        <p class="font-medium text-macgray-800">{{ $line->item->name }}</p>
                        <p class="text-sm text-macgray-500">{{ $line->description }}</p>
                    </td>
                    <td class="p-3 text-center">{{ $line->quantity }}</td>
                    <td class="p-3 text-right">{{ currency_symbol() }}{{ number_format($line->unit_price, 2) }}</td>
                    <td class="p-3 text-right">{{ currency_symbol() }}{{ number_format($line->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    <div class="mt-8 grid grid-cols-2">
        <div>
             @if($quote->terms)
                <h4 class="text-sm font-semibold text-macgray-500">Terms & Conditions</h4>
                <p class="text-xs text-macgray-600 mt-2">{!! nl2br(e($quote->terms)) !!}</p>
            @endif
        </div>
        <div class="text-right">
             <table class="w-full text-sm">
                 <tbody>
                    <tr>
                        <td class="pr-4 py-2 font-semibold text-macgray-600">Subtotal</td>
                        <td class="text-macgray-800">{{ currency_symbol() }}{{ number_format($quote->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="pr-4 py-2 font-semibold text-macgray-600">Tax (0%)</td>
                        <td class="text-macgray-800">{{ currency_symbol() }}{{ number_format($quote->tax_total, 2) }}</td>
                    </tr>
                    <tr class="font-bold text-base">
                        <td class="pr-4 py-3 border-t-2 border-macgray-800">Total</td>
                        <td class="border-t-2 border-macgray-800">{{ currency_symbol() }}{{ number_format($quote->total, 2) }}</td>
                    </tr>
                 </tbody>
             </table>
        </div>
    </div>
     @if($quote->notes)
        <div class="mt-8 border-t pt-4">
            <h4 class="text-sm font-semibold text-macgray-500">Notes</h4>
            <p class="text-sm text-macgray-600 mt-2">{{ $quote->notes }}</p>
        </div>
    @endif
</div>