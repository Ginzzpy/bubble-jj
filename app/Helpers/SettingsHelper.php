<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsHelper
{
    public static function get($key, $default = null)
    {
        $settings = Cache::rememberForever('settings.all', function () {
            return Setting::all()->pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    public static function set($key, $value)
    {
        $setting = Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        // refresh cache
        Cache::forget('settings.all');
        Cache::rememberForever('settings.all', function () {
            return Setting::all()->pluck('value', 'key')->toArray();
        });

        return $setting;
    }

    public static function clearCache()
    {
        Cache::forget('settings.all');
    }
}
