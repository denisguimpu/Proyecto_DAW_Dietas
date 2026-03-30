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
    <div class="grid grid-cols-1 gap-4">
        @forelse($ingredients as $ingredient)
            <label class="flex items-start p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200 group">
                <input type="checkbox" name="ingredients[]" value="{{ $ingredient->name }}" class="mt-1 h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">

                <div class="ml-4 w-full flex items-start justify-between gap-4">
                    <span class="block text-sm font-bold text-gray-900 group-hover:text-indigo-900">{{ $ingredient->name }}</span>

                    <div class="flex flex-wrap justify-end gap-2">
                        <span class="px-2 py-0.5 rounded-md bg-gray-100 text-gray-700 text-[10px] font-bold uppercase tracking-wider">Racion (g): {{ $ingredient->gr_ration }}</span>
                        <span class="px-2 py-0.5 rounded-md bg-orange-100 text-orange-700 text-[10px] font-bold uppercase tracking-wider">Kcal: {{ $ingredient->kcal }}</span>
                        <span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-700 text-[10px] font-bold uppercase tracking-wider">Prot: {{ $ingredient->protein }}</span>
                        <span class="px-2 py-0.5 rounded-md bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider">Carb: {{ $ingredient->carbs }}</span>
                        <span class="px-2 py-0.5 rounded-md bg-yellow-100 text-yellow-700 text-[10px] font-bold uppercase tracking-wider">Grasa: {{ $ingredient->fats }}</span>
                    </div>
                </div>
            </label>
        @empty
            <p class="text-gray-500 text-sm">No hay ingredientes creados.</p>
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
