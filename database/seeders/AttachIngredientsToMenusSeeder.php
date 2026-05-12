<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class AttachIngredientsToMenusSeeder extends Seeder
{
    public function run(): void
    {
        $mapping = [
            'Desayuno lunes' => ['copos de avena', 'bebida avena', 'fruta platano', 'frutos secos nueces'],
            'Comida lunes' => ['carne filetes pollo', 'arroz integral largo', 'verdura lechuga', 'verdura tomate'],
            'Merienda lunes' => ['yogur natural', 'frutos secos almendras'],
            'Cena lunes' => ['pescado salmon', 'patatas', 'brocoli'],

            'Desayuno martes' => ['biscotes', 'fruta platano', 'queso fresco'],
            'Comida martes' => ['alubias a la jardinera', 'verdura lechuga', 'carne pollo asado troceado'],
            'Merienda martes' => ['requeson', 'frutos secos almendras'],
            'Cena martes' => ['huevos', 'verdura tomate', 'patatas'],

            'Desayuno miercoles' => ['yogur griego ligero natural', 'copos de avena', 'fruta kiwi'],
            'Comida miercoles' => ['pescado merluza', 'arroz integral largo', 'brocoli', 'verdura lechuga'],
            'Merienda miercoles' => ['batido chocolate leche', 'fruta platano'],
            'Cena miercoles' => ['garbanzos riojana', 'atun natural', 'verdura tomate'],

            'Desayuno jueves' => ['copos de avena', 'fruta manzana golden', 'bebida avena'],
            'Comida jueves' => ['carne filetes pollo', 'patatas', 'verdura zanahoria'],
            'Merienda jueves' => ['hummus', 'verdura zanahoria'],
            'Cena jueves' => ['carne filetes pavo', 'verdura calabaza', 'verdura lechuga'],

            'Desayuno viernes' => ['embutido pechuga pavo cocida', 'fruta naranja', 'frutos secos almendras'],
            'Comida viernes' => ['atun con tomate', 'verdura tomate', 'patatas'],
            'Merienda viernes' => ['yogur proteinas arandanos', 'frutos secos nueces'],
            'Cena viernes' => ['champiñones laminados', 'huevos', 'queso fresco'],

            'Desayuno sabado' => ['copos de avena', 'huevos', 'fruta fresas'],
            'Comida sabado' => ['arroz integral largo', 'carne filetes pollo', 'verdura congelada (coliflor, brocoli y zanahoria)'],
            'Merienda sabado' => ['queso fresco batido', 'fruta manzana golden'],
            'Cena sabado' => ['pescado bacalao', 'patatas', 'verdura zanahoria'],

            'Desayuno domingo' => ['mantequilla cacahuete', 'fruta platano', 'copos de avena'],
            'Comida domingo' => ['arroz tres delicias', 'pescado gamba pelada', 'verdura lechuga'],
            'Merienda domingo' => ['yogur natural 0% azucares', 'fruta platano'],
            'Cena domingo' => ['huevos', 'verdura calabaza', 'verdura lechuga'],
        ];

        foreach ($mapping as $menuName => $ingredientNames) {
            $menu = Menu::where('name', $menuName)->first();
            if (!$menu) continue;

            // keep only ingredient names that exist in the DB to avoid FK errors
            $valid = [];
            foreach ($ingredientNames as $iname) {
                if (\App\Models\Ingredient::where('name', $iname)->exists()) {
                    $valid[] = $iname;
                }
            }

            if (!empty($valid)) {
                $menu->ingredients()->syncWithoutDetaching($valid);
            }
        }
    }
}
