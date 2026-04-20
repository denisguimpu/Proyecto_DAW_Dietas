<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl p-8">
                <div class="flex justify-between items-center mb-8 border-b pb-6">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900">Lista de la Compra Semanal</h2>
                        <p class="text-gray-500 mt-1">Ingredientes consolidados de toda la semana.</p>
                    </div>
                </div>

                @if(empty($allMeals))
                    <p class="text-gray-500">No hay menús asignados. 
                        <a href="{{ route('meal-plans.index') }}" class="text-blue-600 hover:underline">Asigna menús a los días</a>
                    </p>
                @else
                    <div class="overflow-hidden border border-gray-200 sm:rounded-xl">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Ingrediente</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($allMeals as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $item['name'] }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ round($item['quantity']) }}g</td>
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