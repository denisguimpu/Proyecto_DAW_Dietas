<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl p-8">
                <div class="flex justify-between items-center mb-8 border-b pb-6">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900">Lista de la Compra</h2>
                        <p class="text-gray-500 mt-1">Ingredientes consolidados de tus dietas.</p>
                    </div>
                    <a href="{{ route('shopping-lists.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-xl transition duration-200">
                        + Nueva Lista
                    </a>
                </div>

                @if($shoppingLists->isEmpty())
                    <p class="text-gray-500">No hay listas de compra creadas.</p>
                @else
                    <div class="overflow-hidden border border-gray-200 sm:rounded-xl">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Nombre</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Ingredientes</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($shoppingLists as $list)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium">{{ $list->name }}</td>
                                    <td class="px-6 py-4">{{ $list->ingredients->count() }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('shopping-lists.show', $list) }}" class="text-blue-600 hover:underline mr-4">Ver</a>
                                        <form action="{{ route('shopping-lists.destroy', $list) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
