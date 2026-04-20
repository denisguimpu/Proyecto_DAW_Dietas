<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Lista de la Compra Semanal</h2>

                <form action="{{ route('shopping-lists.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la lista</label>
                        <input type="text" name="name" required class="w-full border rounded px-3 py-2" placeholder="Ej: Compra semanal">
                    </div>

                    <div class="mb-6">
                        <p class="text-sm text-gray-600 mb-4">Ingredientes consolidados de todos los días de la semana:</p>
                        
                        @if(empty($allMeals))
                            <p class="text-gray-500">No hay menús asignados. 
                                <a href="{{ route('meal-plans.index') }}" class="text-blue-600 hover:underline">Asigna menús a los días</a>
                            </p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full bg-white rounded-lg shadow">
                                    <thead class="bg-gray-100 text-gray-800">
                                        <tr>
                                            <th class="p-4 text-left font-bold">Ingrediente</th>
                                            <th class="p-4 text-left font-bold bg-gray-100">Cantidad (g)</th>
                                            <th class="p-4 text-left font-bold bg-orange-100">Kcal/100g</th>
                                            <th class="p-4 text-left font-bold bg-blue-100">Prot</th>
                                            <th class="p-4 text-left font-bold bg-green-100">Carbs</th>
                                            <th class="p-4 text-left font-bold bg-yellow-100">Grasas</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($allMeals as $name => $ingredient)
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                                {{ $ingredient['name'] }}
                                                <input type="hidden" name="ingredients[{{ $name }}][name]" value="{{ $name }}">
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="number" name="ingredients[{{ $name }}][quantity]" 
                                                    value="{{ $ingredient['quantity'] }}" 
                                                    class="w-24 border rounded px-3 py-2 text-sm" min="0">
                                                <span class="text-gray-500 text-sm ml-1">g</span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $ingredient['kcal'] }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $ingredient['protein'] }}g</td>
                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $ingredient['carbs'] }}g</td>
                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $ingredient['fats'] }}g</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                            Guardar Lista
                        </button>
                        <a href="{{ route('shopping-lists.index') }}" class="px-6 py-2 border rounded hover:bg-gray-50">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>