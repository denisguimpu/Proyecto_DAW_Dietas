<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Ingredientes') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        open: {{ $errors->any() ? 'true' : 'false' }},
        editMode: false,
        ingredient: { id: '', name: '', calories: '', protein: '', carbs: '', fats: '' }
    }" @edit-ingredient.window="
        ingredient = $event.detail;
        editMode = true;
        open = true;
    ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Listado de Ingredientes</h3>
                <button @click="open = true; editMode = false; ingredient = { id: '', name: '', calories: '', protein: '', carbs: '', fats: '' }" 
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-all">
                    + Nuevo Ingrediente
                </button>
            </div>

            <livewire:ingredients-table />
        </div>

        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-60 p-4">
            <div @click.away="open = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6" x-text="editMode ? 'Editar Ingrediente' : 'Agregar Ingrediente'"></h3>
                
                <form :action="editMode ? '/ingredients/' + ingredient.id : '{{ route('ingredients.store') }}'" method="POST">
                    @csrf
                    <template x-if="editMode">
                        @method('PUT')
                    </template>
                    
                    <div class="space-y-4">
                        <input type="text" name="name" x-model="ingredient.name" placeholder="Nombre" class="w-full border-gray-300 rounded-lg" required>
                        <div class="grid grid-cols-2 gap-4">
                            <input type="number" name="calories" x-model="ingredient.calories" placeholder="Calorías" class="border-gray-300 rounded-lg" required>
                            <input type="number" name="protein" x-model="ingredient.protein" placeholder="Proteína (g)" class="border-gray-300 rounded-lg" required>
                            <input type="number" name="carbs" x-model="ingredient.carbs" placeholder="Carbohidratos (g)" class="border-gray-300 rounded-lg" required>
                            <input type="number" name="fats" x-model="ingredient.fats" placeholder="Grasas (g)" class="border-gray-300 rounded-lg" required>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" @click="open = false" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancelar</button>
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg" x-text="editMode ? 'Actualizar' : 'Guardar'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>