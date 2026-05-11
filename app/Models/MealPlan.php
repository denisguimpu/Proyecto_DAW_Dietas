<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealPlan extends Model
{
    protected $fillable = ['day_of_week', 'breakfast_menu_id', 'lunch_menu_id', 'snack_menu_id', 'dinner_menu_id'];

    protected $casts = [
        'day_of_week' => 'string',
    ];

    public function breakfastMenu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'breakfast_menu_id');
    }

    public function lunchMenu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'lunch_menu_id');
    }

    public function snackMenu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'snack_menu_id');
    }

    public function dinnerMenu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'dinner_menu_id');
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}