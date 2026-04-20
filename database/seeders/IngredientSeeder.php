<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            ['name' => 'Pollo (pechuga)', 'kcal' => 109, 'protein' => 23, 'fats' => 1.2, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Carne molida (vacuno)', 'kcal' => 250, 'protein' => 26, 'fats' => 15, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Cerdo (lomo)', 'kcal' => 143, 'protein' => 26, 'fats' => 3.5, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Bacalao', 'kcal' => 82, 'protein' => 18, 'fats' => 0.7, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Salmón', 'kcal' => 208, 'protein' => 20, 'fats' => 13, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Atún', 'kcal' => 132, 'protein' => 28, 'fats' => 1, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Huevos (1 unidad = 50g)', 'kcal' => 155, 'protein' => 13, 'fats' => 11, 'carbs' => 1.1, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Claras de huevo', 'kcal' => 52, 'protein' => 11, 'fats' => 0.2, 'carbs' => 0.7, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Leche entera', 'kcal' => 61, 'protein' => 3.2, 'fats' => 3.3, 'carbs' => 4.8, 'unit' => 'g', 'category' => 'lacteo'],
            ['name' => 'Leche semidesnatada', 'kcal' => 45, 'protein' => 3.4, 'fats' => 1.5, 'carbs' => 4.8, 'unit' => 'g', 'category' => 'lacteo'],
            ['name' => 'Queso cheddar', 'kcal' => 403, 'protein' => 25, 'fats' => 33, 'carbs' => 1.3, 'unit' => 'g', 'category' => 'lacteo'],
            ['name' => 'Queso mozzarella', 'kcal' => 280, 'protein' => 28, 'fats' => 17, 'carbs' => 3.1, 'unit' => 'g', 'category' => 'lacteo'],
            ['name' => 'Yogur natural', 'kcal' => 59, 'protein' => 10, 'fats' => 0.4, 'carbs' => 3.6, 'unit' => 'g', 'category' => 'lacteo'],
            ['name' => 'Arroz blanco', 'kcal' => 359, 'protein' => 7, 'fats' => 0.7, 'carbs' => 79, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Arroz integral', 'kcal' => 370, 'protein' => 8, 'fats' => 2.9, 'carbs' => 77, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Pasta (macarrones)', 'kcal' => 371, 'protein' => 13, 'fats' => 1.5, 'carbs' => 75, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Patatas', 'kcal' => 77, 'protein' => 2, 'fats' => 0.1, 'carbs' => 17, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Pan blanco', 'kcal' => 265, 'protein' => 9, 'fats' => 3.2, 'carbs' => 49, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Pan integral', 'kcal' => 247, 'protein' => 13, 'fats' => 3.4, 'carbs' => 41, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Avena', 'kcal' => 389, 'protein' => 17, 'fats' => 7, 'carbs' => 66, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Lentejas', 'kcal' => 116, 'protein' => 9, 'fats' => 0.4, 'carbs' => 20, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Garbanzos', 'kcal' => 164, 'protein' => 9, 'fats' => 2.6, 'carbs' => 27, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Judías negras', 'kcal' => 132, 'protein' => 9, 'fats' => 0.5, 'carbs' => 24, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Alubias', 'kcal' => 127, 'protein' => 9, 'fats' => 0.5, 'carbs' => 23, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Brocoli', 'kcal' => 34, 'protein' => 2.8, 'fats' => 0.4, 'carbs' => 7, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Espinacas', 'kcal' => 23, 'protein' => 2.9, 'fats' => 0.4, 'carbs' => 3.6, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Zanahorias', 'kcal' => 41, 'protein' => 0.9, 'fats' => 0.2, 'carbs' => 10, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Tomates', 'kcal' => 18, 'protein' => 0.9, 'fats' => 0.2, 'carbs' => 3.9, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Cebollas', 'kcal' => 40, 'protein' => 1.1, 'fats' => 0.1, 'carbs' => 9, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Pimientos', 'kcal' => 31, 'protein' => 1, 'fats' => 0.3, 'carbs' => 6, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Ajos', 'kcal' => 149, 'protein' => 6.4, 'fats' => 0.5, 'carbs' => 33, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Calabacín', 'kcal' => 17, 'protein' => 1.2, 'fats' => 0.3, 'carbs' => 3.1, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Lechuga', 'kcal' => 15, 'protein' => 1.4, 'fats' => 0.2, 'carbs' => 2.9, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Pepino', 'kcal' => 16, 'protein' => 0.7, 'fats' => 0.1, 'carbs' => 3.6, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Champiñones', 'kcal' => 22, 'protein' => 3.1, 'fats' => 0.3, 'carbs' => 3.3, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Berenjena', 'kcal' => 25, 'protein' => 1, 'fats' => 0.2, 'carbs' => 6, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Coliflor', 'kcal' => 25, 'protein' => 1.9, 'fats' => 0.3, 'carbs' => 5, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Judías verdes', 'kcal' => 31, 'protein' => 1.8, 'fats' => 0.1, 'carbs' => 7, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Guisantes', 'kcal' => 81, 'protein' => 5.4, 'fats' => 0.4, 'carbs' => 14, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Plátano', 'kcal' => 89, 'protein' => 1.1, 'fats' => 0.3, 'carbs' => 23, 'unit' => 'g', 'category' => 'fruta'],
            ['name' => 'Manzana', 'kcal' => 52, 'protein' => 0.3, 'fats' => 0.2, 'carbs' => 14, 'unit' => 'g', 'category' => 'fruta'],
            ['name' => 'Naranja', 'kcal' => 47, 'protein' => 0.9, 'fats' => 0.1, 'carbs' => 12, 'unit' => 'g', 'category' => 'fruta'],
            ['name' => 'Fresas', 'kcal' => 32, 'protein' => 0.7, 'fats' => 0.3, 'carbs' => 7.7, 'unit' => 'g', 'category' => 'fruta'],
            ['name' => 'Uvas', 'kcal' => 69, 'protein' => 0.7, 'fats' => 0.2, 'carbs' => 18, 'unit' => 'g', 'category' => 'fruta'],
            ['name' => 'Aguacate', 'kcal' => 160, 'protein' => 2, 'fats' => 15, 'carbs' => 9, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Aceitunas', 'kcal' => 145, 'protein' => 1, 'fats' => 15, 'carbs' => 3.8, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Almendras', 'kcal' => 579, 'protein' => 21, 'fats' => 50, 'carbs' => 22, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Nueces', 'kcal' => 654, 'protein' => 15, 'fats' => 65, 'carbs' => 14, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Pistachos', 'kcal' => 560, 'protein' => 20, 'fats' => 45, 'carbs' => 28, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Piñones', 'kcal' => 673, 'protein' => 13, 'fats' => 68, 'carbs' => 13, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Aceite de oliva', 'kcal' => 884, 'protein' => 0, 'fats' => 100, 'carbs' => 0, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Mantequilla', 'kcal' => 717, 'protein' => 0.9, 'fats' => 81, 'carbs' => 0.1, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Quinoa', 'kcal' => 368, 'protein' => 14, 'fats' => 6, 'carbs' => 64, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Tofu', 'kcal' => 76, 'protein' => 8, 'fats' => 4.8, 'carbs' => 1.9, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Pavo (pechuga)', 'kcal' => 135, 'protein' => 30, 'fats' => 1, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Merluza', 'kcal' => 87, 'protein' => 19, 'fats' => 0.7, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Sardinas', 'kcal' => 208, 'protein' => 25, 'fats' => 11, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Jamón serrano', 'kcal' => 265, 'protein' => 25, 'fats' => 18, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Parmesano', 'kcal' => 431, 'protein' => 38, 'fats' => 29, 'carbs' => 4.1, 'unit' => 'g', 'category' => 'lacteo'],
            ['name' => 'Ricotta', 'kcal' => 174, 'protein' => 11, 'fats' => 13, 'carbs' => 3, 'unit' => 'g', 'category' => 'lacteo'],
            ['name' => 'Tomate frito', 'kcal' => 91, 'protein' => 1.9, 'fats' => 5, 'carbs' => 9.4, 'unit' => 'g', 'category' => 'verdura'],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}