<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meal extends Model
{
    protected $fillable = ['meal_plan_id', 'diet_id', 'meal_type', 'ingredient_name', 'quantity'];

    protected $casts = [
        'quantity' => 'float',
    ];

    public function diet(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function ingredient(): BelongsTo
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_name', 'name');
    }
    
    public function mealPlan(): BelongsTo
    {
        return $this->belongsTo(MealPlan::class);
    }
}