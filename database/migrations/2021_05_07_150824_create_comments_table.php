<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->morphs('commentable');
            $table->string('author');
            $table->string('email');
            $table->string('avatar')->default('/storage/uploads/avatars/no-avatar/no-avatar.jpg');
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->text('body');
            $table->timestamps();
            $table->timestamp('published_at')->nullable();

            $table->foreign('parent_id')
                ->references('id')
                ->on('comments')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
