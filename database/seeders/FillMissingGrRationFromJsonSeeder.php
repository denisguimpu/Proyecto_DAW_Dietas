<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FillMissingGrRationFromJsonSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('data/ingredients.json');
        if (!file_exists($jsonPath)) {
            return;
        }

        $items = json_decode(file_get_contents($jsonPath), true) ?: [];

        // Build a normalized map from JSON
        $jsonMap = [];
        foreach ($items as $item) {
            $normalized = Str::ascii(Str::lower(trim($item['name'] ?? '')));
            if ($normalized) {
                $jsonMap[$normalized] = $item;
            }
        }

        // Find ingredients with null or 0 gr_ration
        $needsFilling = Ingredient::where(function ($q) {
            $q->whereNull('gr_ration')
              ->orWhere('gr_ration', 0);
        })->get();

        foreach ($needsFilling as $ing) {
            $normalized = Str::ascii(Str::lower(trim($ing->name)));

            // Strategy 1: exact match after normalization
            if (isset($jsonMap[$normalized])) {
                $this->updateIngredient($ing, $jsonMap[$normalized]);
                continue;
            }

            // Strategy 2: ingredient name is substring of JSON name
            foreach ($jsonMap as $jsonNorm => $jsonItem) {
                if (strpos($jsonNorm, $normalized) !== false) {
                    $this->updateIngredient($ing, $jsonItem);
                    continue 2;
                }
            }

            // Strategy 3: JSON name is substring of ingredient name
            foreach ($jsonMap as $jsonNorm => $jsonItem) {
                if (strpos($normalized, $jsonNorm) !== false) {
                    $this->updateIngredient($ing, $jsonItem);
                    continue 2;
                }
            }
        }
    }

    private function updateIngredient(Ingredient $ingredient, array $jsonItem): void
    {
        $ingredient->update([
            'gr_ration' => $jsonItem['gr_ration'] ?? $ingredient->gr_ration,
            'kcal' => $jsonItem['Kcal'] ?? ($jsonItem['kcal'] ?? $ingredient->kcal),
            'protein' => $jsonItem['protein'] ?? $ingredient->protein,
            'fats' => $jsonItem['fats'] ?? $ingredient->fats,
            'carbs' => $jsonItem['carbs'] ?? $ingredient->carbs,
        ]);
    }
}
