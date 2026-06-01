<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wastes', function (Blueprint $table) {
            if (!Schema::hasColumn('wastes', 'status')) {
                $table->string('status')->default('Menunggu')->after('result');
            }
        });
    }

    public function down(): void
    {
        Schema::table('wastes', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
