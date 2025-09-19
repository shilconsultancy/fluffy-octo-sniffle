@extends('layouts.app')

@section('title', 'Settings')

@section('content')
{{-- Read the 'tab' query parameter from the URL, defaulting to 'company' --}}
<div class="max-w-7xl mx-auto" x-data="{ activePage: '{{ request()->query('tab', 'company') }}' }">
    <div class="flex flex-col md:flex-row md:space-x-6">

        <div class="md:w-1/3 lg:w-1/4 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-macgray-200 p-4">
                <nav class="space-y-4">
                    <a href="#" @click.prevent="activePage = 'company'" :class="{'bg-macblue-50 text-macblue-700 font-semibold': activePage === 'company', 'text-macgray-600 hover:bg-macgray-50': activePage !== 'company'}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <i data-feather="briefcase" class="mr-3 h-5 w-5"></i> Company Settings
                    </a>
                    <a href="#" @click.prevent="activePage = 'profile'" :class="{'bg-macblue-50 text-macblue-700 font-semibold': activePage === 'profile', 'text-macgray-600 hover:bg-macgray-50': activePage !== 'profile'}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <i data-feather="user" class="mr-3 h-5 w-5"></i> Profile Settings
                    </a>
                    <a href="#" @click.prevent="activePage = 'financial'" :class="{'bg-macblue-50 text-macblue-700 font-semibold': activePage === 'financial', 'text-macgray-600 hover:bg-macgray-50': activePage !== 'financial'}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <i data-feather="dollar-sign" class="mr-3 h-5 w-5"></i> Financial Settings
                    </a>
                    <a href="#" @click.prevent="activePage = 'user_roles'" :class="{'bg-macblue-50 text-macblue-700 font-semibold': activePage === 'user_roles', 'text-macgray-600 hover:bg-macgray-50': activePage !== 'user_roles'}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <i data-feather="users" class="mr-3 h-5 w-5"></i> User & Role Management
                    </a>
                    <a href="#" @click.prevent="activePage = 'notifications'" :class="{'bg-macblue-50 text-macblue-700 font-semibold': activePage === 'notifications', 'text-macgray-600 hover:bg-macgray-50': activePage !== 'notifications'}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <i data-feather="bell" class="mr-3 h-5 w-5"></i> Notifications
                    </a>
                    <a href="#" @click.prevent="activePage = 'integrations'" :class="{'bg-macblue-50 text-macblue-700 font-semibold': activePage === 'integrations', 'text-macgray-600 hover:bg-macgray-50': activePage !== 'integrations'}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <i data-feather="link" class="mr-3 h-5 w-5"></i> Integration Settings
                    </a>
                     <a href="#" @click.prevent="activePage = 'compliance'" :class="{'bg-macblue-50 text-macblue-700 font-semibold': activePage === 'compliance', 'text-macgray-600 hover:bg-macgray-50': activePage !== 'compliance'}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <i data-feather="check-square" class="mr-3 h-5 w-5"></i> Compliance & Audit
                    </a>
                     <a href="#" @click.prevent="activePage = 'customization'" :class="{'bg-macblue-50 text-macblue-700 font-semibold': activePage === 'customization', 'text-macgray-600 hover:bg-macgray-50': activePage !== 'customization'}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <i data-feather="edit" class="mr-3 h-5 w-5"></i> Customization
                    </a>
                     <a href="#" @click.prevent="activePage = 'backup'" :class="{'bg-macblue-50 text-macblue-700 font-semibold': activePage === 'backup', 'text-macgray-600 hover:bg-macgray-50': activePage !== 'backup'}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <i data-feather="database" class="mr-3 h-5 w-5"></i> Backup & Security
                    </a>
                     <a href="#" @click.prevent="activePage = 'advanced'" :class="{'bg-macblue-50 text-macblue-700 font-semibold': activePage === 'advanced', 'text-macgray-600 hover:bg-macgray-50': activePage !== 'advanced'}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <i data-feather="settings" class="mr-3 h-5 w-5"></i> Advanced Features
                    </a>
                </nav>
            </div>
        </div>

        <div class="flex-1 mt-6 md:mt-0">
             @if (session('status') === 'settings-updated')
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                    <span class="block sm:inline">Settings have been updated successfully!</span>
                </div>
            @endif

            <div x-show="activePage === 'company'" style="display: none;">
                <form action="{{ route('settings.company.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Hidden input to send the active tab name --}}
                    <input type="hidden" name="active_tab" value="company">
                    <div class="bg-white rounded-xl shadow-sm border border-macgray-200">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-macgray-800">Company Settings</h2>
                            <p class="text-sm text-macgray-500 mt-1">Manage your organization's core details and branding.</p>
                            <div class="mt-6 space-y-6">
                                <div class="space-y-4 p-4 border rounded-lg">
                                    <h3 class="font-medium text-macgray-800">Company Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="company_name" class="block text-sm font-medium text-macgray-700">Company Name</label>
                                            <input type="text" name="company_name" id="company_name" value="{{ setting('company_name', Auth::user()->organization?->name) }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="company_registration_number" class="block text-sm font-medium text-macgray-700">Registration Number</label>
                                            <input type="text" name="company_registration_number" id="company_registration_number" value="{{ setting('company_registration_number') }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="company_address" class="block text-sm font-medium text-macgray-700">Address</label>
                                        <textarea name="company_address" id="company_address" rows="3" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">{{ setting('company_address') }}</textarea>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="company_phone" class="block text-sm font-medium text-macgray-700">Phone Number</label>
                                            <input type="tel" name="company_phone" id="company_phone" value="{{ setting('company_phone') }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="company_email" class="block text-sm font-medium text-macgray-700">Email Address</label>
                                            <input type="email" name="company_email" id="company_email" value="{{ setting('company_email') }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="company_website" class="block text-sm font-medium text-macgray-700">Website</label>
                                        <input type="url" name="company_website" id="company_website" value="{{ setting('company_website') }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                    </div>
                                </div>
                                <div class="space-y-4 p-4 border rounded-lg">
                                     <h3 class="font-medium text-macgray-800">Logo & Branding</h3>
                                     <div>
                                        <label class="block text-sm font-medium text-macgray-700">Company Logo</label>
                                        <div class="mt-2 flex items-center space-x-4">
                                            @if(setting('company_logo'))
                                                <img src="{{ asset('storage/' . setting('company_logo')) }}" alt="Company Logo" class="h-16 w-16 rounded-lg object-cover">
                                            @endif
                                            <input type="file" name="company_logo" id="company_logo" class="text-sm">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="company_branding_color" class="block text-sm font-medium text-macgray-700">Branding Color</label>
                                        <input type="color" name="company_branding_color" id="company_branding_color" value="{{ setting('company_branding_color', '#3d6bff') }}" class="mt-1 h-10 w-20 block rounded-md border-macgray-300 shadow-sm">
                                    </div>
                                </div>
                                <div class="space-y-4 p-4 border rounded-lg">
                                    <h3 class="font-medium text-macgray-800">Language, Region & Formats</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="company_language" class="block text-sm font-medium text-macgray-700">Language Preference</label>
                                            <select name="company_language" id="company_language" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                                <option value="en" @selected(setting('company_language') == 'en')>English</option>
                                                <option value="bn" @selected(setting('company_language') == 'bn')>Bengali</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="company_regional_format" class="block text-sm font-medium text-macgray-700">Regional Format</label>
                                            <select name="company_regional_format" id="company_regional_format" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                                 <option value="en-US" @selected(setting('company_regional_format') == 'en-US')>United States (mm/dd/yyyy)</option>
                                                 <option value="en-GB" @selected(setting('company_regional_format') == 'en-GB')>United Kingdom (dd/mm/yyyy)</option>
                                                 <option value="bn-BD" @selected(setting('company_regional_format') == 'bn-BD')>Bangladesh (dd/mm/yyyy)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="company_timezone" class="block text-sm font-medium text-macgray-700">Time Zone</label>
                                        <select name="company_timezone" id="company_timezone" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                            <option value="Asia/Dhaka" @selected(setting('company_timezone') == 'Asia/Dhaka')>(GMT+6:00) Dhaka</option>
                                            <option value="America/New_York" @selected(setting('company_timezone') == 'America/New_York')>(GMT-4:00) New York</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-macgray-50 px-6 py-4 text-right rounded-b-xl border-t">
                            <button type="submit" class="px-5 py-2 bg-macblue-600 text-white rounded-md hover:bg-macblue-700 transition-colors">
                                Save Company Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div x-show="activePage === 'profile'" style="display: none;">
                <form action="{{ route('settings.profile.update') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     {{-- Hidden input to send the active tab name --}}
                    <input type="hidden" name="active_tab" value="profile">
                    <div class="bg-white rounded-xl shadow-sm border border-macgray-200">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-macgray-800">Profile Settings</h2>
                            <p class="text-sm text-macgray-500 mt-1">Manage your personal information and security.</p>
                             <div class="mt-6 space-y-6">
                                <div class="space-y-4 p-4 border rounded-lg">
                                    <h3 class="font-medium text-macgray-800">Personal Details</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-macgray-700">Full Name</label>
                                            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-macgray-700">Phone</label>
                                            <input type="tel" name="phone" id="phone" value="{{ old('phone', Auth::user()->phone) }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-macgray-700">Email Address</label>
                                        <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                    </div>
                                     <div>
                                        <label class="block text-sm font-medium text-macgray-700">Profile Picture</label>
                                        <div class="mt-2 flex items-center space-x-4">
                                            @if(Auth::user()->avatar)
                                                <img src="{{ Auth::user()->avatar_url }}" alt="User Avatar" class="h-16 w-16 rounded-full object-cover">
                                            @endif
                                            <input type="file" name="avatar" id="avatar" class="text-sm">
                                        </div>
                                    </div>
                                </div>
                                 <div class="space-y-4 p-4 border rounded-lg">
                                    <h3 class="font-medium text-macgray-800">Password</h3>
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-macgray-700">Current Password</label>
                                        <input type="password" name="current_password" id="current_password" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                        @error('current_password', 'updatePassword') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-macgray-700">New Password</label>
                                        <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                         @error('password', 'updatePassword') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-macgray-700">Confirm New Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-macgray-50 px-6 py-4 text-right rounded-b-xl border-t">
                            <button type="submit" class="px-5 py-2 bg-macblue-600 text-white rounded-md hover:bg-macblue-700 transition-colors">
                                Save Profile Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div x-show="activePage === 'financial'" style="display: none;">
                 <form action="{{ route('settings.financial.update') }}" method="POST">
                    @csrf
                    {{-- Hidden input to send the active tab name --}}
                    <input type="hidden" name="active_tab" value="financial">
                    <div class="bg-white rounded-xl shadow-sm border border-macgray-200">
                        <div class="p-6">
                             <h2 class="text-xl font-semibold text-macgray-800">Financial Settings</h2>
                            <p class="text-sm text-macgray-500 mt-1">Configure your organization's financial backbone.</p>
                            <div class="mt-6 space-y-6">
                                <div class="space-y-4 p-4 border rounded-lg">
                                    <h3 class="font-medium text-macgray-800">Currency Settings</h3>
                                    <div>
                                        <label for="financial_base_currency" class="block text-sm font-medium text-macgray-700">Base Currency</label>
                                        <select id="financial_base_currency" name="financial_base_currency" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                            <option value="USD" @selected(setting('financial_base_currency', 'USD') == 'USD')>USD - United States Dollar</option>
                                            <option value="EUR" @selected(setting('financial_base_currency') == 'EUR')>EUR - Euro</option>
                                            <option value="GBP" @selected(setting('financial_base_currency') == 'GBP')>GBP - British Pound</option>
                                            <option value="BDT" @selected(setting('financial_base_currency') == 'BDT')>BDT - Bangladeshi Taka</option>
                                            <option value="INR" @selected(setting('financial_base_currency') == 'INR')>INR - Indian Rupee</option>
                                        </select>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                             <input id="financial_multi_currency" name="financial_multi_currency" type="checkbox" @checked(setting('financial_multi_currency') == 'enabled') class="focus:ring-macblue-500 h-4 w-4 text-macblue-600 border-macgray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="financial_multi_currency" class="font-medium text-macgray-700">Enable Multi-Currency</label>
                                            <p class="text-macgray-500">Allow transactions in multiple currencies.</p>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="financial_exchange_rate_source" class="block text-sm font-medium text-macgray-700">Exchange Rate Source</label>
                                         <select id="financial_exchange_rate_source" name="financial_exchange_rate_source" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                            <option value="manual" @selected(setting('financial_exchange_rate_source') == 'manual')>Manual Entry</option>
                                            <option value="api" @selected(setting('financial_exchange_rate_source') == 'api')>Automatic (API)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-y-4 p-4 border rounded-lg">
                                    <h3 class="font-medium text-macgray-800">Tax Settings</h3>
                                     <div>
                                        <label for="financial_default_tax_rate" class="block text-sm font-medium text-macgray-700">Default Tax Rate (%)</label>
                                        <input type="number" step="0.01" min="0" max="100" name="financial_default_tax_rate" id="financial_default_tax_rate" value="{{ setting('financial_default_tax_rate', '0') }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm" placeholder="e.g., 15">
                                    </div>
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                             <input id="financial_tax_inclusive_pricing" name="financial_tax_inclusive_pricing" type="checkbox" @checked(setting('financial_tax_inclusive_pricing') == 'inclusive') class="focus:ring-macblue-500 h-4 w-4 text-macblue-600 border-macgray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="financial_tax_inclusive_pricing" class="font-medium text-macgray-700">Tax Inclusive or Exclusive Pricing</label>
                                            <p class="text-macgray-500">Check if item prices already include tax.</p>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-macgray-700">Multiple Tax Rates</label>
                                        <p class="text-sm text-macgray-500 mt-1">Functionality to create and manage multiple tax rates (e.g., VAT, GST) will be added here.</p>
                                    </div>
                                </div>
                                <div class="space-y-4 p-4 border rounded-lg">
                                    <h3 class="font-medium text-macgray-800">Fiscal Year</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="financial_fiscal_year_start" class="block text-sm font-medium text-macgray-700">Fiscal Year Start</label>
                                            <select id="financial_fiscal_year_start" name="financial_fiscal_year_start" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                                @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                                    <option value="{{ $month }}" @selected(setting('financial_fiscal_year_start', 'January') == $month)>{{ $month }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="financial_accounting_period" class="block text-sm font-medium text-macgray-700">Accounting Periods</label>
                                            <select id="financial_accounting_period" name="financial_accounting_period" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                                 <option value="monthly" @selected(setting('financial_accounting_period') == 'monthly')>Monthly</option>
                                                 <option value="quarterly" @selected(setting('financial_accounting_period') == 'quarterly')>Quarterly</option>
                                                 <option value="annually" @selected(setting('financial_accounting_period') == 'annually')>Annually</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-4 p-4 border rounded-lg">
                                    <h3 class="font-medium text-macgray-800">Invoice & Billing</h3>
                                    <div>
                                        <label for="financial_invoice_number_format" class="block text-sm font-medium text-macgray-700">Invoice Numbering Format</label>
                                        <input type="text" name="financial_invoice_number_format" id="financial_invoice_number_format" value="{{ setting('financial_invoice_number_format', 'INV-{YYYY}-{NNNN}') }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                        <p class="text-xs text-macgray-500 mt-1">{YYYY} = Year, {NNNN} = Sequence Number</p>
                                    </div>
                                    <div>
                                        <label for="financial_default_payment_terms" class="block text-sm font-medium text-macgray-700">Default Payment Terms (Days)</label>
                                        <input type="number" min="0" name="financial_default_payment_terms" id="financial_default_payment_terms" value="{{ setting('financial_default_payment_terms', '30') }}" class="mt-1 block w-full rounded-md border-macgray-300 shadow-sm sm:text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-macgray-50 px-6 py-4 text-right rounded-b-xl border-t">
                            <button type="submit" class="px-5 py-2 bg-macblue-600 text-white rounded-md hover:bg-macblue-700 transition-colors">
                                Save Financial Settings
                            </button>
                        </div>
                    </div>
                 </form>
            </div>

            <div x-show="activePage === 'user_roles'" style="display: none;" class="p-6"><h2 class="text-xl font-semibold text-macgray-800">User & Role Management</h2></div>
            <div x-show="activePage === 'notifications'" style="display: none;" class="p-6"><h2 class="text-xl font-semibold text-macgray-800">Notifications</h2></div>
            <div x-show="activePage === 'integrations'" style="display: none;" class="p-6"><h2 class="text-xl font-semibold text-macgray-800">Integration Settings</h2></div>
            <div x-show="activePage === 'compliance'" style="display: none;" class="p-6"><h2 class="text-xl font-semibold text-macgray-800">Compliance & Audit</h2></div>
            <div x-show="activePage === 'customization'" style="display: none;" class="p-6"><h2 class="text-xl font-semibold text-macgray-800">Customization</h2></div>
            <div x-show="activePage === 'backup'" style="display: none;" class="p-6"><h2 class="text-xl font-semibold text-macgray-800">Backup & Security</h2></div>
            <div x-show="activePage === 'advanced'" style="display: none;" class="p-6"><h2 class="text-xl font-semibold text-macgray-800">Advanced Features</h2></div>

        </div>
    </div>
</div>
<script src="//unpkg.com/alpinejs" defer></script>
@endsection