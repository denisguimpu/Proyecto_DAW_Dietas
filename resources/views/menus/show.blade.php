<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-2xl p-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between mb-2">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $menu->name }}</h1>
                        <p class="text-gray-600">{{ $menu->description }}</p>
                    </div>

                        <a href="{{ route('menus.edit', $menu->id) }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700">
                        Editar menú
                    </a>
                </div>

                @if($menu->weight || $menu->height || $menu->age)
                <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Datos personales</h3>
                    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 text-sm">
                        @if($menu->weight)
                        <div>
                            <span class="text-gray-500">Peso:</span>
                            <span class="font-bold ml-1">{{ $menu->weight }} kg</span>
                        </div>
                        @endif
                        @if($menu->height)
                        <div>
                            <span class="text-gray-500">Altura:</span>
                            <span class="font-bold ml-1">{{ $menu->height }} cm</span>
                        </div>
                        @endif
                        @if($menu->age)
                        <div>
                            <span class="text-gray-500">Edad:</span>
                            <span class="font-bold ml-1">{{ $menu->age }} años</span>
                        </div>
                        @endif
                        @if($menu->gender)
                        <div>
                            <span class="text-gray-500">Género:</span>
                            <span class="font-bold ml-1">{{ $menu->gender === 'male' ? 'Masculino' : 'Femenino' }}</span>
                        </div>
                        @endif
                        @if($menu->activity_level)
                        <div>
                            <span class="text-gray-500">Actividad:</span>
                            @php
                            $activityLabels = [
                                1.2 => 'Sedentario (sin ejercicio)',
                                1.375 => 'Ligero (1-3 días/semana)',
                                1.55 => 'Moderado (3-5 días/semana)',
                                1.725 => 'Activo (6-7 días/semana)',
                                1.9 => 'Muy activo (ejercicio intenso)'
                            ];
                            @endphp
                            <span class="font-bold ml-1">{{ $activityLabels[$menu->activity_level] ?? $menu->activity_level }}</span>
                        </div>
                        @endif
                        @if($menu->goal)
                        <div>
                            <span class="text-gray-500">Objetivo:</span>
                            @php
                            $goalLabels = [
                                'deficit' => 'Perder peso',
                                'maintenance' => 'Mantener',
                                'volume' => 'Ganar músculo'
                            ];
                            @endphp
                            <span class="font-bold ml-1">{{ $goalLabels[$menu->goal] ?? $menu->goal }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                @if($menu->target_calories)
                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">Objetivo Diario Calculado</h3>
                    <div class="grid grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ round($menu->target_calories) }}</div>
                            <div class="text-sm text-gray-600">Kcal/día</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-500">{{ round($menu->target_protein) }}g</div>
                            <div class="text-sm text-gray-600">Proteína</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-500">{{ round($menu->target_carbs) }}g</div>
                            <div class="text-sm text-gray-600">Carbohidratos</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-500">{{ round($menu->target_fats) }}g</div>
                            <div class="text-sm text-gray-600">Grasas</div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="mb-6 border-t pt-6">
                    <p class="text-sm font-semibold text-gray-700">Resumen de ingredientes</p>
                    <p class="text-sm text-gray-500">Desde aquí puedes revisar la composición actual o pasar al editor para añadir o quitar alimentos.</p>
                </div>

                <div class="rounded-xl border border-indigo-200 bg-indigo-50 p-4">
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-indigo-900">Ingredientes del menú</h3>

                    <div class="mt-3 overflow-x-auto">
                        <table class="w-full bg-white rounded-lg shadow text-sm">
                            <thead class="bg-gray-100 text-gray-800">
                                <tr>
                                    <th class="p-4 text-left font-bold">Ingrediente</th>
                                    <th class="p-4 text-left font-bold bg-gray-100 text-gray-700">Kcal/100g</th>
                                    <th class="p-4 text-left font-bold bg-blue-100 text-blue-700">Prot</th>
                                    <th class="p-4 text-left font-bold bg-green-100 text-green-700">Carb</th>
                                    <th class="p-4 text-left font-bold bg-yellow-100 text-yellow-700">Grasa</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($menu->ingredients as $ingredient)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $ingredient->name }}</td>
                                        <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">{{ $ingredient->kcal }}</span></td>
                                        <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">{{ $ingredient->protein }}g</span></td>
                                        <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">{{ $ingredient->carbs }}g</span></td>
                                        <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">{{ $ingredient->fats }}g</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-sm text-gray-500">Este menú no tiene ingredientes asociados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('menus.index') }}" class="text-indigo-600 hover:underline font-bold">← Volver al listado</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
