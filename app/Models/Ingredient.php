<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $primaryKey = 'name';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['name', 'gr_ration', 'kcal', 'protein', 'fats', 'carbs'];

    public function diets()
    {
        return $this->belongsToMany(Diet::class, 'diet_ingredient', 'ingredient_name', 'diet_id', 'name', 'id');
    }

    public function getRouteKeyName(): string
    {
        return 'name';
    }
}
