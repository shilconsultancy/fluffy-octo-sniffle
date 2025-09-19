<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    /**
     * Display the main settings page.
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Update the Company Settings.
     */
    public function updateCompanySettings(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_registration_number' => 'nullable|string|max:255',
            'company_address' => 'nullable|string',
            'company_phone' => 'nullable|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'company_website' => 'nullable|url|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_branding_color' => 'nullable|string|max:7',
            'company_language' => 'nullable|string|max:10',
            'company_regional_format' => 'nullable|string|max:20',
            'company_timezone' => 'nullable|string|max:255',
            'active_tab' => 'required|string', // For remembering the tab
        ]);

        $user = Auth::user();
        $organization = $user->organization;

        if (!$organization) {
            $organization = Organization::create(['name' => $user->name . '\'s Team']);
            $user->organization_id = $organization->id;
            $user->save();
            $user->refresh();
            $organization = $user->organization;
        }

        if ($request->hasFile('company_logo')) {
            if ($oldLogo = setting('company_logo')) {
                Storage::disk('public')->delete($oldLogo);
            }
            $path = $request->file('company_logo')->store('logos', 'public');
            $validatedData['company_logo'] = $path;
        }
        
        // Unset active_tab before looping through settings
        $activeTab = $validatedData['active_tab'];
        unset($validatedData['active_tab']);

        foreach ($validatedData as $key => $value) {
            $organization->settings()->updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget("settings.org.{$organization->id}");

        return redirect()->route('settings.index', ['tab' => $activeTab])->with('status', 'settings-updated');
    }

    /**
     * Update the User's Profile Settings.
     */
    public function updateProfileSettings(Request $request)
    {
        $user = Auth::user();
        $activeTab = $request->input('active_tab', 'profile');

        if ($request->has('name') || $request->hasFile('avatar')) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'phone' => 'nullable|string|max:20',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $path = $request->file('avatar')->store('avatars', 'public');
                $validatedData['avatar'] = $path;
            }
            $user->update($validatedData);
        }

        if ($request->filled('current_password')) {
            $request->validate([
                'current_password' => 'required|current_password',
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('settings.index', ['tab' => $activeTab])->with('status', 'settings-updated');
    }

    /**
     * Update the Financial Settings.
     */
    public function updateFinancialSettings(Request $request)
    {
        $validatedData = $request->validate([
            // Currency
            'financial_base_currency' => 'nullable|string|max:10',
            'financial_multi_currency' => 'nullable|string',
            'financial_exchange_rate_source' => 'nullable|string',
            // Tax
            'financial_default_tax_rate' => 'nullable|numeric|min:0|max:100',
            'financial_tax_inclusive_pricing' => 'nullable|string',
            // Fiscal Year
            'financial_fiscal_year_start' => 'nullable|string|max:20',
            'financial_accounting_period' => 'nullable|string',
            // Invoice & Billing
            'financial_invoice_number_format' => 'nullable|string|max:255',
            'financial_default_payment_terms' => 'nullable|integer|min:0',
            'active_tab' => 'required|string', // For remembering the tab
        ]);

        $user = Auth::user();
        $organization = $user->organization;
        
        if (!$organization) {
            $organization = Organization::create(['name' => $user->name . '\'s Team']);
            $user->organization_id = $organization->id;
            $user->save();
            $user->refresh();
            $organization = $user->organization;
        }
        
        // Unset active_tab before looping through settings
        $activeTab = $validatedData['active_tab'];
        unset($validatedData['active_tab']);

        // Handle checkbox values
        $validatedData['financial_multi_currency'] = $request->has('financial_multi_currency') ? 'enabled' : 'disabled';
        $validatedData['financial_tax_inclusive_pricing'] = $request->has('financial_tax_inclusive_pricing') ? 'inclusive' : 'exclusive';

        foreach ($validatedData as $key => $value) {
            $organization->settings()->updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget("settings.org.{$organization->id}");

        return redirect()->route('settings.index', ['tab' => $activeTab])->with('status', 'settings-updated');
    }
}