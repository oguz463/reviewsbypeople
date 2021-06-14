<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('review_id')->nullable()->constrained();
            $table->foreignId('post_id')->nullable()->constrained();
            $table->string('title');
            $table->string('seo_title');
            $table->string('slug')->unique();
            $table->string('summary');
            $table->longText('body');
            $table->string('img')->nullable();
            $table->json('url')->nullable();
            $table->timestamps();
            $table->timestamp('published_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
