<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meal_plans', function (Blueprint $table) {
            $table->dropForeign(['diet_id']);
            $table->dropColumn('diet_id');
            
            $table->foreignId('breakfast_menu_id')->nullable()->constrained('menus')->nullOnDelete();
            $table->foreignId('lunch_menu_id')->nullable()->constrained('menus')->nullOnDelete();
            $table->foreignId('snack_menu_id')->nullable()->constrained('menus')->nullOnDelete();
            $table->foreignId('dinner_menu_id')->nullable()->constrained('menus')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('meal_plans', function (Blueprint $table) {
            $table->dropForeign(['breakfast_menu_id']);
            $table->dropForeign(['lunch_menu_id']);
            $table->dropForeign(['snack_menu_id']);
            $table->dropForeign(['dinner_menu_id']);
            
            $table->dropColumn([
                'breakfast_menu_id', 
                'lunch_menu_id', 
                'snack_menu_id', 
                'dinner_menu_id'
            ]);
            
            $table->foreignId('diet_id')->nullable()->constrained('menus')->onDelete('cascade');
        });
    }
};
