<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Leer datos desde el JSON
        $data = json_decode(
            file_get_contents(database_path('data/ingredients.json')),
            true
        );

        // Insertar todos los ingredientes en la base de datos
        Ingredient::insert($data);
    }
}
