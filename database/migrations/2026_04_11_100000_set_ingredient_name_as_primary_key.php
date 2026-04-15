<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private function dropForeignKeyIfExists(string $tableName, string $columnName): void
    {
        $foreignKey = DB::selectOne(
            'SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ? AND REFERENCED_TABLE_NAME IS NOT NULL LIMIT 1',
            [$tableName, $columnName]
        );

        if ($foreignKey?->CONSTRAINT_NAME) {
            DB::statement(sprintf(
                'ALTER TABLE `%s` DROP FOREIGN KEY `%s`',
                $tableName,
                $foreignKey->CONSTRAINT_NAME
            ));
        }
    }

    public function up(): void
    {
        if (Schema::hasTable('menu_ingredient') && Schema::hasColumn('menu_ingredient', 'ingredient_id')) {
            if (!Schema::hasColumn('menu_ingredient', 'ingredient_name')) {
                Schema::table('menu_ingredient', function (Blueprint $table) {
                    $table->string('ingredient_name')->nullable()->after('ingredient_id');
                });
            }

            $this->dropForeignKeyIfExists('menu_ingredient', 'menu_id');
            $this->dropForeignKeyIfExists('menu_ingredient', 'ingredient_id');
            DB::statement('ALTER TABLE menu_ingredient DROP PRIMARY KEY');

            DB::statement('
                UPDATE menu_ingredient mi
                INNER JOIN ingredients i ON i.id = mi.ingredient_id
                SET mi.ingredient_name = i.name
            ');

            DB::statement('ALTER TABLE menu_ingredient MODIFY ingredient_name VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE menu_ingredient DROP COLUMN ingredient_id');
            DB::statement('ALTER TABLE menu_ingredient ADD PRIMARY KEY (menu_id, ingredient_name)');
            DB::statement('ALTER TABLE menu_ingredient ADD CONSTRAINT menu_ingredient_menu_id_foreign FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE CASCADE');
            DB::statement('ALTER TABLE menu_ingredient ADD CONSTRAINT menu_ingredient_ingredient_name_foreign FOREIGN KEY (ingredient_name) REFERENCES ingredients(name) ON DELETE CASCADE');
        }

        if (Schema::hasTable('ingredients') && Schema::hasColumn('ingredients', 'id')) {
            DB::statement('ALTER TABLE ingredients DROP PRIMARY KEY, ADD PRIMARY KEY (name), DROP COLUMN id');

            $hasUniqueNameIndex = collect(DB::select("SHOW INDEX FROM ingredients WHERE Key_name = 'ingredients_name_unique'"))->isNotEmpty();

            if ($hasUniqueNameIndex) {
                DB::statement('ALTER TABLE ingredients DROP INDEX ingredients_name_unique');
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('ingredients') && !Schema::hasColumn('ingredients', 'id')) {
            DB::statement('ALTER TABLE ingredients DROP PRIMARY KEY');
            DB::statement('ALTER TABLE ingredients ADD COLUMN id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');
            DB::statement('ALTER TABLE ingredients ADD UNIQUE KEY ingredients_name_unique (name)');
        }

        if (Schema::hasTable('menu_ingredient') && !Schema::hasColumn('menu_ingredient', 'ingredient_id')) {
            if (!Schema::hasColumn('menu_ingredient', 'ingredient_id')) {
                Schema::table('menu_ingredient', function (Blueprint $table) {
                    $table->unsignedBigInteger('ingredient_id')->nullable()->after('menu_id');
                });
            }

            $this->dropForeignKeyIfExists('menu_ingredient', 'menu_id');
            $this->dropForeignKeyIfExists('menu_ingredient', 'ingredient_name');
            DB::statement('ALTER TABLE menu_ingredient DROP PRIMARY KEY');

            DB::statement('
                UPDATE menu_ingredient mi
                INNER JOIN ingredients i ON i.name = mi.ingredient_name
                SET mi.ingredient_id = i.id
            ');

            DB::statement('ALTER TABLE menu_ingredient MODIFY ingredient_id BIGINT UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE menu_ingredient DROP COLUMN ingredient_name');
            DB::statement('ALTER TABLE menu_ingredient ADD PRIMARY KEY (menu_id, ingredient_id)');
            DB::statement('ALTER TABLE menu_ingredient ADD CONSTRAINT menu_ingredient_menu_id_foreign FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE CASCADE');
            DB::statement('ALTER TABLE menu_ingredient ADD CONSTRAINT menu_ingredient_ingredient_id_foreign FOREIGN KEY (ingredient_id) REFERENCES ingredients(id) ON DELETE CASCADE');
        }
    }
};
