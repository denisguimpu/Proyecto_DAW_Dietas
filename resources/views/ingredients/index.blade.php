<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Ingredientes') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ open: {{ $errors->any() ? 'true' : 'false' }} }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex justify-between items-center border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Listado de Ingredientes</h3>
                    <button @click="open = true" 
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-all">
                        + Nuevo Ingrediente
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Calorías</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prot.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Carb.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grasas</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($ingredients as $ingredient)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $ingredient->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ingredient->calories }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ingredient->protein }}g</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ingredient->carbs }}g</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ingredient->fats }}g</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                        <form action="{{ route('ingredients.destroy', $ingredient->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay ingredientes.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-60 p-4">
            <div @click.away="open = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Agregar Ingrediente</h3>
                
                <form action="{{ route('ingredients.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Nombre</label>
                            <input type="text" name="name" class="w-full mt-1 border-gray-300 rounded-lg focus:ring-green-500" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <input type="number" name="calories" placeholder="Calorías" class="border-gray-300 rounded-lg w-full" required>
                            <input type="number" name="protein" placeholder="Proteína (g)" class="border-gray-300 rounded-lg w-full" required>
                            <input type="number" name="carbs" placeholder="Carbohidratos (g)" class="border-gray-300 rounded-lg w-full" required>
                            <input type="number" name="fats" placeholder="Grasas (g)" class="border-gray-300 rounded-lg w-full" required>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" @click="open = false" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancelar</button>
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>