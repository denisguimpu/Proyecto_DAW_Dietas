<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model
{
    protected $table = 'menus';

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
        return $this->belongsToMany(Ingredient::class, 'menu_ingredient', 'menu_id', 'ingredient_name', 'id', 'name');
    }

    public function foodGroups()
    {
        return $this->belongsToMany(FoodGroup::class, 'menu_food_group', 'menu_id', 'food_group_id');
    }

    public function calculateTarget(): array
    {
        if (!$this->weight || !$this->height || !$this->age || !$this->gender || !$this->activity_level || !$this->goal) {
            return [];
        }

        // Calcular TMB (Metabolismo Basal)
        if ($this->gender === 'male') {
            $tmb = 10 * $this->weight + 6.25 * $this->height - 5 * $this->age + 5;
        } else {
            $tmb = 10 * $this->weight + 6.25 * $this->height - 5 * $this->age - 161;
        }

        // Gasto energético total
        $maintenance = $tmb * (float) $this->activity_level;

        // Ajuste por objetivo
        $targetKcal = match ($this->goal) {
            'deficit' => $maintenance - 500,
            'volume' => $maintenance + 500,
            default => $maintenance,
        };

        // Distribución de macros que cuadra con las kcal:
        // Proteína: 2g por kg (aprox 25% kcal)
        // Grasas: 0.8g por kg (aprox 20% kcal)  
        // Carbohidratos: resto de kcal (aprox 55% kcal)
        
        $protein = round($this->weight * 2);
        $fats = round($this->weight * 0.8);
        
        // Calorías que quedan para carbs
        $proteinKcal = $protein * 4;
        $fatsKcal = $fats * 9;
        $remainingKcal = $targetKcal - $proteinKcal - $fatsKcal;
        $carbs = round($remainingKcal / 4);

        return [
            'calories' => round($targetKcal),
            'protein' => $protein,
            'carbs' => max(0, $carbs),
            'fats' => $fats,
        ];
    }
}