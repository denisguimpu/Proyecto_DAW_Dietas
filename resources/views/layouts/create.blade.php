<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Crear Nuevo menú</h2>
                <form action="{{ route('menus.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nombre del menú:</label>
                        <input type="text" name="name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej: Menú Hiperproteico Lunes">
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Descripción (opcional):</label>
                        <textarea name="description" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-4">Selecciona los ingredientes que componen el menú:</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($ingredients as $ingredient)
                                <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50 transition">
                                    <input type="checkbox" name="ingredients[]" value="{{ $ingredient->name }}" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <label class="ml-3 block text-sm text-gray-700">
                                        <span class="font-bold">{{ $ingredient->name }}</span>
                                        <span class="text-gray-500 text-xs">({{ $ingredient->kcal }} kcal)</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow transition">
                            Guardar menú e ingredientes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
