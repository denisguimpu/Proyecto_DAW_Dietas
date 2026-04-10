<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Editar menú</h2>

                <form action="{{ route('diets.update', $diet->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div id="selected-ingredients-summary" class="mb-6 hidden">
                        <div class="rounded-xl border border-indigo-200 bg-indigo-50 p-4">
                            <h3 class="text-sm font-extrabold uppercase tracking-wider text-indigo-900">Ingredientes marcados</h3>
                            <p class="mt-1 text-xs text-indigo-800">Puedes editar la racion (g) en esta franja para ajustar los calculos.</p>

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
                                    <tbody id="selected-ingredients-list" class="divide-y divide-gray-200 bg-white"></tbody>
                                </table>
                            </div>

                            <div class="mt-4 border-t border-indigo-200 pt-3">
                                <p class="text-xs font-extrabold uppercase tracking-wider text-indigo-900">Suma total (segun racion)</p>
                                <div class="mt-2 flex flex-wrap gap-2" id="selected-ingredients-totals">
                                    <span class="px-2 py-0.5 rounded-md bg-gray-100 text-gray-700 text-[10px] font-bold uppercase tracking-wider">Racion (g): <span data-total="gr_ration">0</span></span>
                                    <span class="px-2 py-0.5 rounded-md bg-orange-100 text-orange-700 text-[10px] font-bold uppercase tracking-wider">Kcal: <span data-total="kcal">0</span></span>
                                    <span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-700 text-[10px] font-bold uppercase tracking-wider">Prot: <span data-total="protein">0</span></span>
                                    <span class="px-2 py-0.5 rounded-md bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider">Carb: <span data-total="carbs">0</span></span>
                                    <span class="px-2 py-0.5 rounded-md bg-yellow-100 text-yellow-700 text-[10px] font-bold uppercase tracking-wider">Grasa: <span data-total="fats">0</span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nombre del menú:</label>
                        <input type="text" name="name" value="{{ old('name', $diet->name) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500">
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                        <textarea name="description" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500">{{ old('description', $diet->description) }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-4">Ingredientes disponibles:</label>

                        <div class="mb-4">
                            <label for="ingredients-search" class="block text-sm font-semibold text-gray-700 mb-2">Buscador</label>
                            <input
                                id="ingredients-search"
                                type="text"
                                placeholder="Escribe para filtrar alimentos..."
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500"
                            >
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full bg-white rounded-lg shadow">
                                <thead class="bg-gray-100 text-gray-800">
                                    <tr>
                                        <th class="p-4 text-left font-bold">Seleccionar</th>
                                        <th class="p-4 text-left font-bold">Ingrediente</th>
                                        <th class="p-4 text-left font-bold bg-gray-100 text-gray-700">Racion predefinida (g)</th>
                                        <th class="p-4 text-left font-bold bg-orange-100 text-orange-700">Kcal/100g</th>
                                        <th class="p-4 text-left font-bold bg-blue-100 text-blue-700">Proteinas/100g</th>
                                        <th class="p-4 text-left font-bold bg-green-100 text-green-700">Carbohidratos/100g</th>
                                        <th class="p-4 text-left font-bold bg-yellow-100 text-yellow-700">Grasas/100g</th>
                                    </tr>
                                </thead>
                                <tbody id="ingredients-table-body" class="divide-y divide-gray-200 bg-white">
                                    @forelse($ingredients as $ingredient)
                                        <tr data-ingredient-row="true" data-ingredient-name="{{ strtolower($ingredient->name) }}">
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <input
                                                    type="checkbox"
                                                    name="ingredients[]"
                                                    value="{{ $ingredient->name }}"
                                                    data-name="{{ $ingredient->name }}"
                                                    data-gr-ration="{{ $ingredient->gr_ration }}"
                                                    data-kcal="{{ $ingredient->kcal }}"
                                                    data-protein="{{ $ingredient->protein }}"
                                                    data-carbs="{{ $ingredient->carbs }}"
                                                    data-fats="{{ $ingredient->fats }}"
                                                    @checked(in_array($ingredient->name, old('ingredients', $diet->ingredients->pluck('name')->toArray()), true))
                                                    class="ingredient-checkbox h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                >
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $ingredient->name }}</td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-bold">{{ $ingredient->gr_ration }} g</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">{{ $ingredient->kcal }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">{{ $ingredient->protein }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">{{ $ingredient->carbs }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">{{ $ingredient->fats }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr data-empty-ingredients-row="true">
                                            <td colspan="7" class="px-6 py-4 text-sm text-gray-500">No hay ingredientes creados.</td>
                                        </tr>
                                    @endforelse
                                    <tr id="ingredients-no-results" class="hidden">
                                        <td colspan="7" class="px-6 py-4 text-sm text-gray-500">No se han encontrado alimentos con ese texto.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 gap-3">
                        <a href="{{ route('diets.show', $diet->id) }}" class="appearance-none bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-3 px-8 rounded-lg shadow-sm transition duration-200">Cancelar</a>
                        <button type="submit" class="appearance-none bg-gray-900 hover:bg-black text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-200" style="appearance: none; -webkit-appearance: none; background-color: #111827; border: none;">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.ingredient-checkbox');
            const summary = document.getElementById('selected-ingredients-summary');
            const selectedList = document.getElementById('selected-ingredients-list');
            const searchInput = document.getElementById('ingredients-search');
            const ingredientRows = document.querySelectorAll('[data-ingredient-row="true"]');
            const noResultsRow = document.getElementById('ingredients-no-results');

            const formatNumber = (value) => {
                const numericValue = Number(value);
                if (!Number.isFinite(numericValue)) {
                    return '0';
                }

                return Number.isInteger(numericValue)
                    ? String(numericValue)
                    : numericValue.toFixed(2).replace(/\.00$/, '');
            };

            const updateTotals = () => {
                const selected = Array.from(checkboxes).filter((checkbox) => checkbox.checked);

                let totalGrRation = 0;
                let totalKcal = 0;
                let totalProtein = 0;
                let totalCarbs = 0;
                let totalFats = 0;

                selected.forEach((checkbox) => {
                    const grRation = Number(checkbox.dataset.grRation || 0);
                    const kcalPer100 = Number(checkbox.dataset.kcal || 0);
                    const proteinPer100 = Number(checkbox.dataset.protein || 0);
                    const carbsPer100 = Number(checkbox.dataset.carbs || 0);
                    const fatsPer100 = Number(checkbox.dataset.fats || 0);

                    const ratio = grRation / 100;

                    totalGrRation += grRation;
                    totalKcal += kcalPer100 * ratio;
                    totalProtein += proteinPer100 * ratio;
                    totalCarbs += carbsPer100 * ratio;
                    totalFats += fatsPer100 * ratio;
                });

                document.querySelector('[data-total="gr_ration"]').textContent = formatNumber(totalGrRation);
                document.querySelector('[data-total="kcal"]').textContent = formatNumber(totalKcal);
                document.querySelector('[data-total="protein"]').textContent = formatNumber(totalProtein);
                document.querySelector('[data-total="carbs"]').textContent = formatNumber(totalCarbs);
                document.querySelector('[data-total="fats"]').textContent = formatNumber(totalFats);
            };

            const updateIngredientFilter = () => {
                const query = (searchInput?.value || '').toLowerCase().trim();
                let visibleRows = 0;

                ingredientRows.forEach((row) => {
                    const ingredientName = row.dataset.ingredientName || '';
                    const matches = query === '' || ingredientName.includes(query);

                    row.classList.toggle('hidden', !matches);

                    if (matches) {
                        visibleRows += 1;
                    }
                });

                if (noResultsRow) {
                    noResultsRow.classList.toggle('hidden', visibleRows !== 0);
                }
            };

            const renderSummary = () => {
                const selected = Array.from(checkboxes).filter((checkbox) => checkbox.checked);

                if (selected.length === 0) {
                    summary.classList.add('hidden');
                    selectedList.innerHTML = '';
                    document.querySelector('[data-total="gr_ration"]').textContent = '0';
                    document.querySelector('[data-total="kcal"]').textContent = '0';
                    document.querySelector('[data-total="protein"]').textContent = '0';
                    document.querySelector('[data-total="carbs"]').textContent = '0';
                    document.querySelector('[data-total="fats"]').textContent = '0';
                    return;
                }

                summary.classList.remove('hidden');

                selectedList.innerHTML = selected.map((checkbox) => {
                    const grRation = Number(checkbox.dataset.grRation || 0);
                    const kcalPer100 = Number(checkbox.dataset.kcal || 0);
                    const proteinPer100 = Number(checkbox.dataset.protein || 0);
                    const carbsPer100 = Number(checkbox.dataset.carbs || 0);
                    const fatsPer100 = Number(checkbox.dataset.fats || 0);

                    const ratio = grRation / 100;
                    const kcal = kcalPer100 * ratio;
                    const protein = proteinPer100 * ratio;
                    const carbs = carbsPer100 * ratio;
                    const fats = fatsPer100 * ratio;

                    return `
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">${checkbox.dataset.name || ''}</td>
                            <td class="px-6 py-4">
                                <input
                                    type="number"
                                    min="0"
                                    step="0.1"
                                    value="${formatNumber(grRation)}"
                                    data-ration-input="true"
                                    data-ingredient-name="${checkbox.dataset.name || ''}"
                                    class="w-24 border-gray-300 rounded-md text-xs font-bold text-gray-900"
                                >
                            </td>
                            <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold" data-row-field="kcal">${formatNumber(kcal)}</span></td>
                            <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold" data-row-field="protein">${formatNumber(protein)}</span></td>
                            <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold" data-row-field="carbs">${formatNumber(carbs)}</span></td>
                            <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold" data-row-field="fats">${formatNumber(fats)}</span></td>
                        </tr>
                    `;
                }).join('');

                updateTotals();
            };

            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', renderSummary);
            });

            if (searchInput) {
                searchInput.addEventListener('input', updateIngredientFilter);
            }

            selectedList.addEventListener('input', (event) => {
                const target = event.target;
                if (!(target instanceof HTMLInputElement) || target.dataset.rationInput !== 'true') {
                    return;
                }

                const ingredientName = target.dataset.ingredientName || '';
                const linkedCheckbox = Array.from(checkboxes).find((checkbox) => checkbox.dataset.name === ingredientName);

                if (!linkedCheckbox) {
                    return;
                }

                const parsedValue = Number(target.value);
                linkedCheckbox.dataset.grRation = Number.isFinite(parsedValue) && parsedValue >= 0 ? String(parsedValue) : '0';

                const row = target.closest('tr');
                if (!row) {
                    return;
                }

                const grRation = Number(linkedCheckbox.dataset.grRation || 0);
                const ratio = grRation / 100;
                const kcal = Number(linkedCheckbox.dataset.kcal || 0) * ratio;
                const protein = Number(linkedCheckbox.dataset.protein || 0) * ratio;
                const carbs = Number(linkedCheckbox.dataset.carbs || 0) * ratio;
                const fats = Number(linkedCheckbox.dataset.fats || 0) * ratio;

                row.querySelector('[data-row-field="kcal"]').textContent = formatNumber(kcal);
                row.querySelector('[data-row-field="protein"]').textContent = formatNumber(protein);
                row.querySelector('[data-row-field="carbs"]').textContent = formatNumber(carbs);
                row.querySelector('[data-row-field="fats"]').textContent = formatNumber(fats);

                updateTotals();
            });

            updateIngredientFilter();
            renderSummary();
        });
    </script>
</x-app-layout>
