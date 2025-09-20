<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

if (! function_exists('setting')) {
    /**
     * Get the value of a setting for the current organization.
     */
    function setting($key, $default = null)
    {
        if (!Auth::check()) {
            return $default;
        }

        $user = Auth::user();
        $organization = $user->organization;

        if (!$organization) {
            return $default;
        }

        $settings = Cache::rememberForever("settings.org.{$organization->id}", function () use ($organization) {
            return $organization->settings()->pluck('value', 'key');
        });

        $value = $settings[$key] ?? $default;

        // Debug: Log when settings are accessed
        if ($key === 'company_name' || $key === 'company_logo') {
            \Log::info("Setting accessed: {$key} = " . ($value ?: 'NULL') . " (default: " . ($default ?: 'NULL') . ")");
        }

        return $value;
    }
}

if (! function_exists('currency_symbol')) {
    /**
     * Get the currency symbol for a given currency code.
     *
     * @param  string|null  $currencyCode
     * @return string
     */
    function currency_symbol($currencyCode = null): string
    {
        if ($currencyCode === null) {
            $currencyCode = setting('financial_base_currency', 'USD');
        }

        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'BDT' => '৳',
            'INR' => '₹',
        ];

        return $symbols[$currencyCode] ?? '$';
    }
}