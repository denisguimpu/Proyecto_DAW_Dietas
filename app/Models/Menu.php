<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    // Campos editables
    protected $fillable = ['name', 'description'];

    // Relación con ingredientes
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'menu_ingredient', 'menu_id', 'ingredient_name', 'id', 'name');
    }

    public function foodGroups()
    {
        return $this->belongsToMany(FoodGroup::class, 'menu_food_group', 'menu_id', 'food_group_id');
    }
}
