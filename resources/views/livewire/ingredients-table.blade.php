<?php

use Livewire\Volt\Component;
use App\Models\Ingredient;

new class extends Component {
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public function sortBy($field) {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    public function with() {
        return [
            'ingredients' => Ingredient::where('name', 'like', '%' . $this->search . '%')
                ->orderBy($this->sortField, $this->sortDirection)
                ->get(),
        ];
    }
}; ?>

<div class="space-y-4" data-ingredients-table-root>
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <input id="ingredients-search-input" type="text" wire:model.live.debounce.300ms="search" placeholder="🔍 Buscar..." class="w-full rounded-lg border-gray-300">
    </div>

    <table id="ingredients-data-table" class="w-full bg-white rounded-lg shadow">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-4 text-left">
                    <button type="button" class="font-bold hover:text-indigo-600 js-sort" data-sort-index="0" data-sort-type="text">Ingrediente ↕</button>
                </th>
                <th class="p-4 text-left bg-gray-100 text-gray-700">
                    <button type="button" class="font-bold hover:text-indigo-600 js-sort" data-sort-index="1" data-sort-type="number">Racion predefinida (g) ↕</button>
                </th>
                <th class="p-4 text-left bg-orange-100 text-orange-700">
                    <button type="button" class="font-bold hover:text-indigo-600 js-sort" data-sort-index="2" data-sort-type="number">Kcal/100g ↕</button>
                </th>
                <th class="p-4 text-left bg-blue-100 text-blue-700">
                    <button type="button" class="font-bold hover:text-indigo-600 js-sort" data-sort-index="3" data-sort-type="number">Proteinas/100g ↕</button>
                </th>
                <th class="p-4 text-left bg-green-100 text-green-700">
                    <button type="button" class="font-bold hover:text-indigo-600 js-sort" data-sort-index="4" data-sort-type="number">Carbohidratos/100g ↕</button>
                </th>
                <th class="p-4 text-left bg-yellow-100 text-yellow-700">
                    <button type="button" class="font-bold hover:text-indigo-600 js-sort" data-sort-index="5" data-sort-type="number">Grasas/100g ↕</button>
                </th>
                <th class="p-4"></th>
            </tr>
        </thead>
        <tbody id="ingredients-table-body" class="bg-white divide-y divide-gray-200">
            @foreach($ingredients as $ingredient)
            <tr>
                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $ingredient->name }}</td>
                <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-bold">{{ $ingredient->gr_ration }}</span></td>
                <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">{{ $ingredient->kcal }}</span></td>
                <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">{{ $ingredient->protein }}</span></td>
                <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">{{ $ingredient->carbs }}</span></td>
                <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">{{ $ingredient->fats }}</span></td>

                <td class="px-6 py-4 text-right text-sm font-medium">
                    <button
                        type="button"
                        x-on:click="$dispatch('edit-ingredient', {
                            name: @js($ingredient->name),
                            gr_ration: @js($ingredient->gr_ration),
                            kcal: @js($ingredient->kcal),
                            protein: @js($ingredient->protein),
                            carbs: @js($ingredient->carbs),
                            fats: @js($ingredient->fats),
                            editUrl: @js(route('ingredients.update', $ingredient))
                        })"
                        class="text-indigo-600 hover:text-indigo-900 mr-3 font-semibold">
                        Editar
                    </button>

                    <button
                        type="button"
                        @click="deleteUrl = '{{ route('ingredients.destroy', $ingredient) }}'; confirmDelete = true;"
                        class="text-red-600 hover:text-red-900 font-semibold">
                        Eliminar
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const root = document.querySelector('[data-ingredients-table-root]');
        if (!root || root.dataset.jsReady === '1') {
            return;
        }

        root.dataset.jsReady = '1';

        const tableBody = root.querySelector('#ingredients-table-body');
        const searchInput = root.querySelector('#ingredients-search-input');
        const sortButtons = root.querySelectorAll('.js-sort');

        if (!tableBody) {
            return;
        }

        const parseValue = (row, columnIndex, type) => {
            const cell = row.children[columnIndex];
            const raw = (cell?.textContent || '').trim();

            if (type === 'number') {
                const normalized = raw.replace(',', '.').replace(/[^0-9.-]/g, '');
                const value = Number(normalized);
                return Number.isFinite(value) ? value : 0;
            }

            return raw.toLowerCase();
        };

        sortButtons.forEach((button) => {
            button.addEventListener('click', function () {
                const columnIndex = Number(button.dataset.sortIndex);
                const type = button.dataset.sortType || 'text';
                const direction = button.dataset.sortDirection === 'asc' ? 'desc' : 'asc';

                sortButtons.forEach((btn) => {
                    if (btn !== button) {
                        delete btn.dataset.sortDirection;
                    }
                });

                button.dataset.sortDirection = direction;

                const rows = Array.from(tableBody.querySelectorAll('tr'));
                rows.sort((a, b) => {
                    const left = parseValue(a, columnIndex, type);
                    const right = parseValue(b, columnIndex, type);

                    if (left < right) {
                        return direction === 'asc' ? -1 : 1;
                    }

                    if (left > right) {
                        return direction === 'asc' ? 1 : -1;
                    }

                    return 0;
                });

                rows.forEach((row) => tableBody.appendChild(row));
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const query = searchInput.value.toLowerCase().trim();
                const rows = Array.from(tableBody.querySelectorAll('tr'));

                rows.forEach((row) => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        }
    });
</script>
