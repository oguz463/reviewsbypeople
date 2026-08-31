<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Redirect;
use App\Models\Review;
use Illuminate\Console\Command;

/**
 * Deletes redirect rows whose internal target no longer resolves to a live page,
 * so dead URLs return a clean 404 instead of a 301 into a 404 ("soft 404").
 * Re-run after unpublishing / pruning content.
 */
class RedirectsPrune extends Command
{
    protected $signature = 'redirects:prune {--dry-run : List what would be deleted without deleting}';

    protected $description = 'Remove redirect rows that point at a page which no longer exists';

    public function handle(): int
    {
        $rows = Redirect::query()->orderBy('old_url')->get();
        $map = $rows->pluck('new_url', 'old_url')->all();

        $dead = [];

        foreach ($rows as $row) {
            $target = $this->finalTarget($row->old_url, $map);

            if (! $this->targetIsLive($target)) {
                $dead[] = $row;
            }
        }

        if (! $dead) {
            $this->info('All '.$rows->count().' redirects point at a live page. Nothing to prune.');

            return self::SUCCESS;
        }

        $this->table(
            ['old_url', 'new_url (dead)'],
            array_map(fn ($r) => [$r->old_url, $r->new_url], $dead),
        );

        if ($this->option('dry-run')) {
            $this->warn(count($dead).' of '.$rows->count().' redirects would be deleted. Re-run without --dry-run to apply.');

            return self::SUCCESS;
        }

        Redirect::whereIn('id', array_column($dead, 'id'))->delete();
        $this->info('Deleted '.count($dead).' dead redirects. '.($rows->count() - count($dead)).' remain.');

        return self::SUCCESS;
    }

    /** @param array<string,string> $map */
    private function finalTarget(string $old, array $map): string
    {
        $target = $map[$old];
        $seen = [$old];

        for ($i = 0; $i < 10; $i++) {
            $internal = ! str_starts_with($target, 'http://') && ! str_starts_with($target, 'https://');

            if (! $internal || ! array_key_exists($target, $map) || in_array($target, $seen, true)) {
                break;
            }

            $seen[] = $target;
            $target = $map[$target];
        }

        return $target;
    }

    private function targetIsLive(string $target): bool
    {
        // external + homepage are always considered valid
        if (str_starts_with($target, 'http://') || str_starts_with($target, 'https://') || $target === '/') {
            return true;
        }

        $path = ltrim($target, '/');

        if (str_starts_with($path, 'post/')) {
            return Post::where('slug', substr($path, 5))->whereNotNull('published_at')->exists();
        }

        // canonical product URL is /{review-slug}/{product-slug}
        if (str_contains($path, '/')) {
            [$reviewSlug, $productSlug] = explode('/', $path, 2);

            if (Product::where('slug', $productSlug)->whereNotNull('published_at')->exists()) {
                return true;
            }

            return Review::where('slug', $reviewSlug)->whereNotNull('published_at')->exists();
        }

        return Review::where('slug', $path)->whereNotNull('published_at')->exists()
            || Category::where('slug', $path)->exists();
    }
}
