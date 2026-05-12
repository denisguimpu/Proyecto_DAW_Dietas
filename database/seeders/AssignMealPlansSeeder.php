<?php

namespace Database\Seeders;

use App\Models\MealPlan;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class AssignMealPlansSeeder extends Seeder
{
    public function run(): void
    {
        $mapping = [
            'monday' => ['Desayuno lunes', 'Comida lunes', 'Merienda lunes', 'Cena lunes'],
            'tuesday' => ['Desayuno martes', 'Comida martes', 'Merienda martes', 'Cena martes'],
            'wednesday' => ['Desayuno miercoles', 'Comida miercoles', 'Merienda miercoles', 'Cena miercoles'],
            'thursday' => ['Desayuno jueves', 'Comida jueves', 'Merienda jueves', 'Cena jueves'],
            'friday' => ['Desayuno viernes', 'Comida viernes', 'Merienda viernes', 'Cena viernes'],
            'saturday' => ['Desayuno sabado', 'Comida sabado', 'Merienda sabado', 'Cena sabado'],
            'sunday' => ['Desayuno domingo', 'Comida domingo', 'Merienda domingo', 'Cena domingo'],
        ];

        foreach ($mapping as $day => [$breakfastName, $lunchName, $snackName, $dinnerName]) {
            MealPlan::updateOrCreate(
                ['day_of_week' => $day],
                [
                    'breakfast_menu_id' => Menu::where('name', $breakfastName)->value('id'),
                    'lunch_menu_id' => Menu::where('name', $lunchName)->value('id'),
                    'snack_menu_id' => Menu::where('name', $snackName)->value('id'),
                    'dinner_menu_id' => Menu::where('name', $dinnerName)->value('id'),
                ]
            );
        }
    }
}
