<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name', 'calories', 'protein', 'fats', 'carbs', 'unit', 'category'];

    public function diets() {
    return $this->belongsToMany(Diet::class);
}
}
