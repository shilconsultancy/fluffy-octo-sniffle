<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
    /**
     * Get a setting value for the current user's organization.
     * Caches the settings for performance.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        if (!Auth::check()) {
            return $default;
        }

        $organization = Auth::user()->organization;

        // Create a unique cache key for each organization
        $cacheKey = "settings.org.{$organization->id}";

        $settings = Cache::rememberForever($cacheKey, function () use ($organization) {
            return $organization->settings()->pluck('value', 'key')->all();
        });

        return $settings[$key] ?? $default;
    }
}