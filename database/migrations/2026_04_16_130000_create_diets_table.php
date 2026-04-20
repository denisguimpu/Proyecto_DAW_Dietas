<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->float('weight')->nullable();
            $table->float('height')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->float('activity_level')->nullable();
            $table->string('goal')->nullable();
            $table->float('target_calories')->nullable();
            $table->float('target_protein')->nullable();
            $table->float('target_carbs')->nullable();
            $table->float('target_fats')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diets');
    }
};