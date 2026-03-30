<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    // show all ingredients
    public function index()
    {
        $ingredients = Ingredient::all();
        return view('ingredients.index', compact('ingredients'));
    }

    // save new ingredient
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'kcal' => 'required|numeric',
        ], [], [
            'kcal' => 'Kcal',
        ]);

        Ingredient::create($request->all());
        return redirect()->route('ingredients.index');
    }

    // show edit form
    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', compact('ingredient'));
    }

    // update ingredient
    public function update(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            'name' => 'required',
            'kcal' => 'required|numeric',
        ], [], [
            'kcal' => 'Kcal',
        ]);

        $ingredient->update($request->all());
        return redirect()->route('ingredients.index');
    }

    // delete ingredient
    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->route('ingredients.index');
    }
}
