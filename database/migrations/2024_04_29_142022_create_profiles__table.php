<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('city');
            $table->string('work');
            $table->date('birthdate');
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->string('education');
            $table->string('phone_number');
            $table->enum('gender', ['male', 'female']);
            $table->text('favorite_movies');
            $table->text('favorite_sports');
            $table->text('favorite_books');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
