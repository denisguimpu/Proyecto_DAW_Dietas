<?php

namespace App\Http\Controllers;

use App\Models\FoodGroup;
use App\Models\Ingredient;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('ingredients')->get();

        $menus->each(function (Menu $menu) {
            $totals = $this->calculateMenuNutritionTotals($menu);

            $menu->setAttribute('total_kcal', $totals['kcal']);
            $menu->setAttribute('total_protein', $totals['protein']);
            $menu->setAttribute('total_carbs', $totals['carbs']);
            $menu->setAttribute('total_fats', $totals['fats']);
        });

        $foodGroups = FoodGroup::with('menus.ingredients')->latest()->get();
        $foodGroups->each(function (FoodGroup $group) {
            $groupTotals = [
                'kcal' => 0,
                'protein' => 0,
                'carbs' => 0,
                'fats' => 0,
            ];

            $group->menus->each(function (Menu $menu) use (&$groupTotals) {
                $dietTotals = $this->calculateMenuNutritionTotals($menu);

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

        return view('menus.index', compact('menus', 'foodGroups'));
    }

    public function create()
    {
        $ingredients = Ingredient::all();

        return view('menus.create', compact('ingredients'));
    }

    public function edit($id)
    {
        $menu = Menu::with('ingredients')->findOrFail($id);
        $ingredients = Ingredient::all();

        return view('menus.edit', compact('menu', 'ingredients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'ingredients' => 'nullable|array',
            'ingredients.*' => 'exists:ingredients,id',
        ]);

        $menu = Menu::create($request->only('name', 'description'));

        if ($request->has('ingredients')) {
            $menu->ingredients()->attach($request->input('ingredients', []));
        }

        return redirect()->route('menus.index')->with('success', 'Menú creado con éxito');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'ingredients' => 'nullable|array',
            'ingredients.*' => 'exists:ingredients,id',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update($request->only('name', 'description'));
        $menu->ingredients()->sync($request->input('ingredients', []));

        return redirect()->route('menus.show', $menu->id)->with('success', 'Menú actualizado con éxito');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->ingredients()->detach();
        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menú eliminado correctamente');
    }

    public function show($id)
    {
        $menu = Menu::with('ingredients')->findOrFail($id);

        return view('menus.show', compact('menu'));
    }

    public function storeFoodGroup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'menus' => 'nullable|array',
            'menus.*' => 'exists:menus,id',
        ]);

        $foodGroup = FoodGroup::create([
            'name' => $validated['name'],
        ]);

        $foodGroup->menus()->sync($validated['menus'] ?? []);

        return redirect()->route('menus.index')->with('success', 'Grupo de menús creado con éxito');
    }

    private function calculateMenuNutritionTotals(Menu $menu): array
    {
        return [
            'kcal' => $menu->ingredients->sum(function ($ingredient) {
                $grRation = (float) ($ingredient->gr_ration ?? 0);
                $kcalPer100 = (float) ($ingredient->kcal ?? 0);

                return $kcalPer100 * ($grRation / 100);
            }),
            'protein' => $menu->ingredients->sum(function ($ingredient) {
                $grRation = (float) ($ingredient->gr_ration ?? 0);
                $proteinPer100 = (float) ($ingredient->protein ?? 0);

                return $proteinPer100 * ($grRation / 100);
            }),
            'carbs' => $menu->ingredients->sum(function ($ingredient) {
                $grRation = (float) ($ingredient->gr_ration ?? 0);
                $carbsPer100 = (float) ($ingredient->carbs ?? 0);

                return $carbsPer100 * ($grRation / 100);
            }),
            'fats' => $menu->ingredients->sum(function ($ingredient) {
                $grRation = (float) ($ingredient->gr_ration ?? 0);
                $fatsPer100 = (float) ($ingredient->fats ?? 0);

                return $fatsPer100 * ($grRation / 100);
            }),
        ];
    }
}
