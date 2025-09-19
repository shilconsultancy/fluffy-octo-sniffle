<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

if (! function_exists('setting')) {
    /**
     * Get the value of a setting for the current organization.
     *
     * This helper retrieves a specific setting value from the cache for the
     * currently authenticated user's organization. If the setting is not found,
     * it returns the provided default value. It is robust against users who
     * may not be assigned to an organization.
     *
     * @param  string  $key The key of the setting to retrieve.
     * @param  mixed  $default A default value to return if the key is not found.
     * @return mixed The value of the setting or the default.
     */
    function setting($key, $default = null)
    {
        // First, ensure a user is authenticated.
        if (!Auth::check()) {
            return $default;
        }

        $user = Auth::user();
        $organization = $user->organization;

        // Immediately return the default value if the user has no organization.
        // This is the critical fix to prevent the "id on null" error.
        if (!$organization) {
            return $default;
        }

        // Proceed with retrieving settings only if an organization exists.
        $settings = Cache::rememberForever("settings.org.{$organization->id}", function () use ($organization) {
            // Eager load settings to prevent N+1 query issues and pluck the values.
            return $organization->settings()->pluck('value', 'key');
        });

        // Return the specific setting value, or the default if it doesn't exist.
        return $settings[$key] ?? $default;
    }
}