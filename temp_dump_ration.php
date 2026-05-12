<?php
App\Models\Ingredient::where('gr_ration', 0)->orWhereNull('gr_ration')->update(['gr_ration' => 100]);

$ingredients = App\Models\Ingredient::all();
$output = "<?php\n\nnamespace Database\Seeders;\n\nuse App\Models\Ingredient;\nuse Illuminate\Database\Seeder;\n\nclass IngredientSeeder extends Seeder\n{\n    public function run(): void\n    {\n        \$ingredients = [\n";

foreach ($ingredients as $i) {
    $name = addslashes($i->name);
    $kcal = floatval($i->kcal);
    $prot = floatval($i->protein);
    $fats = floatval($i->fats);
    $carbs = floatval($i->carbs);
    $gr_ration = intval($i->gr_ration);
    $unit = addslashes($i->unit ?? 'g');
    $cat = addslashes($i->category ?? 'otros');
    $output .= "            ['name' => '{$name}', 'gr_ration' => {$gr_ration}, 'kcal' => {$kcal}, 'protein' => {$prot}, 'fats' => {$fats}, 'carbs' => {$carbs}, 'unit' => '{$unit}', 'category' => '{$cat}'],\n";
}

$output .= "        ];\n\n";
$output .= "        foreach (\$ingredients as \$ingredient) {\n";
$output .= "            Ingredient::firstOrCreate(\n";
$output .= "                ['name' => \$ingredient['name']],\n";
$output .= "                \$ingredient\n";
$output .= "            );\n";
$output .= "        }\n";
$output .= "    }\n";
$output .= "}\n";

file_put_contents(base_path('database/seeders/IngredientSeeder.php'), $output);
echo "Done!";
