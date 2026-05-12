<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl p-8">
                <div class="flex justify-between items-center mb-8 border-b pb-6">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900">Plan Semanal</h2>
                        <p class="text-gray-500 mt-1">Asigna una dieta a cada día y personalize los menús.</p>
                    </div>
                    <a href="{{ route('meal-plans.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl transition duration-200">
                        + Asignar Dieta
                    </a>
                </div>

                <div class="space-y-6">
                    @foreach($days as $index => $day)
                    @php
                        $plan = $plansByDay[$day] ?? null;
                        $daySpanish = $daysSpanish[$index] ?? $day;
                        $totalCal = 0;
                        $totalProtein = 0;
                        $totalCarbs = 0;
                        $totalFats = 0;
                        $targetCalories = 0;
                        $targetProtein = 0;
                        $targetCarbs = 0;
                        $targetFats = 0;
                        $hasAnyMenu = false;
                        $menuCal = 0;
                        $menuProtein = 0;
                        $menuCarbs = 0;
                        $menuFats = 0;

                        if($plan) {
                            $menus = array_filter([$plan->breakfastMenu, $plan->lunchMenu, $plan->snackMenu, $plan->dinnerMenu]);
                            $hasAnyMenu = count($menus) > 0;
                            foreach($menus as $menu) {
                                $targetCalories += $menu->target_calories ?? 0;
                                $targetProtein += $menu->target_protein ?? 0;
                                $targetCarbs += $menu->target_carbs ?? 0;
                                $targetFats += $menu->target_fats ?? 0;

                                foreach ($menu->ingredients as $ingredient) {
                                    $ratio = (float) ($ingredient->gr_ration ?? 100) / 100;
                                    $menuCal += (float) ($ingredient->kcal ?? 0) * $ratio;
                                    $menuProtein += (float) ($ingredient->protein ?? 0) * $ratio;
                                    $menuCarbs += (float) ($ingredient->carbs ?? 0) * $ratio;
                                    $menuFats += (float) ($ingredient->fats ?? 0) * $ratio;
                                }
                            }

                            foreach($plan->meals as $meal) {
                                if($meal->ingredient) {
                                    $ratio = $meal->quantity / 100;
                                    $totalCal += $meal->ingredient->kcal * $ratio;
                                    $totalProtein += $meal->ingredient->protein * $ratio;
                                    $totalCarbs += $meal->ingredient->carbs * $ratio;
                                    $totalFats += $meal->ingredient->fats * $ratio;
                                }
                            }
                        }
                    @endphp
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900 capitalize">{{ $daySpanish }}</h3>
                            @if($hasAnyMenu)
                                <div class="flex items-center gap-4">
                                    @if($targetCalories > 0)
                                    <span class="text-sm text-gray-600">
                                        <span class="font-medium text-blue-600">{{ round($targetCalories) }}</span> kcal objetivo
                                    </span>
                                    @endif
                                    <a href="{{ route('meal-plans.edit', $plan->id) }}" class="text-blue-600 hover:underline text-sm">Ajustar Cantidades</a>
                                    <form action="{{ route('meal-plans.destroy', $plan->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('¿Eliminar?')">Limpiar</button>
                                    </form>
                                </div>
                            @else
                                <a href="{{ route('meal-plans.create') }}?day={{ $day }}" class="text-blue-600 hover:underline text-sm">Asignar menús</a>
                            @endif
                        </div>

                        @if($hasAnyMenu && $targetCalories > 0)
                        <div class="px-6 py-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
                                <div class="rounded-lg border border-gray-200 bg-white p-3">
                                    <div class="text-xs uppercase tracking-wide text-gray-500">Desayuno</div>
                                    <div class="mt-1 text-sm font-semibold text-gray-900">{{ $plan->breakfastMenu->name ?? 'Sin asignar' }}</div>
                                </div>
                                <div class="rounded-lg border border-gray-200 bg-white p-3">
                                    <div class="text-xs uppercase tracking-wide text-gray-500">Comida</div>
                                    <div class="mt-1 text-sm font-semibold text-gray-900">{{ $plan->lunchMenu->name ?? 'Sin asignar' }}</div>
                                </div>
                                <div class="rounded-lg border border-gray-200 bg-white p-3">
                                    <div class="text-xs uppercase tracking-wide text-gray-500">Merienda</div>
                                    <div class="mt-1 text-sm font-semibold text-gray-900">{{ $plan->snackMenu->name ?? 'Sin asignar' }}</div>
                                </div>
                                <div class="rounded-lg border border-gray-200 bg-white p-3">
                                    <div class="text-xs uppercase tracking-wide text-gray-500">Cena</div>
                                    <div class="mt-1 text-sm font-semibold text-gray-900">{{ $plan->dinnerMenu->name ?? 'Sin asignar' }}</div>
                                </div>
                            </div>

                            <div class="grid grid-cols-4 gap-2 mb-4 text-xs text-gray-500 bg-gray-50 p-2 rounded">
                                <div class="text-center">Kcal: {{ round($totalCal > 0 ? $totalCal : $menuCal) }} / {{ round($targetCalories) }}</div>
                                <div class="text-center">P: {{ round($totalProtein > 0 ? $totalProtein : $menuProtein) }}g / {{ round($targetProtein) }}g</div>
                                <div class="text-center">C: {{ round($totalCarbs > 0 ? $totalCarbs : $menuCarbs) }}g / {{ round($targetCarbs) }}g</div>
                                <div class="text-center">G: {{ round($totalFats > 0 ? $totalFats : $menuFats) }}g / {{ round($targetFats) }}g</div>
                            </div>
                        </div>
                        @endif

                        @if($hasAnyMenu)
                        <div class="px-6 py-4">
                            @php
                                $menusByType = [
                                    'desayuno' => $plan->breakfastMenu,
                                    'comida' => $plan->lunchMenu,
                                    'merienda' => $plan->snackMenu,
                                    'cena' => $plan->dinnerMenu,
                                ];
                            @endphp
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                @foreach($menusByType as $mealType => $menu)
                                <div class="bg-white border rounded-lg p-3">
                                    <h4 class="font-medium text-gray-700 text-sm mb-2 capitalize">{{ $mealType }}</h4>
                                    @if($menu)
                                        @php
                                            $menuTotalCal = 0;
                                            $menuTotalProtein = 0;
                                            $menuTotalCarbs = 0;
                                            $menuTotalFats = 0;
                                        @endphp
                                        @foreach($menu->ingredients as $ingredient)
                                        @php
                                            $ratio = (float) ($ingredient->gr_ration ?? 100) / 100;
                                            $ingredientCal = (float) ($ingredient->kcal ?? 0) * $ratio;
                                            $ingredientProtein = (float) ($ingredient->protein ?? 0) * $ratio;
                                            $ingredientCarbs = (float) ($ingredient->carbs ?? 0) * $ratio;
                                            $ingredientFats = (float) ($ingredient->fats ?? 0) * $ratio;
                                            $menuTotalCal += $ingredientCal;
                                            $menuTotalProtein += $ingredientProtein;
                                            $menuTotalCarbs += $ingredientCarbs;
                                            $menuTotalFats += $ingredientFats;
                                        @endphp
                                        <div class="text-xs flex justify-between py-1">
                                            <span>{{ $ingredient->name }}</span>
                                            <span class="text-gray-500">{{ $ingredient->gr_ration ?? 100 }}g</span>
                                        </div>
                                        <div class="text-[11px] text-gray-400 mb-1">
                                            {{ round($ingredientCal) }} kcal | P {{ round($ingredientProtein) }}g | C {{ round($ingredientCarbs) }}g | G {{ round($ingredientFats) }}g
                                        </div>
                                        @endforeach
                                        <div class="mt-2 pt-2 border-t text-xs font-bold text-blue-600">
                                            Total menú: {{ round($menuTotalCal) }} kcal | P {{ round($menuTotalProtein) }}g | C {{ round($menuTotalCarbs) }}g | G {{ round($menuTotalFats) }}g
                                        </div>
                                    @else
                                        <p class="text-xs text-gray-400">Sin asignar</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-3 text-center text-gray-500 text-sm">
                                Menús asignados pero sin cantidades ajustadas. <a href="{{ route('meal-plans.edit', $plan->id) }}" class="text-blue-600 hover:underline">Ajustar cantidades</a>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                @php
                $totalTarget = 0;
                foreach($plansByDay as $plan) {
                    if($plan) {
                        $menus = array_filter([$plan->breakfastMenu, $plan->lunchMenu, $plan->snackMenu, $plan->dinnerMenu]);
                        foreach($menus as $menu) {
                            $totalTarget += $menu->target_calories ?? 0;
                        }
                    }
                }
                @endphp
            </div>
        </div>
    </div>
</x-app-layout>
