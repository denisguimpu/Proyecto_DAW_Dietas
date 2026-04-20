<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->float('weight')->nullable()->after('description');
            $table->float('height')->nullable()->after('weight');
            $table->integer('age')->nullable()->after('height');
            $table->string('gender')->nullable()->after('age');
            $table->float('activity_level')->nullable()->after('gender');
            $table->string('goal')->nullable()->after('activity_level');
            $table->float('target_calories')->nullable()->after('goal');
            $table->float('target_protein')->nullable()->after('target_calories');
            $table->float('target_carbs')->nullable()->after('target_protein');
            $table->float('target_fats')->nullable()->after('target_carbs');
        });
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['weight', 'height', 'age', 'gender', 'activity_level', 'goal', 'target_calories', 'target_protein', 'target_carbs', 'target_fats']);
        });
    }
};