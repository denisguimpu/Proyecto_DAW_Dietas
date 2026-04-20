<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Diet extends Model
{
    protected $fillable = [
        'name', 
        'description',
        'weight',
        'height', 
        'age', 
        'gender', 
        'activity_level', 
        'goal',
        'target_calories',
        'target_protein', 
        'target_carbs', 
        'target_fats'
    ];

    protected $casts = [
        'weight' => 'float',
        'height' => 'float',
        'age' => 'integer',
        'target_calories' => 'float',
        'target_protein' => 'float',
        'target_carbs' => 'float',
        'target_fats' => 'float',
    ];

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'diet_ingredient', 'diet_id', 'ingredient_name', 'id', 'name');
    }

    public function mealPlans()
    {
        return $this->hasMany(MealPlan::class);
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    public function getTotalCaloriesAttribute(): float
    {
        return (float) $this->ingredients->sum('kcal');
    }

    public function getTotalProteinAttribute(): float
    {
        return (float) $this->ingredients->sum('protein');
    }

    public function getTotalFatsAttribute(): float
    {
        return (float) $this->ingredients->sum('fats');
    }

    public function getTotalCarbsAttribute(): float
    {
        return (float) $this->ingredients->sum('carbs');
    }

    public function calculateTarget(): array
    {
        if (!$this->weight || !$this->height || !$this->age || !$this->gender || !$this->activity_level || !$this->goal) {
            return [];
        }

        if ($this->gender === 'male') {
            $tmb = 10 * $this->weight + 6.25 * $this->height - 5 * $this->age + 5;
        } else {
            $tmb = 10 * $this->weight + 6.25 * $this->height - 5 * $this->age - 161;
        }

        $maintenance = $tmb * (float) $this->activity_level;

        $targetKcal = match ($this->goal) {
            'deficit' => $maintenance - 500,
            'volume' => $maintenance + 500,
            default => $maintenance,
        };

        return [
            'calories' => round($targetKcal),
            'protein' => round($targetKcal * 0.3 / 4),
            'carbs' => round($targetKcal * 0.4),
            'fats' => round($targetKcal * 0.3 / 9),
        ];
    }
}
