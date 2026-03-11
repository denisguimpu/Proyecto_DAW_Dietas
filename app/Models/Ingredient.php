<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    // Define the fillable fields for mass assignment
    protected $fillable = ['name', 'calories', 'protein', 'fats', 'carbs', 'unit'];


    public function diets() {
    return $this->belongsToMany(Diet::class);
}
}
