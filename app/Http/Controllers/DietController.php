<?php

namespace App\Http\Controllers;

use App\Models\Diet; 
use Illuminate\Http\Request;
use App\Models\Ingredient;

class DietController extends Controller
{
    public function index()
    {
        // Traemos todas las dietas de la base de datos
        $diets = Diet::all();
        
        // Cargamos la vista pasándole la lista de dietas
        return view('diets.index', compact('diets'));
    }

    public function create()
{
    // Obtenemos todos los ingredientes para mostrarlos en el formulario
    $ingredients = Ingredient::all();
    return view('diets.create', compact('ingredients'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'description' => 'nullable'
    ]);

    $diet = Diet::create($request->only([
        'name', 
        'description', 
        'weight', 
        'height', 
        'age', 
        'gender', 
        'activity_level', 
        'goal',
        'target_calories',
        'target_protein',
        'target_carbs',
        'target_fats'
    ]));

    if ($request->has('ingredients')) {
        $diet->ingredients()->attach($request->ingredients);
    }

    return redirect()->route('diets.index')->with('success', 'Dieta creada con éxito');
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
    $diet = Diet::with('ingredients')->findOrFail($id);
    return view('diets.show', compact('diet'));
}

public function edit($id)
{
    $diet = Diet::with('ingredients')->findOrFail($id);
    $ingredients = Ingredient::all();
    return view('diets.edit', compact('diet', 'ingredients'));
}

public function update(Request $request, $id)
{
    $diet = Diet::findOrFail($id);

    $request->validate([
        'name' => 'required|max:255',
        'description' => 'nullable'
    ]);

    $diet->update($request->only([
        'name', 
        'description', 
        'weight', 
        'height', 
        'age', 
        'gender', 
        'activity_level', 
        'goal',
        'target_calories',
        'target_protein',
        'target_carbs',
        'target_fats'
    ]));

    $diet->ingredients()->sync($request->ingredients ?? []);

    return redirect()->route('diets.show', $diet->id)->with('success', 'Dieta actualizada');
}

}