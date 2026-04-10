<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-2xl p-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between mb-2">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $diet->name }}</h1>
                        <p class="text-gray-600">{{ $diet->description }}</p>
                    </div>

                        <a href="{{ route('diets.edit', $diet->id) }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700">
                        Editar menú
                    </a>
                </div>

                <div class="mb-6 border-t pt-6">
                    <p class="text-sm font-semibold text-gray-700">Resumen de ingredientes</p>
                    <p class="text-sm text-gray-500">Desde aquí puedes revisar la composición actual o pasar al editor para añadir o quitar alimentos.</p>
                </div>

                <div class="rounded-xl border border-indigo-200 bg-indigo-50 p-4">
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-indigo-900">Ingredientes marcados</h3>
                    <p class="mt-1 text-xs text-indigo-800">Vista de solo lectura de los valores nutricionales por ración.</p>

                    @php
                        $totalGrRation = 0;
                        $totalKcal = 0;
                        $totalProtein = 0;
                        $totalCarbs = 0;
                        $totalFats = 0;
                    @endphp

                    <div class="mt-3 overflow-x-auto">
                        <table class="w-full bg-white rounded-lg shadow text-sm">
                            <thead class="bg-gray-100 text-gray-800">
                                <tr>
                                    <th class="p-4 text-left font-bold">Ingrediente</th>
                                    <th class="p-4 text-left font-bold bg-gray-100 text-gray-700">Racion (g)</th>
                                    <th class="p-4 text-left font-bold bg-orange-100 text-orange-700">Kcal racion</th>
                                    <th class="p-4 text-left font-bold bg-blue-100 text-blue-700">Prot racion</th>
                                    <th class="p-4 text-left font-bold bg-green-100 text-green-700">Carb racion</th>
                                    <th class="p-4 text-left font-bold bg-yellow-100 text-yellow-700">Grasa racion</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($diet->ingredients as $ingredient)
                                    @php
                                        $grRation = (float) ($ingredient->gr_ration ?? 0);
                                        $ratio = $grRation / 100;
                                        $kcal = (float) ($ingredient->kcal ?? 0) * $ratio;
                                        $protein = (float) ($ingredient->protein ?? 0) * $ratio;
                                        $carbs = (float) ($ingredient->carbs ?? 0) * $ratio;
                                        $fats = (float) ($ingredient->fats ?? 0) * $ratio;

                                        $totalGrRation += $grRation;
                                        $totalKcal += $kcal;
                                        $totalProtein += $protein;
                                        $totalCarbs += $carbs;
                                        $totalFats += $fats;
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $ingredient->name }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-bold">{{ number_format($grRation, 0) }} g</span>
                                        </td>
                                        <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">{{ number_format($kcal, 2) }}</span></td>
                                        <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">{{ number_format($protein, 2) }}</span></td>
                                        <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">{{ number_format($carbs, 2) }}</span></td>
                                        <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">{{ number_format($fats, 2) }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-sm text-gray-500">Esta dieta no tiene ingredientes asociados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 border-t border-indigo-200 pt-3">
                        <p class="text-xs font-extrabold uppercase tracking-wider text-indigo-900">Suma total (según ración)</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="px-2 py-0.5 rounded-md bg-gray-100 text-gray-700 text-[10px] font-bold uppercase tracking-wider">Racion (g): {{ number_format($totalGrRation, 0) }}</span>
                            <span class="px-2 py-0.5 rounded-md bg-orange-100 text-orange-700 text-[10px] font-bold uppercase tracking-wider">Kcal: {{ number_format($totalKcal, 2) }}</span>
                            <span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-700 text-[10px] font-bold uppercase tracking-wider">Prot: {{ number_format($totalProtein, 2) }}</span>
                            <span class="px-2 py-0.5 rounded-md bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider">Carb: {{ number_format($totalCarbs, 2) }}</span>
                            <span class="px-2 py-0.5 rounded-md bg-yellow-100 text-yellow-700 text-[10px] font-bold uppercase tracking-wider">Grasa: {{ number_format($totalFats, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('diets.index') }}" class="text-indigo-600 hover:underline font-bold">← Volver al listado</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
