<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharesTable extends Migration
{
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->id('share_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('photo_id')->nullable();
            $table->unsignedBigInteger('comment_id')->nullable();
            $table->unsignedBigInteger('friend_id')->nullable();
            $table->unsignedBigInteger('notification_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('shares');
    }
}