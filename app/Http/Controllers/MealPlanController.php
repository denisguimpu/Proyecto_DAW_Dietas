<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MealPlan;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealPlanController extends Controller
{
    public function index()
    {
        $mealPlans = MealPlan::with(['breakfastMenu', 'lunchMenu', 'snackMenu', 'dinnerMenu', 'meals.ingredient'])->get();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $daysSpanish = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];
        
        $plansByDay = [];
        foreach ($days as $index => $day) {
            $plansByDay[$day] = $mealPlans->firstWhere('day_of_week', $day);
        }
        
        return view('meal-plans.index', compact('plansByDay', 'days', 'daysSpanish'));
    }

    public function create(Request $request)
    {
        $menus = Menu::all();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $daysSpanish = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];
        $selectedDay = $request->get('day');
        
        return view('meal-plans.create', compact('menus', 'days', 'daysSpanish', 'selectedDay'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'breakfast_menu_id' => 'nullable|exists:menus,id',
            'lunch_menu_id' => 'nullable|exists:menus,id',
            'snack_menu_id' => 'nullable|exists:menus,id',
            'dinner_menu_id' => 'nullable|exists:menus,id',
        ]);

        $mealPlan = MealPlan::updateOrCreate(
            ['day_of_week' => $request->day_of_week],
            [
                'breakfast_menu_id' => $request->breakfast_menu_id,
                'lunch_menu_id' => $request->lunch_menu_id,
                'snack_menu_id' => $request->snack_menu_id,
                'dinner_menu_id' => $request->dinner_menu_id,
            ]
        );

        return redirect()->route('meal-plans.edit', $mealPlan->id);
    }

    public function edit(MealPlan $mealPlan)
    {
        $mealPlan->load([
            'breakfastMenu.ingredients', 
            'lunchMenu.ingredients', 
            'snackMenu.ingredients', 
            'dinnerMenu.ingredients', 
            'meals.ingredient'
        ]);
        
        $mealTypes = [
            'desayuno' => $mealPlan->breakfastMenu,
            'comida' => $mealPlan->lunchMenu,
            'merienda' => $mealPlan->snackMenu,
            'cena' => $mealPlan->dinnerMenu,
        ];
        
        $ingredientsData = [];
        foreach ($mealTypes as $type => $menu) {
            if ($menu) {
                $ingredientsData[$type] = $menu->ingredients->map(function($i) {
                    return [
                        'name' => $i->name,
                        'cal' => floatval($i->kcal),
                        'prot' => floatval($i->protein),
                        'carbs' => floatval($i->carbs),
                        'fats' => floatval($i->fats),
                        'gr_ration' => intval($i->gr_ration)
                    ];
                });
            } else {
                $ingredientsData[$type] = [];
            }
        }
        
        return view('meal-plans.edit', compact('mealPlan', 'mealTypes', 'ingredientsData'));
    }

    public function update(Request $request, MealPlan $mealPlan)
    {
        $mealPlan->meals()->delete();
        
        if ($request->has('meals')) {
            foreach ($request->meals as $mealType => $ingredients) {
                foreach ($ingredients as $data) {
                    if (!empty($data['ingredient_name']) && !empty($data['quantity']) && $data['quantity'] > 0) {
                        Meal::create([
                            'meal_plan_id' => $mealPlan->id,
                            'meal_type' => $mealType,
                            'ingredient_name' => $data['ingredient_name'],
                            'quantity' => $data['quantity'],
                        ]);
                    }
                }
            }
        }

        return redirect()->route('meal-plans.index')->with('success', 'Plan actualizado');
    }

    public function destroy(MealPlan $mealPlan)
    {
        $mealPlan->delete();
        return redirect()->route('meal-plans.index');
    }
}