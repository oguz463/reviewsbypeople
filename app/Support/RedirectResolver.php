<?php

namespace App\Support;

use App\Models\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Turns a request for a dead URL into a 301 by looking it up in the `redirects`
 * table. Chains ( /a -> /b -> /c ) are followed to their final destination, and
 * legacy /index.php/ front-controller URLs are always collapsed to their clean
 * form (which then resolves against the table or a live page).
 */
class RedirectResolver
{
    private const MAX_HOPS = 10;

    public function resolve(Request $request): ?RedirectResponse
    {
        $from = '/'.trim(rawurldecode($request->path()), '/');
        $map = $this->map();

        // legacy front-controller URLs: /index.php/foo -> /foo
        if ($from === '/index.php' || str_starts_with($from, '/index.php/')) {
            $clean = $from === '/index.php' ? '/' : substr($from, strlen('/index.php'));
            $target = isset($map[$clean]) ? $this->follow($clean, $map) : $clean;

            return $this->response($request, $target);
        }

        if (! isset($map[$from])) {
            return null;
        }

        $target = $this->follow($from, $map);

        // guard against a row that points a path back at itself
        if ($this->isInternal($target) && rtrim($target, '/') === rtrim($from, '/')) {
            return null;
        }

        return $this->response($request, $target);
    }

    /** @return array<string, string>  old_url => new_url */
    private function map(): array
    {
        return Cache::remember(
            Redirect::CACHE_KEY,
            now()->addHours(6),
            fn () => Redirect::query()->pluck('new_url', 'old_url')->all(),
        );
    }

    /** @param array<string, string> $map */
    private function follow(string $key, array $map): string
    {
        $target = $map[$key];
        $seen = [$key];

        for ($i = 0; $i < self::MAX_HOPS; $i++) {
            if (! $this->isInternal($target)
                || ! isset($map[$target])
                || in_array($target, $seen, true)) {
                break;
            }

            $seen[] = $target;
            $target = $map[$target];
        }

        return $target;
    }

    private function isInternal(string $target): bool
    {
        return ! str_starts_with($target, 'http://')
            && ! str_starts_with($target, 'https://');
    }

    private function response(Request $request, string $target): RedirectResponse
    {
        if (! $this->isInternal($target)) {
            return redirect()->away($target, 301);
        }

        $query = $request->getQueryString();

        if ($query !== null && $query !== '' && ! str_contains($target, '?')) {
            $target .= '?'.$query;
        }

        return redirect()->to($target, 301);
    }
}
