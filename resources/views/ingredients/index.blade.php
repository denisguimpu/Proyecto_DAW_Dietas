<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Ingredientes') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal con el estado de Alpine --}}
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
            
            {{-- Encabezado de la sección --}}
            <div class="mb-6 flex justify-between items-center bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Listado de Ingredientes</h3>
                <button @click="open = true; editMode = false; ingredient = { id: '', name: '', calories: '', protein: '', carbs: '', fats: '' }" 
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-all transform active:scale-95">
                    + Nuevo Ingrediente
                </button>
            </div>

            {{-- Llamada al componente LIVEWIRE correcto --}}
            <livewire:ingredients-table />
        </div>

        {{-- Modal de Crear / Editar --}}
        <div x-show="open" 
             x-cloak 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-60 p-4">
            
            <div @click.away="open = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6" x-text="editMode ? 'Editar Ingrediente' : 'Agregar Ingrediente'"></h3>
                
                {{-- Formulario dinámico --}}
                <form :action="editMode ? '/ingredients/' + ingredient.id : '{{ route('ingredients.store') }}'" method="POST">
                    @csrf
                    <template x-if="editMode">
                        @method('PUT')
                    </template>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre del Ingrediente</label>
                            <input type="text" name="name" x-model="ingredient.name" placeholder="Ej: Pechuga de pollo" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
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
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Carbos (g)</label>
                                <input type="number" name="carbs" x-model="ingredient.carbs" placeholder="0" class="w-full border-gray-300 rounded-lg focus:ring-green-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Grasas (g)</label>
                                <input type="number" name="fats" x-model="ingredient.fats" placeholder="0" class="w-full border-gray-300 rounded-lg focus:ring-green-500" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" @click="open = false" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">Cancelar</button>
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 shadow-lg transition-all" x-text="editMode ? 'Actualizar' : 'Guardar'"></button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal de Confirmación de Eliminación --}}
        <div x-show="confirmDelete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-60 p-4">
            <div @click.away="confirmDelete = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-8 text-center transform transition-all">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">¿Estás seguro?</h3>
                <p class="text-gray-500 mb-6 text-sm">Esta acción eliminará el ingrediente permanentemente.</p>
                
                <form :action="deleteUrl" method="POST" class="flex justify-center gap-3">
                    @csrf @method('DELETE')
                    <button type="button" @click="confirmDelete = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium shadow-md">Sí, eliminar</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>