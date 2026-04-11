<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'name' => 'required|unique:ingredients,name,' . $ingredient->name . ',name',
            'kcal' => 'required|numeric',
        ], [], [
            'kcal' => 'Kcal',
        ]);

        DB::transaction(function () use ($request, $ingredient) {
            $oldName = $ingredient->getOriginal('name');
            $newName = $request->input('name');
            $payload = $request->only(['name', 'gr_ration', 'kcal', 'protein', 'fats', 'carbs']);

            if ($oldName !== $newName) {
                DB::table('ingredients')->insert($payload);

                DB::table('menu_ingredient')
                    ->where('ingredient_name', $oldName)
                    ->update(['ingredient_name' => $newName]);

                DB::table('ingredients')
                    ->where('name', $oldName)
                    ->delete();

                return;
            }

            $ingredient->update($payload);
        });

        return redirect()->route('ingredients.index');
    }

    // delete ingredient
    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->route('ingredients.index');
    }
}
