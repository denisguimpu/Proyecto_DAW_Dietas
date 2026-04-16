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
        Schema::table('diets', function (Blueprint $table) {
            $table->float('weight')->nullable()->after('description');
            $table->float('height')->nullable()->after('weight');
            $table->integer('age')->nullable()->after('height');
            $table->enum('gender', ['male', 'female'])->nullable()->after('age');
            $table->string('activity_level')->nullable()->after('gender');
            $table->enum('goal', ['deficit', 'maintenance', 'volume'])->nullable()->after('activity_level');
            $table->float('target_calories')->nullable()->after('goal');
            $table->float('target_protein')->nullable()->after('target_calories');
            $table->float('target_carbs')->nullable()->after('target_protein');
            $table->float('target_fats')->nullable()->after('target_carbs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diets', function (Blueprint $table) {
            //
        });
    }
};
