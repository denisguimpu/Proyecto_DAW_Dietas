<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ShoppingList extends Model
{
    protected $fillable = ['name'];

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'shopping_list_ingredient', 'shopping_list_id', 'ingredient_name', 'id', 'name')->withPivot('quantity');
    }
}
