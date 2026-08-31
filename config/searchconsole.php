<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Service account key
    |--------------------------------------------------------------------------
    |
    | Absolute path to the Google service-account JSON key file. Keep it OUT
    | of the web root and out of version control. Default location:
    | storage/app/google/gsc.json
    |
    */
    'key_path' => env('GSC_KEY_PATH', storage_path('app/google/gsc.json')),

    /*
    |--------------------------------------------------------------------------
    | Property (site URL)
    |--------------------------------------------------------------------------
    |
    | Must match the property EXACTLY as it appears in Search Console:
    |   URL-prefix property: https://www.reviewsbypeople.com/   (trailing slash)
    |   Domain property:     sc-domain:reviewsbypeople.com
    |
    */
    'property' => env('GSC_PROPERTY', 'https://www.reviewsbypeople.com/'),

    /*
    |--------------------------------------------------------------------------
    | Sitemap URL submitted by `gsc:sitemap`
    |--------------------------------------------------------------------------
    */
    'sitemap_url' => env('GSC_SITEMAP_URL', rtrim(env('GSC_PROPERTY', 'https://www.reviewsbypeople.com/'), '/') . '/sitemap.xml'),

    /*
    |--------------------------------------------------------------------------
    | Data lag
    |--------------------------------------------------------------------------
    |
    | Search Console finalises data ~2-3 days late. `gsc:sync` never requests
    | dates newer than today minus this many days.
    |
    */
    'lag_days' => (int) env('GSC_LAG_DAYS', 3),

];
