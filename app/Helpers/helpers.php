<?php

use App\Models\Country;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

if (!function_exists('get_cached_countries')) {
    function get_cached_countries(): Collection
    {
        return Cache::remember(key: Country::$forEverCachedKey . '-active', ttl: 60 * 5, callback: function () {
            return Country::query()
                ->with([
                    'cities' => fn($query) => $query->active()
                ])
                ->active()
                ->get();
        });
    }


}
