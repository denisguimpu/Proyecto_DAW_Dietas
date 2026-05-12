<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RemovePescadoPrefixIngredientsSeeder extends Seeder
{
    public function run(): void
    {
        $items = Ingredient::where('name', 'like', 'pescado %')->get();

        foreach ($items as $item) {
            $suffix = trim(Str::after($item->name, 'pescado'));
            $suffix = ltrim($suffix); // remove leading space

            // try to find a canonical ingredient matching the suffix (case-insensitive)
            $canonical = Ingredient::whereRaw('LOWER(name) = ?', [Str::lower($suffix)])->first();

            if (! $canonical) {
                // fallback: try capitalized suffix
                $candidateName = ucfirst($suffix);
                $canonical = Ingredient::where('name', $candidateName)->first();
            }

            if (! $canonical) {
                // create a canonical copy using the suffix as name
                $canonical = Ingredient::create([
                    'name' => ucfirst($suffix),
                    'gr_ration' => $item->gr_ration,
                    'kcal' => $item->kcal,
                    'protein' => $item->protein,
                    'fats' => $item->fats,
                    'carbs' => $item->carbs,
                    'unit' => $item->unit ?? 'g',
                    'category' => $item->category ?? 'otros',
                ]);
            }

            // remap pivot rows from 'pescado ...' to canonical name, avoiding duplicates
            $rows = DB::table('menu_ingredient')->where('ingredient_name', $item->name)->get();
            foreach ($rows as $r) {
                $exists = DB::table('menu_ingredient')
                    ->where('menu_id', $r->menu_id)
                    ->where('ingredient_name', $canonical->name)
                    ->exists();

                if ($exists) {
                    // remove the old duplicate pivot
                    DB::table('menu_ingredient')
                        ->where('menu_id', $r->menu_id)
                        ->where('ingredient_name', $item->name)
                        ->delete();
                } else {
                    // safe to update
                    DB::table('menu_ingredient')
                        ->where('menu_id', $r->menu_id)
                        ->where('ingredient_name', $item->name)
                        ->update(['ingredient_name' => $canonical->name]);
                }
            }

            // finally delete the old 'pescado ...' ingredient
            $item->delete();
        }
    }
}
