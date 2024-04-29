<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendersTable extends Migration
{

    public function up()
    {
       
        Schema::create('senders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id')->unique();
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('senders');
    }
};