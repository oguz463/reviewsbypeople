<?php

namespace App\Console\Commands;

use App\Models\GscMetric;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Reads whatever `gsc:sync` has already stored — does not hit the API.
 * Run `gsc:sync` first.
 */
class GscReport extends Command
{
    protected $signature = 'gsc:report
        {--days=28 : Window (ending at the newest synced date)}
        {--min-impressions=30 : Ignore rows below this impression count}
        {--limit=40 : Rows per section}';

    protected $description = 'Striking-distance queries and low-CTR pages from synced Search Console data';

    public function handle(): int
    {
        $newest = GscMetric::max('date');

        if (! $newest) {
            $this->error('No data in gsc_metrics — run `php artisan gsc:sync` first.');

            return self::FAILURE;
        }

        $since   = \Illuminate\Support\Carbon::parse($newest)->subDays((int) $this->option('days'))->toDateString();
        $minImpr = (int) $this->option('min-impressions');
        $limit   = (int) $this->option('limit');

        $this->info("Window: {$since} .. {$newest}");
        $this->newLine();

        /* -------- Striking-distance queries (avg position 5–20) -------- */
        $striking = GscMetric::query()
            ->selectRaw('`query`,
                SUM(clicks) as clicks,
                SUM(impressions) as impressions,
                ROUND(SUM(clicks) / NULLIF(SUM(impressions),0) * 100, 1) as ctr_pct,
                ROUND(SUM(position * impressions) / NULLIF(SUM(impressions),0), 1) as avg_position')
            ->whereNotNull('query')
            ->where('date', '>=', $since)
            ->groupBy('query')
            ->havingRaw('avg_position BETWEEN 5 AND 20')
            ->havingRaw('SUM(impressions) >= ?', [$minImpr])
            ->orderByDesc('impressions')
            ->limit($limit)
            ->get();

        $this->line('<comment>STRIKING DISTANCE — queries at position 5–20 (biggest quick wins)</comment>');
        $this->table(
            ['Query', 'Impr.', 'Clicks', 'CTR %', 'Avg pos'],
            $striking->map(fn ($r) => [$r->query, $r->impressions, $r->clicks, $r->ctr_pct, $r->avg_position])->all()
        );

        /* -------- Low-CTR pages (ranking well, under-clicked) -------- */
        $lowCtr = GscMetric::query()
            ->selectRaw('page,
                SUM(clicks) as clicks,
                SUM(impressions) as impressions,
                ROUND(SUM(clicks) / NULLIF(SUM(impressions),0) * 100, 1) as ctr_pct,
                ROUND(SUM(position * impressions) / NULLIF(SUM(impressions),0), 1) as avg_position')
            ->whereNotNull('page')
            ->where('date', '>=', $since)
            ->groupBy('page')
            ->havingRaw('avg_position <= 15')
            ->havingRaw('SUM(impressions) >= ?', [max($minImpr, 100)])
            ->havingRaw('(SUM(clicks) / NULLIF(SUM(impressions),0)) < 0.02')
            ->orderByDesc('impressions')
            ->limit($limit)
            ->get();

        $this->newLine();
        $this->line('<comment>LOW CTR — pages ranking top-15 but clicked under 2% (title / meta rewrite targets)</comment>');
        $this->table(
            ['Page', 'Impr.', 'Clicks', 'CTR %', 'Avg pos'],
            $lowCtr->map(fn ($r) => [str_replace(rtrim(config('searchconsole.property'), '/'), '', $r->page), $r->impressions, $r->clicks, $r->ctr_pct, $r->avg_position])->all()
        );

        return self::SUCCESS;
    }
}
