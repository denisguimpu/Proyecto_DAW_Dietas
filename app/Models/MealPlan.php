<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealPlan extends Model
{
    protected $fillable = ['diet_id', 'day_of_week'];

    protected $casts = [
        'day_of_week' => 'string',
    ];

public function diet(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}