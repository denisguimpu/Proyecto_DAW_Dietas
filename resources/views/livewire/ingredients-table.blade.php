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

<div class="space-y-4">
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="🔍 Buscar..." class="w-full rounded-lg border-gray-300">
    </div>

    <table class="w-full bg-white rounded-lg shadow">
        <thead class="bg-gray-100">
            <tr>
                @foreach(['name' => 'Nombre', 'calories' => 'Kcal', 'protein' => 'Prot', 'carbs' => 'Carb', 'fats' => 'Grasa'] as $field => $label)
                    <th class="p-4 text-left cursor-pointer hover:text-indigo-600" wire:click="sortBy('{{ $field }}')">
                        {{ $label }} ↕
                    </th>
                @endforeach
                <th class="p-4"></th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($ingredients as $ingredient)
            <tr wire:key="ingredient-{{ $ingredient->id }}">
                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $ingredient->name }}</td>
                <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">{{ $ingredient->calories }}</span></td>
                <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">{{ $ingredient->protein }}g</span></td>
                <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">{{ $ingredient->carbs }}g</span></td>
                <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">{{ $ingredient->fats }}g</span></td>
                
                <td class="px-6 py-4 text-right text-sm font-medium">
                    <button 
                        type="button"
                        x-on:click="$dispatch('edit-ingredient', { 
                            id: {{ $ingredient->id }}, 
                            name: '{{ $ingredient->name }}', 
                            calories: {{ $ingredient->calories }},
                            protein: {{ $ingredient->protein }},
                            carbs: {{ $ingredient->carbs }},
                            fats: {{ $ingredient->fats }} 
                        })"
                        class="text-indigo-600 hover:text-indigo-900 mr-3 font-semibold">
                        Editar
                    </button>

                    <button 
                        type="button"
                        @click="deleteUrl = '{{ route('ingredients.destroy', $ingredient->id) }}'; confirmDelete = true;"
                        class="text-red-600 hover:text-red-900 font-semibold">
                        Eliminar
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>