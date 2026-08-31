<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * One row = one (date, page, query, country, device) tuple from
 * Search Console's Search Analytics report, populated by `gsc:sync`.
 *
 * @property \Illuminate\Support\Carbon $date
 * @property string|null $page
 * @property string|null $query
 * @property int $clicks
 * @property int $impressions
 * @property float $ctr
 * @property float $position
 */
class GscMetric extends Model
{
    protected $table = 'gsc_metrics';

    protected $guarded = [];

    protected $casts = [
        'date'        => 'date',
        'clicks'      => 'integer',
        'impressions' => 'integer',
        'ctr'         => 'float',
        'position'    => 'float',
    ];

    /** Build the natural-key hash for a metrics row. */
    public static function hash(string $date, ?string $page, ?string $query, ?string $country = null, ?string $device = null): string
    {
        return md5(implode('|', [$date, $page, $query, $country, $device]));
    }

    /** Rows for pages sitting in "striking distance" (avg position between $min and $max). */
    public function scopeStrikingDistance($q, float $min = 5.0, float $max = 20.0)
    {
        return $q->whereBetween('position', [$min, $max]);
    }
}
