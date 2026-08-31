<?php

namespace App\Console\Commands;

use App\Services\SearchConsole;
use Illuminate\Console\Command;
use RuntimeException;
use Throwable;

class GscSitemap extends Command
{
    protected $signature = 'gsc:sitemap
        {--submit : (Re)submit the sitemap to Search Console}
        {--url= : Override the sitemap URL (defaults to config searchconsole.sitemap_url)}';

    protected $description = 'List — or resubmit — the sitemaps registered in Search Console';

    public function handle(): int
    {
        try {
            $gsc = app(SearchConsole::class);

            if ($this->option('submit')) {
                $url = $this->option('url') ?: config('searchconsole.sitemap_url');
                $gsc->submitSitemap($url);
                $this->info("Submitted: {$url}");
            }

            $sitemaps = $gsc->sitemaps();
        } catch (RuntimeException $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        } catch (Throwable $e) {
            $this->error('Search Console request failed: ' . $e->getMessage());

            return self::FAILURE;
        }

        if (! $sitemaps) {
            $this->warn('No sitemaps registered for this property yet. Run with --submit.');

            return self::SUCCESS;
        }

        $this->table(
            ['Path', 'Last submitted', 'Pending', 'Errors', 'Warnings'],
            array_map(fn ($s) => [
                $s['path'],
                $s['lastSubmitted'],
                $s['isPending'] ? 'yes' : '',
                $s['errors'],
                $s['warnings'],
            ], $sitemaps)
        );

        return self::SUCCESS;
    }
}
