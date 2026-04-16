<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodGroup extends Model
{
    protected $fillable = ['name'];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_food_group', 'food_group_id', 'menu_id');
    }

    public function diets()
    {
        return $this->menus();
    }
}
