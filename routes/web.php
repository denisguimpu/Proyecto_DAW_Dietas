<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\MenuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Rutas de Ingredientes
    Route::get('/ingredients', [IngredientController::class, 'index'])->name('ingredients.index');
    Route::post('/ingredients', [IngredientController::class, 'store'])->name('ingredients.store');
    Route::get('/ingredients/{ingredient}/edit', [IngredientController::class, 'edit'])->name('ingredients.edit');
    Route::put('/ingredients/{ingredient}', [IngredientController::class, 'update'])->name('ingredients.update');
    Route::delete('/ingredients/{ingredient}', [IngredientController::class, 'destroy'])->name('ingredients.destroy');

    // Rutas de Dietas
    Route::get('/diets', [DietController::class, 'index'])->name('diets.index');
    Route::get('/diets/create', [DietController::class, 'create'])->name('diets.create');
    Route::post('/diets', [DietController::class, 'store'])->name('diets.store');
    Route::get('/diets/{id}', [DietController::class, 'show'])->name('diets.show');
    Route::get('/diets/{id}/edit', [DietController::class, 'edit'])->name('diets.edit');
    Route::put('/diets/{id}', [DietController::class, 'update'])->name('diets.update');
    Route::delete('/diets/{id}', [DietController::class, 'destroy'])->name('diets.destroy');

    // Rutas de Menús (del main)
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/menus/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/menus/{id}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{id}', [MenuController::class, 'update'])->name('menus.update');
    Route::get('/menus/{id}', [MenuController::class, 'show'])->name('menus.show');
    Route::delete('/menus/{id}', [MenuController::class, 'destroy'])->name('menus.destroy');
    Route::post('/menus/groups', [MenuController::class, 'storeFoodGroup'])->name('menus.groups.store');
    Route::put('/menus/groups/{id}', [MenuController::class, 'updateFoodGroup'])->name('menus.groups.update');
    Route::delete('/menus/groups/{id}', [MenuController::class, 'destroyFoodGroup'])->name('menus.groups.destroy');
});

// Rutas de Lista de la Compra
Route::get('/shopping-lists', [ShoppingListController::class, 'index'])->name('shopping-lists.index');
Route::get('/shopping-lists/create', [ShoppingListController::class, 'create'])->name('shopping-lists.create');
Route::post('/shopping-lists', [ShoppingListController::class, 'store'])->name('shopping-lists.store');
Route::get('/shopping-lists/{shoppingList}', [ShoppingListController::class, 'show'])->name('shopping-lists.show');
Route::delete('/shopping-lists/{shoppingList}', [ShoppingListController::class, 'destroy'])->name('shopping-lists.destroy');

// Rutas de Meal Plans
Route::get('/meal-plans', [MealPlanController::class, 'index'])->name('meal-plans.index');
Route::get('/meal-plans/create', [MealPlanController::class, 'create'])->name('meal-plans.create');
Route::post('/meal-plans', [MealPlanController::class, 'store'])->name('meal-plans.store');
Route::get('/meal-plans/{mealPlan}/edit', [MealPlanController::class, 'edit'])->name('meal-plans.edit');
Route::put('/meal-plans/{mealPlan}', [MealPlanController::class, 'update'])->name('meal-plans.update');
Route::delete('/meal-plans/{mealPlan}', [MealPlanController::class, 'destroy'])->name('meal-plans.destroy');

// Rutas por defecto de Laravel
Route::get('/', function () {
    return view('welcome');
});

use App\Models\Menu;
use App\Models\FoodGroup;
use App\Models\Ingredient;
use App\Models\MealPlan;

Route::get('/dashboard', function () {
    // Cogemos todos los planes de comida de la semana con relaciones
    $mealPlans = MealPlan::with([
        'meals.ingredient',
        'breakfastMenu.ingredients',
        'lunchMenu.ingredients',
        'snackMenu.ingredients',
        'dinnerMenu.ingredients',
    ])->get();

    // Dias de la semana
    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    $daysSpanish = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

    // Array para datos semanales
    $weeklyData = [];

    foreach ($days as $index => $day) {
        $plan = $mealPlans->firstWhere('day_of_week', $day);

        $totalKcal = 0;
        $totalProtein = 0;
        $totalCarbs = 0;
        $totalFats = 0;

        if ($plan) {
            // Strategy 1: Use explicit Meal rows if present
            if ($plan->meals && $plan->meals->count() > 0) {
                foreach ($plan->meals as $meal) {
                    if ($meal->ingredient) {
                        $ratio = $meal->quantity / 100;
                        $totalKcal += $meal->ingredient->kcal * $ratio;
                        $totalProtein += $meal->ingredient->protein * $ratio;
                        $totalCarbs += $meal->ingredient->carbs * $ratio;
                        $totalFats += $meal->ingredient->fats * $ratio;
                    }
                }
            } else {
                // Strategy 2: Fallback to assigned menus' ingredients
                $slots = ['breakfastMenu', 'lunchMenu', 'snackMenu', 'dinnerMenu'];
                foreach ($slots as $slot) {
                    $menu = $plan->$slot;
                    if ($menu && isset($menu->ingredients)) {
                        foreach ($menu->ingredients as $ingredient) {
                            $qty = $ingredient->gr_ration ?? 0;
                            $totalKcal += ($ingredient->kcal ?? 0) * $qty / 100;
                            $totalProtein += ($ingredient->protein ?? 0) * $qty / 100;
                            $totalCarbs += ($ingredient->carbs ?? 0) * $qty / 100;
                            $totalFats += ($ingredient->fats ?? 0) * $qty / 100;
                        }
                    }
                }
            }
        }

        $weeklyData[] = [
            'day' => $daysSpanish[$index],
            'kcal' => round($totalKcal),
            'protein' => round($totalProtein),
            'carbs' => round($totalCarbs),
            'fats' => round($totalFats),
        ];
    }

    return view('dashboard', [
        'stats' => [
            'ingredients' => Ingredient::count(),
            'menus' => Menu::count(),
            'foodGroups' => FoodGroup::count(),
        ],
        'weeklyData' => $weeklyData,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de Perfil (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
