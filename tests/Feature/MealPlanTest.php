<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\MealPlan;
use App\Models\Menu;
use App\Models\User;
use App\Models\Ingredient;
use App\Models\Meal;

class MealPlanTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_meal_plans_index()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/meal-plans');
        $response->assertStatus(200);
        $response->assertViewIs('meal-plans.index');
    }

    public function test_can_view_meal_plan_create_form()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/meal-plans/create');
        $response->assertStatus(200);
        $response->assertViewIs('meal-plans.create');
    }

    public function test_can_store_a_new_meal_plan()
    {
        $user = User::factory()->create();
        $menu = Menu::create(['name' => 'Test Menu']);

        $response = $this->actingAs($user)->post('/meal-plans', [
            'day_of_week' => 'monday',
            'breakfast_menu_id' => $menu->id,
        ]);

        $mealPlan = MealPlan::where('day_of_week', 'monday')->first();
        $this->assertNotNull($mealPlan);
        $response->assertRedirect(route('meal-plans.edit', $mealPlan->id));
    }

    public function test_meal_plan_creation_requires_valid_day_of_week()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/meal-plans', [
            'day_of_week' => 'invalid_day',
        ]);

        $response->assertSessionHasErrors('day_of_week');
    }

    public function test_can_update_meal_plan()
    {
        $user = User::factory()->create();
        $mealPlan = MealPlan::create(['day_of_week' => 'tuesday']);
        $menu = Menu::create(['name' => 'Test Menu']);

        $response = $this->actingAs($user)->put("/meal-plans/{$mealPlan->id}", [
            'lunch_menu_id' => $menu->id,
        ]);

        $mealPlan->refresh();
        $this->assertEquals($menu->id, $mealPlan->lunch_menu_id);
        $response->assertRedirect(route('meal-plans.index'));
    }

    public function test_can_view_meal_plan_edit_form()
    {
        $user = User::factory()->create();
        $menu = Menu::create(['name' => 'Desayuno Menu']);
        $mealPlan = MealPlan::create(['day_of_week' => 'sunday', 'breakfast_menu_id' => $menu->id]);

        $response = $this->actingAs($user)->get("/meal-plans/{$mealPlan->id}/edit");
        $response->assertStatus(200);
        $response->assertViewIs('meal-plans.edit');
    }

    public function test_can_update_meal_plan_with_meals()
    {
        $user = User::factory()->create();
        $mealPlan = MealPlan::create(['day_of_week' => 'friday']);
        
        Ingredient::create([
            'name' => 'Avena',
            'kcal' => 389,
            'fats' => 6.9,
            'carbs' => 66,
            'protein' => 16.9,
            'gr_ration' => 100,
        ]);

        $response = $this->actingAs($user)->put("/meal-plans/{$mealPlan->id}", [
            'day_of_week' => 'friday',
            'meals' => [
                'desayuno' => [
                    ['ingredient_name' => 'Avena', 'quantity' => 50],
                ]
            ]
        ]);

        $this->assertDatabaseHas('meals', [
            'meal_plan_id' => $mealPlan->id,
            'ingredient_name' => 'Avena',
            'quantity' => 50,
        ]);
        $response->assertRedirect(route('meal-plans.index'));
    }

    public function test_can_delete_meal_plan()
    {
        $user = User::factory()->create();
        $mealPlan = MealPlan::create(['day_of_week' => 'wednesday']);

        $response = $this->actingAs($user)->delete("/meal-plans/{$mealPlan->id}");

        $this->assertDatabaseMissing('meal_plans', [
            'id' => $mealPlan->id,
        ]);
        $response->assertRedirect(route('meal-plans.index'));
    }
}
