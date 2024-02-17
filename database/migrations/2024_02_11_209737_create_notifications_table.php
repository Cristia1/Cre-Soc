<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notification_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('sender_id');
                $table->unsignedBigInteger('notifiable_id');
                $table->unsignedBigInteger('photo_id');
                $table->unsignedBigInteger('chat_id');
                $table->unsignedBigInteger('message_id');
                $table->unsignedBigInteger('share_id');
                $table->unsignedBigInteger('like_id');
                $table->string('notifiable_type');
                $table->string('type');
                $table->text('message');
                $table->boolean('read')->default(false);
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}