<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('diets') && !Schema::hasTable('menus')) {
            Schema::rename('diets', 'menus');
        }

        if (Schema::hasTable('diet_food_group') && !Schema::hasTable('menu_food_group')) {
            Schema::rename('diet_food_group', 'menu_food_group');
        }

        if (Schema::hasTable('menu_food_group')) {
            Schema::table('menu_food_group', function (Blueprint $table) {
                if (Schema::hasColumn('menu_food_group', 'diet_id')) {
                    $table->renameColumn('diet_id', 'menu_id');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('menu_food_group') && !Schema::hasTable('diet_food_group')) {
            Schema::rename('menu_food_group', 'diet_food_group');
        }

        if (Schema::hasTable('menus') && !Schema::hasTable('diets')) {
            Schema::rename('menus', 'diets');
        }

        if (Schema::hasTable('diet_food_group')) {
            Schema::table('diet_food_group', function (Blueprint $table) {
                if (Schema::hasColumn('diet_food_group', 'menu_id')) {
                    $table->renameColumn('menu_id', 'diet_id');
                }
            });
        }

    }
};
