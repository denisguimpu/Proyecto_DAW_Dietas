<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Ingredient;
use App\Models\Menu;
use App\Models\Meal;
use App\Models\MealPlan;
use App\Models\FoodGroup;
use App\Models\ShoppingList;
use App\Models\User;

class RelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_ingredient_relationships()
    {
        $ingredient = Ingredient::create([
            'name' => 'Ingrediente 1',
            'kcal' => 100,
            'fats' => 10,
            'carbs' => 10,
            'protein' => 10,
            'gr_ration' => 100
        ]);

        $menu = Menu::create(['name' => 'Menu 1']);
        
        // Test menus relationship
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $ingredient->menus());
        
        // Test diets relationship
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $ingredient->diets());
    }

    public function test_meal_relationships()
    {
        $ingredient = Ingredient::create([
            'name' => 'Test',
            'kcal' => 100,
            'fats' => 10,
            'carbs' => 10,
            'protein' => 10,
            'gr_ration' => 100
        ]);

        $mealPlan = MealPlan::create(['day_of_week' => 'monday']);
        $meal = Meal::create([
            'meal_plan_id' => $mealPlan->id,
            'meal_type' => 'breakfast',
            'ingredient_name' => 'Test',
            'quantity' => 100
        ]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $meal->mealPlan());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $meal->ingredient());
    }

    public function test_food_group_relationships()
    {
        $group = FoodGroup::create(['name' => 'Group 1']);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $group->menus());
    }

    public function test_shopping_list_relationships()
    {
        $list = ShoppingList::create(['name' => 'List 1']);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $list->ingredients());
    }
}
