<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Nueva Dieta</h2>

                <form action="{{ route('diets.store') }}" method="POST">
                    @csrf

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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($ingredients as $ingredient)
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <input type="checkbox" name="ingredients[]" value="{{ $ingredient->id }}" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">{{ $ingredient->name }}</span>
                                        <span class="text-xs text-gray-500 block">{{ $ingredient->calories }} kcal | P: {{ $ingredient->protein }}g</span>
                                    </div>
                                </label>
                            @empty
                                <p class="text-gray-500 text-sm">No hay ingredientes creados. <a href="{{ route('ingredients.index') }}" class="text-indigo-600 underline">Crea algunos primero.</a></p>
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
</x-app-layout>