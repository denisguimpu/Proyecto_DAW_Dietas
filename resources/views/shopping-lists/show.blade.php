<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $shoppingList->name }}</h2>
                    <a href="{{ route('shopping-lists.index') }}" class="text-gray-600 hover:underline">← Volver</a>
                </div>

                <div class="overflow-hidden border border-gray-200 sm:rounded-xl">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Ingrediente</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Cantidad</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Unidad</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($shoppingList->ingredients as $ingredient)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium">{{ $ingredient->name }}</td>
                                <td class="px-6 py-4">{{ $ingredient->pivot->quantity }}</td>
                                <td class="px-6 py-4">{{ $ingredient->unit ?? 'g' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <form action="{{ route('shopping-lists.destroy', $shoppingList) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('¿Eliminar esta lista?')">
                            Eliminar Lista
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
