<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Hijri Calendar Adjustment
    |--------------------------------------------------------------------------
    |
    | Adjust Hijri dates by -1, 0, or +1 day to account for moon sighting
    | differences in your region. Some regions may start the month a day
    | earlier or later than the Um Al-Qura calculation.
    |
    */
    'hijri_adjustment' => env('TANGGALAN_HIJRI_ADJUSTMENT', 0),

    /*
    |--------------------------------------------------------------------------
    | Default Locale
    |--------------------------------------------------------------------------
    |
    | Set the default locale for date formatting.
    | Supported: 'id' (Indonesian), 'en' (English), 'jv' (Javanese), 'ar' (Arabic)
    |
    */
    'locale' => env('TANGGALAN_LOCALE', 'id'),

    /*
    |--------------------------------------------------------------------------
    | Carbon Macros
    |--------------------------------------------------------------------------
    |
    | Enable or disable Carbon macro extensions. When enabled, you can use
    | methods like Carbon::now()->toHijri() and Carbon::now()->getWeton().
    |
    */
    'enable_carbon_macros' => env('TANGGALAN_ENABLE_CARBON_MACROS', true),

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Enable caching for frequently accessed calculations to improve performance.
    | Note: Caching is not yet implemented in the current version.
    |
    */
    'cache' => [
        'enabled' => env('TANGGALAN_CACHE_ENABLED', false),
        'ttl' => env('TANGGALAN_CACHE_TTL', 3600), // 1 hour in seconds
        'driver' => env('TANGGALAN_CACHE_DRIVER', 'file'),
    ],
];
