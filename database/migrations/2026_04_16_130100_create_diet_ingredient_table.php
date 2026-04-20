<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diet_ingredient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diet_id')->constrained()->onDelete('cascade');
            $table->string('ingredient_name');
            $table->foreign('ingredient_name')->references('name')->on('ingredients')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diet_ingredient');
    }
};