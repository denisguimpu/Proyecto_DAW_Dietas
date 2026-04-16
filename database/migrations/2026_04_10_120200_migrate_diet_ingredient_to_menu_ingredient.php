<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('menu_ingredient')) {
            Schema::create('menu_ingredient', function (Blueprint $table) {
                $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete();
                $table->foreignId('ingredient_id')->constrained('ingredients')->cascadeOnDelete();
                $table->primary(['menu_id', 'ingredient_id']);
            });
        }

        if (Schema::hasTable('diet_ingredient')) {
            DB::statement('
                INSERT IGNORE INTO menu_ingredient (menu_id, ingredient_id)
                SELECT di.diet_id, i.id
                FROM diet_ingredient di
                INNER JOIN ingredients i ON i.name = di.ingredient_name
            ');

            Schema::dropIfExists('diet_ingredient');
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('diet_ingredient')) {
            Schema::create('diet_ingredient', function (Blueprint $table) {
                $table->foreignId('diet_id')->constrained('menus')->cascadeOnDelete();
                $table->string('ingredient_name');
                $table->primary(['diet_id', 'ingredient_name']);
            });
        }

        if (Schema::hasTable('menu_ingredient')) {
            DB::statement('
                INSERT IGNORE INTO diet_ingredient (diet_id, ingredient_name)
                SELECT mi.menu_id, i.name
                FROM menu_ingredient mi
                INNER JOIN ingredients i ON i.id = mi.ingredient_id
            ');

            Schema::dropIfExists('menu_ingredient');
        }
    }
};
