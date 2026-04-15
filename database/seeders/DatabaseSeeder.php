<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\IngredientSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            IngredientSeeder::class,
        ]);
    }
}
