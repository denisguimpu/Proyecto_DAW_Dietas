<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            ['name' => 'Pollo (pechuga)', 'calories' => 109, 'protein' => 23, 'fats' => 1.2, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Carne molida (vacuno)', 'calories' => 250, 'protein' => 26, 'fats' => 15, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Cerdo (lomo)', 'calories' => 143, 'protein' => 26, 'fats' => 3.5, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Bacalao', 'calories' => 82, 'protein' => 18, 'fats' => 0.7, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Salmón', 'calories' => 208, 'protein' => 20, 'fats' => 13, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Atún', 'calories' => 132, 'protein' => 28, 'fats' => 1, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Huevos (1 unidad = 50g)', 'calories' => 155, 'protein' => 13, 'fats' => 11, 'carbs' => 1.1, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Claras de huevo', 'calories' => 52, 'protein' => 11, 'fats' => 0.2, 'carbs' => 0.7, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Leche entera', 'calories' => 61, 'protein' => 3.2, 'fats' => 3.3, 'carbs' => 4.8, 'unit' => 'g', 'category' => 'lacteo'],
            ['name' => 'Leche semidesnatada', 'calories' => 45, 'protein' => 3.4, 'fats' => 1.5, 'carbs' => 4.8, 'unit' => 'g', 'category' => 'lacteo'],
            ['name' => 'Queso cheddar', 'calories' => 403, 'protein' => 25, 'fats' => 33, 'carbs' => 1.3, 'unit' => 'g', 'category' => 'lacteo'],
            ['name' => 'Queso mozzarella', 'calories' => 280, 'protein' => 28, 'fats' => 17, 'carbs' => 3.1, 'unit' => 'g', 'category' => 'lacteo'],
            ['name' => 'Yogur natural', 'calories' => 59, 'protein' => 10, 'fats' => 0.4, 'carbs' => 3.6, 'unit' => 'g', 'category' => 'lacteo'],
            ['name' => 'Arroz blanco', 'calories' => 359, 'protein' => 7, 'fats' => 0.7, 'carbs' => 79, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Arroz integral', 'calories' => 370, 'protein' => 8, 'fats' => 2.9, 'carbs' => 77, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Pasta (macarrones)', 'calories' => 371, 'protein' => 13, 'fats' => 1.5, 'carbs' => 75, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Patatas', 'calories' => 77, 'protein' => 2, 'fats' => 0.1, 'carbs' => 17, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Pan blanco', 'calories' => 265, 'protein' => 9, 'fats' => 3.2, 'carbs' => 49, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Pan integral', 'calories' => 247, 'protein' => 13, 'fats' => 3.4, 'carbs' => 41, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Avena', 'calories' => 389, 'protein' => 17, 'fats' => 7, 'carbs' => 66, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Lentejas', 'calories' => 116, 'protein' => 9, 'fats' => 0.4, 'carbs' => 20, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Garbanzos', 'calories' => 164, 'protein' => 9, 'fats' => 2.6, 'carbs' => 27, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Judías negras', 'calories' => 132, 'protein' => 9, 'fats' => 0.5, 'carbs' => 24, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Alubias', 'calories' => 127, 'protein' => 9, 'fats' => 0.5, 'carbs' => 23, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Brocoli', 'calories' => 34, 'protein' => 2.8, 'fats' => 0.4, 'carbs' => 7, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Espinacas', 'calories' => 23, 'protein' => 2.9, 'fats' => 0.4, 'carbs' => 3.6, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Zanahorias', 'calories' => 41, 'protein' => 0.9, 'fats' => 0.2, 'carbs' => 10, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Tomates', 'calories' => 18, 'protein' => 0.9, 'fats' => 0.2, 'carbs' => 3.9, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Cebollas', 'calories' => 40, 'protein' => 1.1, 'fats' => 0.1, 'carbs' => 9, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Pimientos', 'calories' => 31, 'protein' => 1, 'fats' => 0.3, 'carbs' => 6, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Ajos', 'calories' => 149, 'protein' => 6.4, 'fats' => 0.5, 'carbs' => 33, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Calabacín', 'calories' => 17, 'protein' => 1.2, 'fats' => 0.3, 'carbs' => 3.1, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Lechuga', 'calories' => 15, 'protein' => 1.4, 'fats' => 0.2, 'carbs' => 2.9, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Pepino', 'calories' => 16, 'protein' => 0.7, 'fats' => 0.1, 'carbs' => 3.6, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Champiñones', 'calories' => 22, 'protein' => 3.1, 'fats' => 0.3, 'carbs' => 3.3, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Berenjena', 'calories' => 25, 'protein' => 1, 'fats' => 0.2, 'carbs' => 6, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Coliflor', 'calories' => 25, 'protein' => 1.9, 'fats' => 0.3, 'carbs' => 5, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Judías verdes', 'calories' => 31, 'protein' => 1.8, 'fats' => 0.1, 'carbs' => 7, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Guisantes', 'calories' => 81, 'protein' => 5.4, 'fats' => 0.4, 'carbs' => 14, 'unit' => 'g', 'category' => 'verdura'],
            ['name' => 'Plátano', 'calories' => 89, 'protein' => 1.1, 'fats' => 0.3, 'carbs' => 23, 'unit' => 'g', 'category' => 'fruta'],
            ['name' => 'Manzana', 'calories' => 52, 'protein' => 0.3, 'fats' => 0.2, 'carbs' => 14, 'unit' => 'g', 'category' => 'fruta'],
            ['name' => 'Naranja', 'calories' => 47, 'protein' => 0.9, 'fats' => 0.1, 'carbs' => 12, 'unit' => 'g', 'category' => 'fruta'],
            ['name' => 'Fresas', 'calories' => 32, 'protein' => 0.7, 'fats' => 0.3, 'carbs' => 7.7, 'unit' => 'g', 'category' => 'fruta'],
            ['name' => 'Uvas', 'calories' => 69, 'protein' => 0.7, 'fats' => 0.2, 'carbs' => 18, 'unit' => 'g', 'category' => 'fruta'],
            ['name' => 'Aguacate', 'calories' => 160, 'protein' => 2, 'fats' => 15, 'carbs' => 9, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Aceitunas', 'calories' => 145, 'protein' => 1, 'fats' => 15, 'carbs' => 3.8, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Almendras', 'calories' => 579, 'protein' => 21, 'fats' => 50, 'carbs' => 22, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Nueces', 'calories' => 654, 'protein' => 15, 'fats' => 65, 'carbs' => 14, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Pistachos', 'calories' => 560, 'protein' => 20, 'fats' => 45, 'carbs' => 28, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Piñones', 'calories' => 673, 'protein' => 13, 'fats' => 68, 'carbs' => 13, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Aceite de oliva', 'calories' => 884, 'protein' => 0, 'fats' => 100, 'carbs' => 0, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Mantequilla', 'calories' => 717, 'protein' => 0.9, 'fats' => 81, 'carbs' => 0.1, 'unit' => 'g', 'category' => 'grasa'],
            ['name' => 'Quinoa', 'calories' => 368, 'protein' => 14, 'fats' => 6, 'carbs' => 64, 'unit' => 'g', 'category' => 'carbohidratos'],
            ['name' => 'Tofu', 'calories' => 76, 'protein' => 8, 'fats' => 4.8, 'carbs' => 1.9, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Pavo (pechuga)', 'calories' => 135, 'protein' => 30, 'fats' => 1, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Merluza', 'calories' => 87, 'protein' => 19, 'fats' => 0.7, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Sardinas', 'calories' => 208, 'protein' => 25, 'fats' => 11, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Jamón serrano', 'calories' => 265, 'protein' => 25, 'fats' => 18, 'carbs' => 0, 'unit' => 'g', 'category' => 'proteina'],
            ['name' => 'Parmesano', 'calories' => 431, 'protein' => 38, 'fats' => 29, 'carbs' => 4.1, 'unit' => 'g', 'category' => 'lacteo'],
            ['name' => 'Ricotta', 'calories' => 174, 'protein' => 11, 'fats' => 13, 'carbs' => 3, 'unit' => 'g', 'category' => 'lacteo'],
            ['name' => 'Tomate frito', 'calories' => 91, 'protein' => 1.9, 'fats' => 5, 'carbs' => 9.4, 'unit' => 'g', 'category' => 'verdura'],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}