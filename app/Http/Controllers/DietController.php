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
        // Traemos todas las dietas con sus ingredientes para poder calcular kcal totales
        $diets = Diet::with('ingredients')->get();

        $diets->each(function (Diet $diet) {
            $diet->setAttribute('total_kcal', $this->calculateDietTotalKcal($diet));
        });

        $foodGroups = FoodGroup::with('diets.ingredients')->latest()->get();
        $foodGroups->each(function (FoodGroup $group) {
            $group->setAttribute('total_kcal', $group->diets->sum(function (Diet $diet) {
                return $this->calculateDietTotalKcal($diet);
            }));
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

private function calculateDietTotalKcal(Diet $diet): float
{
    return $diet->ingredients->sum(function ($ingredient) {
        $grRation = (float) ($ingredient->gr_ration ?? 0);
        $kcalPer100 = (float) ($ingredient->kcal ?? 0);

        return $kcalPer100 * ($grRation / 100);
    });
}

}
