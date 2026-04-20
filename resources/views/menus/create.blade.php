<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-8">
                <form action="{{ route('menus.store') }}" method="POST">
                    @csrf

                    <div class="mb-6 flex items-center justify-between border-b border-gray-200 pb-4">
                        <h2 class="text-2xl font-bold text-gray-800">Nuevo menú</h2>
                        <button type="submit" class="appearance-none bg-gray-900 hover:bg-black text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-200" style="appearance: none; -webkit-appearance: none; background-color: #111827; border: none;">
                            Guardar menú
                        </button>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nombre del menú:</label>
                        <input type="text" name="name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500">
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                        <textarea name="description" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4">Datos para calcular objetivo</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Peso (kg)</label>
                                <input type="number" step="0.1" name="weight" id="menu_weight" class="w-full border rounded px-2 py-1 text-sm" placeholder="70">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Altura (cm)</label>
                                <input type="number" step="0.1" name="height" id="menu_height" class="w-full border rounded px-2 py-1 text-sm" placeholder="175">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Edad</label>
                                <input type="number" name="age" id="menu_age" class="w-full border rounded px-2 py-1 text-sm" placeholder="30">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Género</label>
                                <select name="gender" id="menu_gender" class="w-full border rounded px-2 py-1 text-sm">
                                    <option value="">Seleccionar</option>
                                    <option value="male">Masculino</option>
                                    <option value="female">Femenino</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Nivel de actividad</label>
                                <select name="activity_level" id="menu_activity" class="w-full border rounded px-2 py-1 text-sm">
                                    <option value="">Seleccionar</option>
                                    <option value="1.2">Sedentario (sin ejercicio)</option>
                                    <option value="1.375">Ligero (1-3 días/semana)</option>
                                    <option value="1.55">Moderado (3-5 días/semana)</option>
                                    <option value="1.725">Activo (6-7 días/semana)</option>
                                    <option value="1.9">Muy activo (ejercicio intenso)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Objetivo</label>
                                <select name="goal" id="menu_goal" class="w-full border rounded px-2 py-1 text-sm">
                                    <option value="">Seleccionar</option>
                                    <option value="deficit">Déficit (-500 kcal) → Perder peso</option>
                                    <option value="maintenance">Mantenimiento → Mantener peso</option>
                                    <option value="volume">Volumen (+500 kcal) → Ganar músculo</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="button" onclick="calculateTarget()" class="w-full bg-blue-600 text-white py-1 px-3 rounded text-sm hover:bg-blue-700">
                                    Calcular Objetivo
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="target_result" class="hidden mb-6 p-4 bg-green-50 rounded-lg border border-green-200">
                        <h3 class="text-lg font-semibold text-green-900 mb-2">Tu Objetivo Diario</h3>
                        <div class="grid grid-cols-4 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600" id="target_kcal">-</div>
                                <div class="text-xs text-gray-600">Kcal</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-red-500" id="target_protein">-</div>
                                <div class="text-xs text-gray-600">Proteína (30%)</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-yellow-500" id="target_carbs">-</div>
                                <div class="text-xs text-gray-600">Carbs (40%)</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-500" id="target_fats">-</div>
                                <div class="text-xs text-gray-600">Grasas (30%)</div>
                            </div>
                        </div>
                        <input type="hidden" name="target_calories" id="input_target_calories">
                        <input type="hidden" name="target_protein" id="input_target_protein">
                        <input type="hidden" name="target_carbs" id="input_target_carbs">
                        <input type="hidden" name="target_fats" id="input_target_fats">
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
                                    @php
                                        $selectedIngredientIds = collect(old('ingredients', []))
                                            ->map(fn ($value) => (string) $value)
                                            ->all();
                                    @endphp
                                    @forelse($ingredients as $ingredient)
                                        <tr data-ingredient-row="true" data-ingredient-name="{{ strtolower($ingredient->name) }}">
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <input
                                                    type="checkbox"
                                                    name="ingredients[]"
                                                    value="{{ $ingredient->name }}"
                                                    data-id="{{ $ingredient->name }}"
                                                    data-name="{{ $ingredient->name }}"
                                                    data-gr-ration="{{ $ingredient->gr_ration }}"
                                                    data-kcal="{{ $ingredient->kcal }}"
                                                    data-protein="{{ $ingredient->protein }}"
                                                    data-carbs="{{ $ingredient->carbs }}"
                                                    data-fats="{{ $ingredient->fats }}"
                                                    @checked(in_array((string) $ingredient->name, $selectedIngredientIds, true))
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
                                    data-ingredient-id="${checkbox.dataset.id || ''}"
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

                const ingredientId = target.dataset.ingredientId || '';
                const linkedCheckbox = Array.from(checkboxes).find((checkbox) => checkbox.dataset.id === ingredientId);

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

        function calculateTarget() {
            const weight = parseFloat(document.getElementById('menu_weight').value);
            const height = parseFloat(document.getElementById('menu_height').value);
            const age = parseInt(document.getElementById('menu_age').value);
            const gender = document.getElementById('menu_gender').value;
            const activity = parseFloat(document.getElementById('menu_activity').value);
            const goal = document.getElementById('menu_goal').value;

            if (!weight || !height || !age || !gender || !activity || !goal) {
                alert('Por favor, completa todos los campos');
                return;
            }

            // Calcular TMB (Metabolismo Basal)
            let tmb;
            if (gender === 'male') {
                tmb = 10 * weight + 6.25 * height - 5 * age + 5;
            } else {
                tmb = 10 * weight + 6.25 * height - 5 * age - 161;
            }

            // Gasto energético total
            let maintenance = tmb * activity;
            
            // Ajuste por objetivo
            let targetKcal;
            if (goal === 'deficit') {
                targetKcal = maintenance - 500;
            } else if (goal === 'volume') {
                targetKcal = maintenance + 500;
            } else {
                targetKcal = maintenance;
            }

            // Distribución de macros que cuadra con las kcal:
            // Proteína: 2g por kg (aprox 25% kcal)
            // Grasas: 0.8g por kg (aprox 20% kcal)  
            // Carbohidratos: resto de kcal (aprox 55% kcal)
            
            const protein = Math.round(weight * 2);
            const fats = Math.round(weight * 0.8);
            
            // Calorías que quedan para carbs
            const proteinKcal = protein * 4;
            const fatsKcal = fats * 9;
            const remainingKcal = targetKcal - proteinKcal - fatsKcal;
            const carbs = Math.round(remainingKcal / 4);

            document.getElementById('target_kcal').textContent = Math.round(targetKcal);
            document.getElementById('target_protein').textContent = protein + 'g';
            document.getElementById('target_carbs').textContent = carbs + 'g';
            document.getElementById('target_fats').textContent = fats + 'g';

            document.getElementById('input_target_calories').value = Math.round(targetKcal);
            document.getElementById('input_target_protein').value = protein;
            document.getElementById('input_target_carbs').value = carbs;
            document.getElementById('input_target_fats').value = fats;

            document.getElementById('target_result').classList.remove('hidden');
        }
    </script>
</x-app-layout>
