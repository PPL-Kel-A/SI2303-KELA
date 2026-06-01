<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('educations', function (Blueprint $table) {
            $table->longText('content')->nullable()->after('title');
        });
    }

    public function down()
    {
        Schema::table('educations', function (Blueprint $table) {
            $table->dropColumn('content');
        });
    }
};