<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Nueva Dieta</h2>

                <form action="{{ route('diets.store') }}" method="POST">
                    @csrf

                    <div id="selected-ingredients-summary" class="mb-6 hidden">
                        <div class="rounded-xl border border-indigo-200 bg-indigo-50 p-4">
                            <h3 class="text-sm font-extrabold uppercase tracking-wider text-indigo-900">Ingredientes marcados</h3>
                            <p class="mt-1 text-xs text-indigo-800">Puedes editar la racion (g) en esta franja para ajustar los calculos.</p>

                            <div id="selected-ingredients-list" class="mt-3 space-y-2"></div>

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
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                        <input type="text" name="name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500">
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                        <textarea name="description" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="mb-6">
    <label class="block text-gray-700 text-sm font-bold mb-4">Ingredientes disponibles:</label>
    <div class="grid grid-cols-1 gap-4">
        @forelse($ingredients as $ingredient)
            <label class="flex items-start p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200 group">
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
                    @checked(in_array($ingredient->name, old('ingredients', []), true))
                    class="ingredient-checkbox mt-1 h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                >

                <div class="ml-4 w-full flex items-start justify-between gap-4">
                    <span class="block text-sm font-bold text-gray-900 group-hover:text-indigo-900">{{ $ingredient->name }}</span>

                    <div class="flex flex-wrap justify-end gap-2">
                        <span class="px-2 py-0.5 rounded-md bg-gray-100 text-gray-700 text-[10px] font-bold uppercase tracking-wider">Racion (g): {{ $ingredient->gr_ration }}</span>
                        <span class="px-2 py-0.5 rounded-md bg-orange-100 text-orange-700 text-[10px] font-bold uppercase tracking-wider">Kcal/100g: {{ $ingredient->kcal }}</span>
                        <span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-700 text-[10px] font-bold uppercase tracking-wider">Prot/100g: {{ $ingredient->protein }}</span>
                        <span class="px-2 py-0.5 rounded-md bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider">Carb/100g: {{ $ingredient->carbs }}</span>
                        <span class="px-2 py-0.5 rounded-md bg-yellow-100 text-yellow-700 text-[10px] font-bold uppercase tracking-wider">Grasa/100g: {{ $ingredient->fats }}</span>
                    </div>
                </div>
            </label>

            @php
                $ratio = ($ingredient->gr_ration ?? 0) / 100;
                $kcalPerRation = ($ingredient->kcal ?? 0) * $ratio;
                $proteinPerRation = ($ingredient->protein ?? 0) * $ratio;
                $carbsPerRation = ($ingredient->carbs ?? 0) * $ratio;
                $fatsPerRation = ($ingredient->fats ?? 0) * $ratio;
            @endphp

            <div class="-mt-2 mb-2 ml-9 flex flex-wrap gap-2">
                <span class="px-2 py-0.5 rounded-md bg-orange-50 text-orange-800 text-[10px] font-bold uppercase tracking-wider">Aporte racion - Kcal: {{ rtrim(rtrim(number_format($kcalPerRation, 2, '.', ''), '0'), '.') }}</span>
                <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-800 text-[10px] font-bold uppercase tracking-wider">Prot: {{ rtrim(rtrim(number_format($proteinPerRation, 2, '.', ''), '0'), '.') }}</span>
                <span class="px-2 py-0.5 rounded-md bg-green-50 text-green-800 text-[10px] font-bold uppercase tracking-wider">Carb: {{ rtrim(rtrim(number_format($carbsPerRation, 2, '.', ''), '0'), '.') }}</span>
                <span class="px-2 py-0.5 rounded-md bg-yellow-50 text-yellow-800 text-[10px] font-bold uppercase tracking-wider">Grasa: {{ rtrim(rtrim(number_format($fatsPerRation, 2, '.', ''), '0'), '.') }}</span>
            </div>
        @empty
            <p class="text-gray-500 text-sm">No hay ingredientes creados.</p>
        @endforelse
    </div>
</div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200">
                        <button type="submit" class="appearance-none bg-gray-900 hover:bg-black text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-200" style="appearance: none; -webkit-appearance: none; background-color: #111827; border: none;">
    Guardar Dieta
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
                        <div class="rounded-lg border border-indigo-200 bg-white p-3">
                            <p class="text-sm font-bold text-gray-900">${checkbox.dataset.name || ''}</p>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <label class="flex items-center gap-2 px-2 py-1 rounded-md bg-gray-100 text-gray-700 text-[10px] font-bold uppercase tracking-wider">
                                    Racion (g):
                                    <input
                                        type="number"
                                        min="0"
                                        step="0.1"
                                        value="${formatNumber(grRation)}"
                                        data-ration-input="true"
                                        data-ingredient-name="${checkbox.dataset.name || ''}"
                                        class="w-20 border-gray-300 rounded-md text-[10px] font-bold text-gray-900"
                                    >
                                </label>
                                <span class="px-2 py-0.5 rounded-md bg-orange-100 text-orange-700 text-[10px] font-bold uppercase tracking-wider">Kcal/100g: ${formatNumber(kcalPer100)}</span>
                                <span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-700 text-[10px] font-bold uppercase tracking-wider">Prot/100g: ${formatNumber(proteinPer100)}</span>
                                <span class="px-2 py-0.5 rounded-md bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider">Carb/100g: ${formatNumber(carbsPer100)}</span>
                                <span class="px-2 py-0.5 rounded-md bg-yellow-100 text-yellow-700 text-[10px] font-bold uppercase tracking-wider">Grasa/100g: ${formatNumber(fatsPer100)}</span>
                            </div>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <span class="px-2 py-0.5 rounded-md bg-orange-50 text-orange-800 text-[10px] font-bold uppercase tracking-wider">Aporte racion - Kcal: <span data-card-field="kcal">${formatNumber(kcal)}</span></span>
                                <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-800 text-[10px] font-bold uppercase tracking-wider">Prot: <span data-card-field="protein">${formatNumber(protein)}</span></span>
                                <span class="px-2 py-0.5 rounded-md bg-green-50 text-green-800 text-[10px] font-bold uppercase tracking-wider">Carb: <span data-card-field="carbs">${formatNumber(carbs)}</span></span>
                                <span class="px-2 py-0.5 rounded-md bg-yellow-50 text-yellow-800 text-[10px] font-bold uppercase tracking-wider">Grasa: <span data-card-field="fats">${formatNumber(fats)}</span></span>
                            </div>
                        </div>
                    `;
                }).join('');

                updateTotals();
            };

            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', renderSummary);
            });

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

                const card = target.closest('.rounded-lg');
                if (!card) {
                    return;
                }

                const grRation = Number(linkedCheckbox.dataset.grRation || 0);
                const ratio = grRation / 100;
                const kcal = Number(linkedCheckbox.dataset.kcal || 0) * ratio;
                const protein = Number(linkedCheckbox.dataset.protein || 0) * ratio;
                const carbs = Number(linkedCheckbox.dataset.carbs || 0) * ratio;
                const fats = Number(linkedCheckbox.dataset.fats || 0) * ratio;

                card.querySelector('[data-card-field="kcal"]').textContent = formatNumber(kcal);
                card.querySelector('[data-card-field="protein"]').textContent = formatNumber(protein);
                card.querySelector('[data-card-field="carbs"]').textContent = formatNumber(carbs);
                card.querySelector('[data-card-field="fats"]').textContent = formatNumber(fats);

                updateTotals();
            });

            renderSummary();
        });
    </script>
</x-app-layout>
