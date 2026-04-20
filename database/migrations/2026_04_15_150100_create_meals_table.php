<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('diet_id')->constrained('menus')->onDelete('cascade');
            $table->enum('meal_type', ['desayuno', 'comida', 'merienda', 'cena']);
            $table->string('ingredient_name');
            $table->foreign('ingredient_name')->references('name')->on('ingredients')->onDelete('cascade');
            $table->float('quantity')->default(100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};