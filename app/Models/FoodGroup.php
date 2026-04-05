<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodGroup extends Model
{
    protected $fillable = ['name'];

    public function diets()
    {
        return $this->belongsToMany(Diet::class, 'diet_food_group');
    }
}
