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
    // 1. Validar
    $request->validate([
        'name' => 'required|max:255',
        'description' => 'nullable'
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

}