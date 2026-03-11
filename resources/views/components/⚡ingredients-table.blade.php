<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ingredient;

class IngredientsTable extends Component
{
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public function sortBy($field) {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    public function render()
    {
        return view('livewire.ingredients-table', [
            'ingredients' => Ingredient::where('name', 'like', '%' . $this->search . '%')
                ->orderBy($this->sortField, $this->sortDirection)
                ->get()
        ]);
    }
}