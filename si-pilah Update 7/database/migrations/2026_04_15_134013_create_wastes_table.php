<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wastes', function (Blueprint $table) {
            $table->id();

            // TYPE (organic / inorganic)
            $table->enum('type', ['organic', 'inorganic']);

            // DETAIL DATA
            $table->string('category');
            $table->decimal('weight', 8, 2); // lebih akurat dari float
            $table->string('tps');

            // IMAGE
            $table->string('image')->nullable();

            // RESULT (liter)
            $table->decimal('result', 8, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wastes');
    }
};