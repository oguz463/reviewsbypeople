<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Redirect extends Model
{
    /** Cache key for the flattened old_url => new_url map. */
    public const CACHE_KEY = 'redirects.map';

    public $timestamps = false;

    protected $guarded = [];

    protected static function booted(): void
    {
        $flush = fn () => Cache::forget(self::CACHE_KEY);

        static::saved($flush);
        static::deleted($flush);
    }
}
