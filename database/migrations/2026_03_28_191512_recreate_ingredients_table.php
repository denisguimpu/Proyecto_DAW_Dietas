<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->string('name')->primary();
            $table->integer('gr_ration')->default(0);
            $table->integer('kcal');
            $table->float('fats');
            $table->float('carbs');
            $table->float('protein');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
