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

        $ingredients = collect($data)->map(function (array $ingredient) {
            return [
                'name' => $ingredient['name'],
                'gr_ration' => $ingredient['gr_ration'] ?? 0,
                'calories' => $ingredient['calories'],
                'fats' => $ingredient['fats'],
                'carbs' => $ingredient['carbs'],
                'protein' => $ingredient['protein'],
            ];
        })->all();

        // Inserta o actualiza por nombre para evitar errores de clave primaria duplicada.
        Ingredient::upsert($ingredients, ['name'], ['gr_ration', 'calories', 'fats', 'carbs', 'protein']);
    }
}
