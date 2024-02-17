<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendsTable extends Migration
{
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->id('friend_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('comment_id');
            $table->unsignedBigInteger('friends_request');
            $table->unsignedBigInteger('notification_id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedInteger('Number_of_friends')->default(0);
            $table->enum('privacy_setting', ['public', 'only me', 'friends', 'close friends'])->default('public');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('friends');
    }
}