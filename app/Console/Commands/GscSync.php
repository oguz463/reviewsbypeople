<?php

namespace App\Console\Commands;

use App\Models\GscMetric;
use App\Services\SearchConsole;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class GscSync extends Command
{
    protected $signature = 'gsc:sync
        {--days=90 : How many days back to pull (ignored if --start given)}
        {--start= : Start date YYYY-MM-DD}
        {--end= : End date YYYY-MM-DD (defaults to today minus the configured lag)}';

    protected $description = 'Pull Search Console date/page/query metrics into the gsc_metrics table';

    public function handle(): int
    {
        try {
            $gsc = app(SearchConsole::class);
        } catch (\RuntimeException $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $lag = (int) config('searchconsole.lag_days', 3);

        $end = $this->option('end')
            ? Carbon::parse($this->option('end'))
            : now()->subDays($lag);

        $start = $this->option('start')
            ? Carbon::parse($this->option('start'))
            : (clone $end)->subDays((int) $this->option('days'));

        // GSC only keeps 16 months
        $floor = now()->subMonths(16)->addDay();
        if ($start->lt($floor)) {
            $start = $floor;
            $this->warn('Start clamped to 16 months ago: ' . $start->toDateString());
        }

        $startStr = $start->toDateString();
        $endStr   = $end->toDateString();

        $this->info("Fetching {$startStr} .. {$endStr} for {$gsc->property()}");

        try {
            $rows = $gsc->searchAnalytics($startStr, $endStr, ['date', 'page', 'query']);
        } catch (Throwable $e) {
            $this->error('Search Console request failed: ' . $e->getMessage());

            return self::FAILURE;
        }

        $this->info(number_format(count($rows)) . ' rows returned.');

        if (! $rows) {
            return self::SUCCESS;
        }

        $now      = now();
        $records  = [];
        $upserted = 0;

        foreach ($rows as $row) {
            [$date, $page, $query] = array_pad($row['keys'], 3, null);

            $page  = $page ? Str::limit($page, 500, '') : null;
            $query = $query ? Str::limit($query, 500, '') : null;

            $records[] = [
                'date'        => $date,
                'page'        => $page,
                'query'       => $query,
                'country'     => null,
                'device'      => null,
                'clicks'      => (int) round($row['clicks']),
                'impressions' => (int) round($row['impressions']),
                'ctr'         => round($row['ctr'], 5),
                'position'    => round($row['position'], 3),
                'row_hash'    => GscMetric::hash($date, $page, $query),
                'created_at'  => $now,
                'updated_at'  => $now,
            ];

            if (count($records) >= 1000) {
                $upserted += $this->flush($records);
                $records = [];
            }
        }

        $upserted += $this->flush($records);

        $this->info("Stored {$upserted} rows into gsc_metrics.");

        return self::SUCCESS;
    }

    /** @param array<int, array<string, mixed>> $records */
    private function flush(array $records): int
    {
        if (! $records) {
            return 0;
        }

        DB::table('gsc_metrics')->upsert(
            $records,
            ['row_hash'],
            ['clicks', 'impressions', 'ctr', 'position', 'updated_at'],
        );

        return count($records);
    }
}
