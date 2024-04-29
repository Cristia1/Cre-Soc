<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->nullable()->after('password');
            }
            if (!Schema::hasColumn('users', 'google_user_id')) {
                $table->string('google_user_id')->unique()->after('google_id');
            }
            if (!Schema::hasColumn('users', 'google_user_email')) {
                $table->string('google_user_email')->after('google_user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_id');
            $table->dropColumn('google_user_id');
            $table->dropColumn('google_user_email');
        });
    }
};

