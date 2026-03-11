<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Crear Nueva Dieta</h2>

            <form action="{{ route('diets.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre de la dieta:</label>
                    <input type="text" name="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej: Dieta Hiperproteica">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                    <textarea name="description" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Opcional..."></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-4 border-b pb-2">Selecciona los Ingredientes:</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($ingredients as $ingredient)
                            <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50 transition">
                                <input type="checkbox" name="ingredients[]" value="{{ $ingredient->id }}" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label class="ml-3 block text-sm text-gray-700 font-medium">
                                    {{ $ingredient->name }} 
                                    <span class="text-xs text-gray-400">({{ $ingredient->calories }} kcal)</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('diets.index') }}" class="text-gray-600 hover:text-gray-900">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow transition">
                        Guardar Dieta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>