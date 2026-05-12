<?php

namespace App\Http\Controllers;

use App\Models\MealPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShoppingListController extends Controller
{
    public function index()
    {
        $mealPlans = MealPlan::with([
            'meals.ingredient',
            'breakfastMenu.ingredients',
            'lunchMenu.ingredients',
            'snackMenu.ingredients',
            'dinnerMenu.ingredients',
        ])->get();

        $allMeals = [];

        // Aggregate explicit Meal rows if present
        foreach ($mealPlans as $plan) {
            if ($plan->meals) {
                foreach ($plan->meals as $meal) {
                    $ingredientName = $meal->ingredient_name;
                    if ($ingredientName) {
                        if (!isset($allMeals[$ingredientName])) {
                            $allMeals[$ingredientName] = [
                                'name' => $ingredientName,
                                'quantity' => 0,
                            ];
                        }
                        $allMeals[$ingredientName]['quantity'] += $meal->quantity;
                    }
                }
            }
        }

        // Fallback: if there are no Meal rows, build list from assigned menus' ingredients
        if (empty($allMeals)) {
            $slots = ['breakfastMenu', 'lunchMenu', 'snackMenu', 'dinnerMenu'];
            foreach ($mealPlans as $plan) {
                foreach ($slots as $slot) {
                    $menu = $plan->$slot;
                    if (! $menu || ! isset($menu->ingredients)) {
                        continue;
                    }
                    foreach ($menu->ingredients as $ingredient) {
                        $ingredientName = $ingredient->name;
                        $qty = $ingredient->gr_ration ?? $this->grFromJson($ingredientName) ?? 0;
                        if (!isset($allMeals[$ingredientName])) {
                            $allMeals[$ingredientName] = [
                                'name' => $ingredientName,
                                'quantity' => 0,
                            ];
                        }
                        $allMeals[$ingredientName]['quantity'] += $qty;
                    }
                }
            }
        }

        // Convert to indexed array and sort by name
        $allMeals = array_values($allMeals);
        usort($allMeals, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return view('shopping-lists.index', compact('allMeals'));
    }

    private function grFromJson(string $name)
    {
        static $map = null;
        if ($map === null) {
            $jsonPath = database_path('data/ingredients.json');
            if (!file_exists($jsonPath)) {
                $map = [];
            } else {
                $items = json_decode(file_get_contents($jsonPath), true) ?: [];
                $map = [];
                foreach ($items as $it) {
                    $n = Str::ascii(Str::lower(trim($it['name'] ?? '')));
                    if ($n) {
                        $map[$n] = $it['gr_ration'] ?? ($it['gr_racion'] ?? null);
                    }
                }
            }
        }

        $key = Str::ascii(Str::lower(trim($name)));
        return $map[$key] ?? null;
    }

    public function create()
    {
        return redirect()->route('shopping-lists.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('shopping-lists.index');
    }

    public function show($id)
    {
        return redirect()->route('shopping-lists.index');
    }

    public function destroy($id)
    {
        return redirect()->route('shopping-lists.index');
    }
}
