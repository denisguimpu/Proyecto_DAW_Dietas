<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Ingredientes') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        open: {{ $errors->any() ? 'true' : 'false' }},
        editMode: false,
        confirmDelete: false,
        deleteUrl: '',
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
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre del Ingrediente</label>
                            <input type="text" name="name" x-model="ingredient.name" placeholder="Ej: Pechuga de pollo" class="w-full border-gray-300 rounded-lg focus:ring-green-500" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Calorías (kcal)</label>
                                <input type="number" name="calories" x-model="ingredient.calories" placeholder="0" class="w-full border-gray-300 rounded-lg focus:ring-green-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Proteína (g)</label>
                                <input type="number" name="protein" x-model="ingredient.protein" placeholder="0" class="w-full border-gray-300 rounded-lg focus:ring-green-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Carbohidratos (g)</label>
                                <input type="number" name="carbs" x-model="ingredient.carbs" placeholder="0" class="w-full border-gray-300 rounded-lg focus:ring-green-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Grasas (g)</label>
                                <input type="number" name="fats" x-model="ingredient.fats" placeholder="0" class="w-full border-gray-300 rounded-lg focus:ring-green-500" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" @click="open = false" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancelar</button>
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors" x-text="editMode ? 'Actualizar' : 'Guardar'"></button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="confirmDelete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-60 p-4">
            <div @click.away="confirmDelete = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-8 text-center">
                <h3 class="text-lg font-bold text-gray-900 mb-2">¿Estás seguro?</h3>
                <p class="text-gray-500 mb-6 text-sm">Esta acción no se puede deshacer.</p>
                <form :action="deleteUrl" method="POST" class="flex justify-center gap-3">
                    @csrf @method('DELETE')
                    <button type="button" @click="confirmDelete = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">Sí, eliminar</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>