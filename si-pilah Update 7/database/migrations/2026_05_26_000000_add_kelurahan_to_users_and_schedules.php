<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('kelurahan')->nullable()->after('email');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->string('kelurahan')->nullable()->after('nama_petugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('kelurahan');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('kelurahan');
        });
    }
};
