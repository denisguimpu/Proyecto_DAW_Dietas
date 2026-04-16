<?php

namespace App\Http\Controllers;

use App\Models\Diet;
use App\Models\Ingredient;
use App\Models\ShoppingList;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    public function index()
    {
        $shoppingLists = ShoppingList::with('ingredients')->get();
        return view('shopping-lists.index', compact('shoppingLists'));
    }

    public function create()
    {
        $diets = Diet::with('ingredients')->get();
        return view('shopping-lists.create', compact('diets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'diet_ids' => 'required|array|min:1',
            'diet_ids.*' => 'exists:diets,id'
        ]);

        $diets = Diet::with('ingredients')->whereIn('id', $request->diet_ids)->get();

        $allIngredients = $diets->flatMap->ingredients;
        $consolidated = $allIngredients->unique('id')->map(function ($ingredient) use ($allIngredients) {
            $quantity = $allIngredients->where('id', $ingredient->id)->count();
            return [
                'id' => $ingredient->id,
                'quantity' => $quantity,
                'name' => $ingredient->name,
                'calories' => $ingredient->calories,
                'protein' => $ingredient->protein,
                'fats' => $ingredient->fats,
                'carbs' => $ingredient->carbs,
                'unit' => $ingredient->unit ?? 'ud'
            ];
        })->values();

        $shoppingList = ShoppingList::create(['name' => $request->name]);

        foreach ($consolidated as $item) {
            $shoppingList->ingredients()->attach($item['id'], ['quantity' => $item['quantity']]);
        }

        return redirect()->route('shopping-lists.show', $shoppingList);
    }

    public function show(ShoppingList $shoppingList)
    {
        $shoppingList->load('ingredients');
        return view('shopping-lists.show', compact('shoppingList'));
    }

    public function destroy(ShoppingList $shoppingList)
    {
        $shoppingList->delete();
        return redirect()->route('shopping-lists.index');
    }
}
