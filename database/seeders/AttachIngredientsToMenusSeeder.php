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
            'Cena martes' => ['huevo', 'verdura tomate', 'pan integral'],

            'Desayuno miercoles' => ['yogur griego ligero natural', 'copos de avena', 'fruta kiwi'],
            'Comida miercoles' => ['merluza', 'arroz integral largo', 'verdura brócoli', 'verdura lechuga'],
            'Merienda miercoles' => ['batido chocolate leche', 'fruta platano'],
            'Cena miercoles' => ['garbanzos', 'atun natural', 'verdura tomate'],

            'Desayuno jueves' => ['copos de avena', 'fruta manzana', 'bebida avena'],
            'Comida jueves' => ['carne filetes pollo', 'patatas', 'verdura judias verdes'],
            'Merienda jueves' => ['hummus', 'zanahoria'],
            'Cena jueves' => ['pechuga pavo', 'crema calabaza', 'verdura lechuga'],

            'Desayuno viernes' => ['pan integral', 'embutido pechuga pollo', 'fruta naranja'],
            'Comida viernes' => ['pasta integral', 'atun con tomate', 'verdura tomate'],
            'Merienda viernes' => ['yogur proteinas arandanos', 'frutos secos nueces'],
            'Cena viernes' => ['champinones', 'huevo', 'queso fresco'],

            'Desayuno sabado' => ['copos de avena', 'huevo', 'fruta fresas'],
            'Comida sabado' => ['arroz integral largo', 'carne filetes pollo', 'verdura mezcla'],
            'Merienda sabado' => ['queso fresco batido', 'fruta'],
            'Cena sabado' => ['bacalao', 'patatas', 'espinacas'],

            'Desayuno domingo' => ['pan integral', 'crema cacahuete polvo', 'fruta platano'],
            'Comida domingo' => ['arroz tres delicias', 'marisco', 'verdura lechuga'],
            'Merienda domingo' => ['kefir', 'fruta'],
            'Cena domingo' => ['crema verduras', 'huevo', 'espinacas'],
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
