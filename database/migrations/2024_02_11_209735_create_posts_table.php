<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class  CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id('post_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('foto_id');
            $table->unsignedBigInteger('share_id');
            $table->unsignedBigInteger('like_id');
            $table->text('content');
            $table->string('image_path'); 
            $table->enum('privacy_setting', ['public', 'only me', 'friends', 'close friends'])->default('public');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
