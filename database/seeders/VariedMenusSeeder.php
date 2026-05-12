<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class VariedMenusSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            ['name' => 'Desayuno lunes', 'description' => 'Avena con leche, platano y nueces', 'target_calories' => 500, 'target_protein' => 24, 'target_carbs' => 62, 'target_fats' => 17],
            ['name' => 'Comida lunes', 'description' => 'Pollo a la plancha con arroz integral y ensalada', 'target_calories' => 680, 'target_protein' => 45, 'target_carbs' => 70, 'target_fats' => 22],
            ['name' => 'Merienda lunes', 'description' => 'Yogur natural con frutos rojos y avena', 'target_calories' => 280, 'target_protein' => 14, 'target_carbs' => 30, 'target_fats' => 10],
            ['name' => 'Cena lunes', 'description' => 'Salmon al horno con patata cocida y brocoli', 'target_calories' => 620, 'target_protein' => 38, 'target_carbs' => 42, 'target_fats' => 30],

            ['name' => 'Desayuno martes', 'description' => 'Tostadas integrales con aguacate y huevo', 'target_calories' => 520, 'target_protein' => 23, 'target_carbs' => 48, 'target_fats' => 25],
            ['name' => 'Comida martes', 'description' => 'Lentejas estofadas con verduras y pavo', 'target_calories' => 700, 'target_protein' => 40, 'target_carbs' => 78, 'target_fats' => 20],
            ['name' => 'Merienda martes', 'description' => 'Requeson con pera y almendras', 'target_calories' => 300, 'target_protein' => 18, 'target_carbs' => 24, 'target_fats' => 14],
            ['name' => 'Cena martes', 'description' => 'Tortilla francesa con verduras y pan integral', 'target_calories' => 560, 'target_protein' => 30, 'target_carbs' => 36, 'target_fats' => 28],

            ['name' => 'Desayuno miercoles', 'description' => 'Yogur griego con granola y kiwi', 'target_calories' => 480, 'target_protein' => 22, 'target_carbs' => 54, 'target_fats' => 18],
            ['name' => 'Comida miercoles', 'description' => 'Merluza con quinoa y verduras salteadas', 'target_calories' => 640, 'target_protein' => 42, 'target_carbs' => 60, 'target_fats' => 20],
            ['name' => 'Merienda miercoles', 'description' => 'Batido de leche, cacao y platano', 'target_calories' => 290, 'target_protein' => 16, 'target_carbs' => 34, 'target_fats' => 9],
            ['name' => 'Cena miercoles', 'description' => 'Ensalada completa con garbanzos y atun', 'target_calories' => 600, 'target_protein' => 34, 'target_carbs' => 45, 'target_fats' => 28],

            ['name' => 'Desayuno jueves', 'description' => 'Porridge de avena con manzana y semillas', 'target_calories' => 490, 'target_protein' => 20, 'target_carbs' => 66, 'target_fats' => 14],
            ['name' => 'Comida jueves', 'description' => 'Ternera magra con boniato y judias verdes', 'target_calories' => 710, 'target_protein' => 46, 'target_carbs' => 58, 'target_fats' => 27],
            ['name' => 'Merienda jueves', 'description' => 'Hummus con zanahoria y pan pita', 'target_calories' => 310, 'target_protein' => 11, 'target_carbs' => 34, 'target_fats' => 14],
            ['name' => 'Cena jueves', 'description' => 'Pechuga de pavo con crema de calabaza', 'target_calories' => 540, 'target_protein' => 39, 'target_carbs' => 30, 'target_fats' => 22],

            ['name' => 'Desayuno viernes', 'description' => 'Bocadillo integral de pavo y tomate', 'target_calories' => 510, 'target_protein' => 27, 'target_carbs' => 56, 'target_fats' => 18],
            ['name' => 'Comida viernes', 'description' => 'Pasta integral con atun y tomate natural', 'target_calories' => 730, 'target_protein' => 41, 'target_carbs' => 82, 'target_fats' => 24],
            ['name' => 'Merienda viernes', 'description' => 'Yogur proteico con nueces', 'target_calories' => 270, 'target_protein' => 20, 'target_carbs' => 12, 'target_fats' => 15],
            ['name' => 'Cena viernes', 'description' => 'Revuelto de champinones con queso fresco', 'target_calories' => 550, 'target_protein' => 33, 'target_carbs' => 26, 'target_fats' => 31],

            ['name' => 'Desayuno sabado', 'description' => 'Tortitas de avena y huevo con fresas', 'target_calories' => 530, 'target_protein' => 26, 'target_carbs' => 58, 'target_fats' => 19],
            ['name' => 'Comida sabado', 'description' => 'Arroz con pollo y verduras', 'target_calories' => 760, 'target_protein' => 44, 'target_carbs' => 88, 'target_fats' => 24],
            ['name' => 'Merienda sabado', 'description' => 'Fruta con queso fresco batido', 'target_calories' => 250, 'target_protein' => 17, 'target_carbs' => 24, 'target_fats' => 8],
            ['name' => 'Cena sabado', 'description' => 'Bacalao con pure de patata y espinacas', 'target_calories' => 590, 'target_protein' => 37, 'target_carbs' => 48, 'target_fats' => 22],

            ['name' => 'Desayuno domingo', 'description' => 'Tostadas con crema de cacahuete y platano', 'target_calories' => 540, 'target_protein' => 21, 'target_carbs' => 60, 'target_fats' => 24],
            ['name' => 'Comida domingo', 'description' => 'Paella mixta moderada con ensalada', 'target_calories' => 780, 'target_protein' => 38, 'target_carbs' => 90, 'target_fats' => 28],
            ['name' => 'Merienda domingo', 'description' => 'Kefir con fruta y semillas', 'target_calories' => 260, 'target_protein' => 13, 'target_carbs' => 26, 'target_fats' => 10],
            ['name' => 'Cena domingo', 'description' => 'Crema de verduras y tortilla de espinacas', 'target_calories' => 520, 'target_protein' => 29, 'target_carbs' => 28, 'target_fats' => 27],
        ];

        foreach ($menus as $menu) {
            Menu::updateOrCreate(
                ['name' => $menu['name']],
                [
                    'description' => $menu['description'],
                    'weight' => 70,
                    'height' => 175,
                    'age' => 30,
                    'gender' => 'neutral',
                    'activity_level' => 1.55,
                    'goal' => 'maintenance',
                    'target_calories' => $menu['target_calories'],
                    'target_protein' => $menu['target_protein'],
                    'target_carbs' => $menu['target_carbs'],
                    'target_fats' => $menu['target_fats'],
                ]
            );
        }
    }
}
