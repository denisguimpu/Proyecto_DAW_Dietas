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

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_ingredient', 'ingredient_name', 'menu_id', 'name', 'id');
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
