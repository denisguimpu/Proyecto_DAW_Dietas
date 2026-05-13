<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Ingredient;

class IngredientTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_view_ingredients_index()
    {
        $response = $this->actingAs($this->user)->get('/ingredients');
        $response->assertStatus(200);
        $response->assertViewIs('ingredients.index');
    }

    public function test_can_store_ingredient()
    {
        $response = $this->actingAs($this->user)->post('/ingredients', [
            'name' => 'Manzana',
            'kcal' => 52,
            'fats' => 0.2,
            'carbs' => 14,
            'protein' => 0.3,
            'gr_ration' => 100,
        ]);

        $this->assertDatabaseHas('ingredients', [
            'name' => 'Manzana',
            'kcal' => 52,
        ]);
        $response->assertRedirect(route('ingredients.index'));
    }

    public function test_ingredient_store_validation()
    {
        $response = $this->actingAs($this->user)->post('/ingredients', [
            'name' => '', // Fails required
            'kcal' => 'abc', // Fails numeric
        ]);

        $response->assertSessionHasErrors(['name', 'kcal']);
    }

    public function test_can_view_edit_ingredient()
    {
        $ingredient = Ingredient::create([
            'name' => 'Pera',
            'kcal' => 57,
            'fats' => 0.1,
            'carbs' => 15,
            'protein' => 0.4,
            'gr_ration' => 100,
        ]);

        $response = $this->actingAs($this->user)->get("/ingredients/{$ingredient->name}/edit");
        $response->assertStatus(200);
        $response->assertViewIs('ingredients.edit');
    }

    public function test_can_update_ingredient()
    {
        $ingredient = Ingredient::create([
            'name' => 'Platano',
            'kcal' => 89,
            'fats' => 0.3,
            'carbs' => 23,
            'protein' => 1.1,
            'gr_ration' => 100,
        ]);

        $response = $this->actingAs($this->user)->put("/ingredients/{$ingredient->name}", [
            'name' => 'Platano',
            'kcal' => 95,
            'fats' => 0.3,
            'carbs' => 23,
            'protein' => 1.1,
            'gr_ration' => 100,
        ]);

        $this->assertDatabaseHas('ingredients', [
            'name' => 'Platano',
            'kcal' => 95,
        ]);
        $response->assertRedirect(route('ingredients.index'));
    }

    public function test_can_update_ingredient_name()
    {
        $ingredient = Ingredient::create([
            'name' => 'Fresa',
            'kcal' => 32,
            'fats' => 0.3,
            'carbs' => 7.7,
            'protein' => 0.7,
            'gr_ration' => 100,
        ]);

        $response = $this->actingAs($this->user)->put("/ingredients/{$ingredient->name}", [
            'name' => 'Freson',
            'kcal' => 32,
            'fats' => 0.3,
            'carbs' => 7.7,
            'protein' => 0.7,
            'gr_ration' => 100,
        ]);

        $this->assertDatabaseHas('ingredients', [
            'name' => 'Freson',
        ]);
        $this->assertDatabaseMissing('ingredients', [
            'name' => 'Fresa',
        ]);
        $response->assertRedirect(route('ingredients.index'));
    }

    public function test_can_delete_ingredient()
    {
        $ingredient = Ingredient::create([
            'name' => 'Uva',
            'kcal' => 67,
            'fats' => 0.4,
            'carbs' => 17,
            'protein' => 0.6,
            'gr_ration' => 100,
        ]);

        $response = $this->actingAs($this->user)->delete("/ingredients/{$ingredient->name}");

        $this->assertDatabaseMissing('ingredients', [
            'name' => 'Uva',
        ]);
        $response->assertRedirect(route('ingredients.index'));
    }
}
