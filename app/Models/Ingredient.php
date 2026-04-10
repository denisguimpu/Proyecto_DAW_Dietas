<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'gr_ration', 'kcal', 'protein', 'fats', 'carbs'];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_ingredient', 'ingredient_id', 'menu_id');
    }

    public function diets()
    {
        return $this->menus();
    }

    public function getRouteKeyName(): string
    {
        return 'name';
    }
}
