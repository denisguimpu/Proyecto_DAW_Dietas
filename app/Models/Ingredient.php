<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name', 'gr_ration', 'kcal', 'protein', 'fats', 'carbs', 'unit', 'category'];

    public $timestamps = false;

    protected $primaryKey = 'name';
    public $incrementing = false;
    protected $keyType = 'string';

    public function diets()
    {
        return $this->belongsToMany(Diet::class, 'diet_ingredient');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_ingredient', 'ingredient_name', 'menu_id', 'name', 'id');
    }

    public function getRouteKeyName(): string
    {
        return 'name';
    }
}