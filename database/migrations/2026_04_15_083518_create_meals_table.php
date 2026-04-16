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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diet_id')->constrained()->onDelete('cascade');
            $table->enum('meal_type', ['desayuno', 'comida', 'merienda', 'cena']);
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
            $table->float('quantity')->default(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
