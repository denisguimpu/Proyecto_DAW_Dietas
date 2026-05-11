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

                        if($plan) {
                            $menus = array_filter([$plan->breakfastMenu, $plan->lunchMenu, $plan->snackMenu, $plan->dinnerMenu]);
                            $hasAnyMenu = count($menus) > 0;
                            foreach($menus as $menu) {
                                $targetCalories += $menu->target_calories ?? 0;
                                $targetProtein += $menu->target_protein ?? 0;
                                $targetCarbs += $menu->target_carbs ?? 0;
                                $targetFats += $menu->target_fats ?? 0;
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
                            <div class="grid grid-cols-4 gap-2 mb-4 text-xs text-gray-500 bg-gray-50 p-2 rounded">
                                <div class="text-center">Kcal: {{ round($totalCal) }} / {{ round($targetCalories) }}</div>
                                <div class="text-center">P: {{ round($totalProtein) }}g / {{ round($targetProtein) }}g</div>
                                <div class="text-center">C: {{ round($totalCarbs) }}g / {{ round($targetCarbs) }}g</div>
                                <div class="text-center">G: {{ round($totalFats) }}g / {{ round($targetFats) }}g</div>
                            </div>
                        </div>
                        @endif
                        
                        @if($plan && $plan->meals->count() > 0)
                        <div class="px-6 py-4">
                            @php
                                $mealsByType = $plan->meals->groupBy('meal_type');
                            @endphp
                            <div class="grid grid-cols-4 gap-4">
                                @foreach(['desayuno', 'comida', 'merienda', 'cena'] as $mealType)
                                <div class="bg-white border rounded-lg p-3">
                                    <h4 class="font-medium text-gray-700 text-sm mb-2 capitalize">{{ $mealType }}</h4>
                                    @if(isset($mealsByType[$mealType]))
                                        @foreach($mealsByType[$mealType] as $meal)
                                        <div class="text-xs flex justify-between py-1">
                                            <span>{{ $meal->ingredient_name }}</span>
                                            <span class="text-gray-500">{{ $meal->quantity }}g</span>
                                        </div>
                                        @endforeach
                                        @php
                                            $mealCal = $mealsByType[$mealType]->sum(fn($m) => $m->quantity * ($m->ingredient ? $m->ingredient->kcal : 0) / 100);
                                        @endphp
                                        <div class="text-xs font-bold text-blue-600 mt-2 pt-2 border-t">
                                            {{ round($mealCal) }} kcal
                                        </div>
                                    @else
                                        <p class="text-xs text-gray-400">Sin ingredients</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @elseif($hasAnyMenu)
                        <div class="px-6 py-4 text-center text-gray-500 text-sm">
                            <p>Menús asignados pero sin ajustar cantidades. 
                            <a href="{{ route('meal-plans.edit', $plan->id) }}" class="text-blue-600 hover:underline">Añade los ingredientes</a></p>
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