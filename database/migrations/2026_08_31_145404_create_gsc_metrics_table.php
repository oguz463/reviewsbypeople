<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gsc_metrics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('page', 512)->nullable();
            $table->string('query', 512)->nullable();
            $table->string('country', 8)->nullable();
            $table->string('device', 16)->nullable();
            $table->unsignedInteger('clicks')->default(0);
            $table->unsignedInteger('impressions')->default(0);
            $table->decimal('ctr', 8, 5)->default(0);       // 0.00000 – 1.00000
            $table->decimal('position', 8, 3)->default(0);
            // md5(date|page|query|country|device) — the natural key, short enough to index
            $table->char('row_hash', 32)->unique();
            $table->timestamps();

            $table->index('date');
            $table->index('query');
            $table->index('page');
            $table->index(['date', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gsc_metrics');
    }
};
