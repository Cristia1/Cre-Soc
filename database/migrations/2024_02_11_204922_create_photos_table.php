<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id('photo_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('share_id')->nullable();
            $table->unsignedBigInteger('comment_id')->nullable();
            $table->unsignedBigInteger('like_id')->nullable();
            $table->text('description');
            $table->unsignedInteger('Number_of_like')->default(0);
            $table->string('image_path');
            $table->timestamp('upload_date')->useCurrent();
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('comments_count')->default(0);
            $table->enum('privacy_setting', ['public', 'only me', 'friends', 'close friends'])->default('public');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
