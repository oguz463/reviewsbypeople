<?php

namespace App\Console\Commands;

use App\Services\SearchConsole;
use Illuminate\Console\Command;
use RuntimeException;
use Throwable;

class GscTest extends Command
{
    protected $signature = 'gsc:test';

    protected $description = 'Verify the Search Console service-account connection and property access';

    public function handle(): int
    {
        $this->line('Key path : ' . config('searchconsole.key_path'));
        $this->line('Property : ' . config('searchconsole.property'));
        $this->newLine();

        try {
            $gsc   = app(SearchConsole::class);
            $sites = $gsc->sites();
        } catch (RuntimeException $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        } catch (Throwable $e) {
            $this->error('Connection failed: ' . $e->getMessage());

            return self::FAILURE;
        }

        if (empty($sites)) {
            $this->error('Authenticated, but the service account has no properties. Add it under Search Console → Settings → Users and permissions.');

            return self::FAILURE;
        }

        $this->table(['Property', 'Permission'], array_map(fn ($s) => [$s['siteUrl'], $s['permissionLevel']], $sites));

        $match = collect($sites)->firstWhere('siteUrl', $gsc->property());

        if (! $match) {
            $this->warn("The configured property [{$gsc->property()}] is not in the list above — check GSC_PROPERTY matches Search Console exactly (trailing slash for URL-prefix, or sc-domain: for a domain property).");

            return self::FAILURE;
        }

        // one tiny live query to prove Search Analytics works
        $rows = $gsc->searchAnalytics(
            now()->subDays(config('searchconsole.lag_days') + 7)->toDateString(),
            now()->subDays(config('searchconsole.lag_days'))->toDateString(),
            ['query'],
        );

        $this->newLine();
        $this->info("OK — {$match['permissionLevel']} access. Sample query returned " . count($rows) . ' rows for the last 7 days.');

        return self::SUCCESS;
    }
}
