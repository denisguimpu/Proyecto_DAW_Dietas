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
            'calories' => 'required|numeric',
        ]);

        Ingredient::create($request->all());
        return redirect()->route('ingredients.index');
    }
}