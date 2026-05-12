<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SyncIngredientsFromJsonSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('data/ingredients.json');
        $items = json_decode(file_get_contents($jsonPath), true);

        if (!is_array($items)) {
            return;
        }

        $existing = Ingredient::all()->keyBy(function (Ingredient $ingredient) {
            return Str::ascii(Str::lower(trim($ingredient->name)));
        });

        foreach ($items as $item) {
            $normalizedName = Str::ascii(Str::lower(trim($item['name'] ?? '')));

            if (!$normalizedName || !$existing->has($normalizedName)) {
                continue;
            }

            $ingredient = $existing->get($normalizedName);
            $ingredient->update([
                'gr_ration' => $item['gr_ration'] ?? $ingredient->gr_ration,
                'kcal' => $item['Kcal'] ?? ($item['kcal'] ?? $ingredient->kcal),
                'protein' => $item['protein'] ?? $ingredient->protein,
                'fats' => $item['fats'] ?? $ingredient->fats,
                'carbs' => $item['carbs'] ?? $ingredient->carbs,
            ]);
        }
    }
}
