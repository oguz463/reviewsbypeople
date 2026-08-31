<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Cleans up the historical `redirects` table so it can be served as 301s:
 *  - drops rows with corrupt old_url values
 *  - drops no-op rows (old_url == new_url)
 *  - de-duplicates on old_url (keeps the newest mapping)
 *  - flattens chains so every old_url points straight at its final destination
 *  - adds a unique index on old_url
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1. corrupt keys (stray brackets, spaces, quotes from bad edits)
        DB::table('redirects')->where(function ($q) {
            foreach (['[', ']', '(', ')', ' ', '"', "'", '<', '>'] as $c) {
                $q->orWhere('old_url', 'like', '%'.$c.'%');
            }
        })->delete();

        // 2. no-op rows
        DB::table('redirects')->whereColumn('old_url', 'new_url')->delete();

        // 3. de-duplicate on old_url, keeping the highest id
        $dupes = DB::table('redirects')
            ->select('old_url')
            ->groupBy('old_url')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('old_url');

        foreach ($dupes as $old) {
            $keep = DB::table('redirects')->where('old_url', $old)->max('id');

            DB::table('redirects')
                ->where('old_url', $old)
                ->where('id', '<>', $keep)
                ->delete();
        }

        // 4. flatten chains
        $map = DB::table('redirects')->pluck('new_url', 'old_url')->all();

        foreach ($map as $old => $new) {
            $target = $new;
            $seen = [(string) $old];

            for ($i = 0; $i < 10; $i++) {
                $internal = ! str_starts_with($target, 'http://')
                    && ! str_starts_with($target, 'https://');

                if (! $internal
                    || ! array_key_exists($target, $map)
                    || in_array($target, $seen, true)) {
                    break;
                }

                $seen[] = $target;
                $target = $map[$target];
            }

            if ($target !== $new) {
                DB::table('redirects')->where('old_url', $old)->update(['new_url' => $target]);
            }
        }

        // 5. flattening can create fresh no-ops
        DB::table('redirects')->whereColumn('old_url', 'new_url')->delete();

        Schema::table('redirects', function (Blueprint $table) {
            $table->unique('old_url');
        });
    }

    public function down(): void
    {
        Schema::table('redirects', function (Blueprint $table) {
            $table->dropUnique(['old_url']);
        });
    }
};
