<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    // Campos editables
    protected $fillable = ['name', 'description'];

    // Relación con ingredientes
    public function ingredients() {
        return $this->belongsToMany(Ingredient::class, 'diet_ingredient', 'diet_id', 'ingredient_name', 'id', 'name');
    }

    public function foodGroups()
    {
        return $this->belongsToMany(FoodGroup::class, 'diet_food_group');
    }

    // Suma calorías
    public function totalCalories()
    {
        return $this->ingredients->sum(function ($ingredient) {
            $grRation = (float) ($ingredient->gr_ration ?? 0);
            $kcalPer100 = (float) ($ingredient->kcal ?? 0);

            return $kcalPer100 * ($grRation / 100);
        });
    }

    // Suma proteínas
    public function totalProtein()
    {
        return $this->ingredients->sum('protein');
    }

    // Suma carbohidratos
    public function totalCarbs()
    {
        return $this->ingredients->sum('carbs');
    }

    // Suma grasas
    public function totalFats()
    {
        return $this->ingredients->sum('fats');
    }
}
