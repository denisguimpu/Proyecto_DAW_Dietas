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

    // Suma calorías
    public function totalCalories()
    {
        return $this->ingredients->sum('kcal');
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
