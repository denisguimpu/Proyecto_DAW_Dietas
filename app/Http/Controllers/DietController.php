<?php

namespace App\Http\Controllers;

use App\Models\Diet;
use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\FoodGroup;

class DietController extends Controller
{
    public function index()
    {
        // Traemos todas las dietas con sus ingredientes para poder calcular sus totales nutricionales
        $diets = Diet::with('ingredients')->get();

        $diets->each(function (Diet $diet) {
            $totals = $this->calculateDietNutritionTotals($diet);

            $diet->setAttribute('total_kcal', $totals['kcal']);
            $diet->setAttribute('total_protein', $totals['protein']);
            $diet->setAttribute('total_carbs', $totals['carbs']);
            $diet->setAttribute('total_fats', $totals['fats']);
        });

        $foodGroups = FoodGroup::with('diets.ingredients')->latest()->get();
        $foodGroups->each(function (FoodGroup $group) {
            $groupTotals = [
                'kcal' => 0,
                'protein' => 0,
                'carbs' => 0,
                'fats' => 0,
            ];

            $group->diets->each(function (Diet $diet) use (&$groupTotals) {
                $dietTotals = $this->calculateDietNutritionTotals($diet);

                $groupTotals['kcal'] += $dietTotals['kcal'];
                $groupTotals['protein'] += $dietTotals['protein'];
                $groupTotals['carbs'] += $dietTotals['carbs'];
                $groupTotals['fats'] += $dietTotals['fats'];
            });

            $group->setAttribute('total_kcal', $groupTotals['kcal']);
            $group->setAttribute('total_protein', $groupTotals['protein']);
            $group->setAttribute('total_carbs', $groupTotals['carbs']);
            $group->setAttribute('total_fats', $groupTotals['fats']);
        });

        // Cargamos la vista pasándole la lista de dietas
        return view('diets.index', compact('diets', 'foodGroups'));
    }

    public function create()
{
    // Obtenemos todos los ingredientes para mostrarlos en el formulario
    $ingredients = Ingredient::all();
    return view('diets.create', compact('ingredients'));
}
    public function edit($id)
    {
        $diet = Diet::with('ingredients')->findOrFail($id);
        $ingredients = Ingredient::all();

        return view('diets.edit', compact('diet', 'ingredients'));
    }

public function store(Request $request)
{
    // 1. Validar
    $request->validate([
        'name' => 'required|max:255',
        'description' => 'nullable',
        'ingredients' => 'nullable|array',
        'ingredients.*' => 'exists:ingredients,name',
    ]);

    // 2. Crear la dieta
    $diet = Diet::create($request->only('name', 'description'));

    // 3. ASOCIAR LOS INGREDIENTES (La magia de la tabla pivote)
    // $request->ingredients es un array con los IDs de los checkboxes marcados
    if ($request->has('ingredients')) {
        $diet->ingredients()->attach($request->ingredients);
    }

    return redirect()->route('diets.index')->with('success', 'Dieta creada con éxito');
}
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'ingredients' => 'nullable|array',
            'ingredients.*' => 'exists:ingredients,name',
        ]);

        $diet = Diet::findOrFail($id);
        $diet->update($request->only('name', 'description'));
        $diet->ingredients()->sync($request->input('ingredients', []));

        return redirect()->route('diets.show', $diet->id)->with('success', 'Dieta actualizada con éxito');
    }

public function destroy($id)
{
    $diet = \App\Models\Diet::findOrFail($id);

    // Primero borramos la conexión en la tabla pivote para no dejar datos huérfanos
    $diet->ingredients()->detach();

    // Luego borramos la dieta
    $diet->delete();

    return redirect()->route('diets.index')->with('success', 'Dieta eliminada correctamente');
}

public function show($id)
{
    // Buscamos la dieta por su ID y cargamos sus ingredientes relacionados
    $diet = Diet::with('ingredients')->findOrFail($id);

    // Retornamos la vista enviándole la dieta
    return view('diets.show', compact('diet'));
}

public function storeFoodGroup(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'diets' => 'nullable|array',
        'diets.*' => 'exists:diets,id',
    ]);

    $foodGroup = FoodGroup::create([
        'name' => $validated['name'],
    ]);

    $foodGroup->diets()->sync($validated['diets'] ?? []);

    return redirect()->route('diets.index')->with('success', 'Grupo de alimentos creado con éxito');
}

private function calculateDietNutritionTotals(Diet $diet): array
{
    return [
        'kcal' => $diet->ingredients->sum(function ($ingredient) {
            $grRation = (float) ($ingredient->gr_ration ?? 0);
            $kcalPer100 = (float) ($ingredient->kcal ?? 0);

            return $kcalPer100 * ($grRation / 100);
        }),
        'protein' => $diet->ingredients->sum(function ($ingredient) {
            $grRation = (float) ($ingredient->gr_ration ?? 0);
            $proteinPer100 = (float) ($ingredient->protein ?? 0);

            return $proteinPer100 * ($grRation / 100);
        }),
        'carbs' => $diet->ingredients->sum(function ($ingredient) {
            $grRation = (float) ($ingredient->gr_ration ?? 0);
            $carbsPer100 = (float) ($ingredient->carbs ?? 0);

            return $carbsPer100 * ($grRation / 100);
        }),
        'fats' => $diet->ingredients->sum(function ($ingredient) {
            $grRation = (float) ($ingredient->gr_ration ?? 0);
            $fatsPer100 = (float) ($ingredient->fats ?? 0);

            return $fatsPer100 * ($grRation / 100);
        }),
    ];
}

}
