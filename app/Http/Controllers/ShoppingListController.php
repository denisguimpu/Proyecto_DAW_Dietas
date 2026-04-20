<?php

namespace App\Http\Controllers;

use App\Models\MealPlan;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    public function index()
    {
        $mealPlans = MealPlan::with(['meals.ingredient'])->get();
        
        $allMeals = [];
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
        
        usort($allMeals, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        
        return view('shopping-lists.index', compact('allMeals'));
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