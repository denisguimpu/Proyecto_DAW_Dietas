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
        $mealPlans = MealPlan::with(['diet', 'meals.ingredient'])->get();
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
        $diets = Menu::with('ingredients')->get();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $daysSpanish = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];
        $selectedDay = $request->get('day');
        
        return view('meal-plans.create', compact('diets', 'days', 'daysSpanish', 'selectedDay'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'diet_id' => 'required|exists:menus,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'
        ]);

        $mealPlan = MealPlan::updateOrCreate(
            ['day_of_week' => $request->day_of_week],
            ['diet_id' => $request->diet_id]
        );

        return redirect()->route('meal-plans.edit', $mealPlan->id);
    }

    public function edit(MealPlan $mealPlan)
    {
        $mealPlan->load(['diet.ingredients', 'meals.ingredient']);
        $mealTypes = ['desayuno', 'comida', 'merienda', 'cena'];
        
        $ingredientsData = $mealPlan->diet->ingredients->map(function($i) {
            return [
                'name' => $i->name,
                'cal' => floatval($i->kcal),
                'prot' => floatval($i->protein),
                'carbs' => floatval($i->carbs),
                'fats' => floatval($i->fats)
            ];
        });
        
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
                            'diet_id' => $mealPlan->diet_id,
                            'meal_type' => $mealType,
                            'ingredient_name' => $data['ingredient_name'],
                            'quantity' => $data['quantity'],
                        ]);
                    }
                }
            }
        }

        return redirect()->route('meal-plans.index')->with('success', 'Menú actualizado');
    }

    public function destroy(MealPlan $mealPlan)
    {
        $mealPlan->delete();
        return redirect()->route('meal-plans.index');
    }
}