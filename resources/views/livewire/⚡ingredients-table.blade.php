<?php
use Livewire\Component;
use App\Models\Ingredient;

class IngredientsTable extends Component {
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public function sortBy($field) {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    public function render() {
        return view('livewire.ingredients-table', [
            'ingredients' => Ingredient::where('name', 'like', '%' . $this->search . '%')
                ->orderBy($this->sortField, $this->sortDirection)
                ->get()
        ]);
    }
};
?>

<div class="space-y-4">
    <input type="text" wire:model.live.debounce.300ms="search" placeholder="🔍 Buscar..." class="w-full rounded-lg border-gray-300">

    <table class="w-full bg-white rounded-lg overflow-hidden shadow">
        <thead class="bg-gray-100">
            <tr>
                @foreach(['name' => 'Nombre', 'calories' => 'Kcal', 'protein' => 'Prot', 'carbs' => 'Carb', 'fats' => 'Grasa'] as $field => $label)
                    <th class="p-4 text-left cursor-pointer hover:text-indigo-600" wire:click="sortBy('{{ $field }}')">
                        {{ $label }} ↕
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($ingredients as $ingredient)
                <tr class="border-t">
                    <td class="p-4 font-medium">{{ $ingredient->name }}</td>
                    <td class="p-4"><span class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full text-xs">{{ $ingredient->calories }}</span></td>
                    <td class="p-4"><span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $ingredient->protein }}g</span></td>
                    <td class="p-4"><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">{{ $ingredient->carbs }}g</span></td>
                    <td class="p-4"><span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">{{ $ingredient->fats }}g</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>