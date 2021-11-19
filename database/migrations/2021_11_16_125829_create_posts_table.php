<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('hash');
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('post_id');
            $table->string('title');
            $table->text('content');
            $table->tinyInteger('group');
            $table->tinyInteger('reaction');
            $table->tinyInteger('comment');
            $table->string('password')->nullable();
            $table->time('time_join')->nullable();
            $table->integer('view')->default(0);
            $table->integer('unlock')->default(0);
            $table->integer('spam')->default(0);
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
