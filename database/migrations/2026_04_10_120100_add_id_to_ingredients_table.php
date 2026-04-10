<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $foreignKeys = DB::select(
            "SELECT TABLE_NAME, CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_SCHEMA = DATABASE() AND REFERENCED_TABLE_NAME = 'ingredients'"
        );

        foreach ($foreignKeys as $foreignKey) {
            DB::statement(sprintf(
                'ALTER TABLE `%s` DROP FOREIGN KEY `%s`',
                $foreignKey->TABLE_NAME,
                $foreignKey->CONSTRAINT_NAME
            ));
        }

        if (!Schema::hasColumn('ingredients', 'id')) {
            DB::statement('ALTER TABLE ingredients DROP PRIMARY KEY, ADD COLUMN id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');
        }

        $hasUniqueNameIndex = collect(DB::select("SHOW INDEX FROM ingredients WHERE Key_name = 'ingredients_name_unique'"))->isNotEmpty();

        if (! $hasUniqueNameIndex) {
            DB::statement('ALTER TABLE ingredients ADD UNIQUE KEY ingredients_name_unique (name)');
        }
    }

    public function down(): void
    {
        $hasUniqueNameIndex = collect(DB::select("SHOW INDEX FROM ingredients WHERE Key_name = 'ingredients_name_unique'"))->isNotEmpty();

        if ($hasUniqueNameIndex) {
            DB::statement('ALTER TABLE ingredients DROP INDEX ingredients_name_unique');
        }

        if (Schema::hasColumn('ingredients', 'id')) {
            DB::statement('ALTER TABLE ingredients DROP PRIMARY KEY, DROP COLUMN id, ADD PRIMARY KEY (name)');
        }
    }
};
