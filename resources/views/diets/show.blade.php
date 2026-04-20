<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-2xl p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $diet->name }}</h1>
                <p class="text-gray-600 mb-6">{{ $diet->description }}</p>

                @if($diet->target_calories)
                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">Objetivo Diario</h3>
                    <div class="grid grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ round($diet->target_calories) }}</div>
                            <div class="text-sm text-gray-600">Kcal</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-500">{{ round($diet->target_protein) }}g</div>
                            <div class="text-sm text-gray-600">Proteína</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-500">{{ round($diet->target_carbs) }}g</div>
                            <div class="text-sm text-gray-600">Carbs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-500">{{ round($diet->target_fats) }}g</div>
                            <div class="text-sm text-gray-600">Grasas</div>
                        </div>
                    </div>
                </div>
                @endif

                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Ingredientes Seleccionados:</h3>
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    @foreach($diet->ingredients as $ingredient)
                        <li>{{ $ingredient->name }} ({{ $ingredient->kcal }} kcal)</li>
                    @endforeach
                </ul>

                <div class="mt-8 flex gap-4">
                    <a href="{{ route('diets.edit', $diet->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Editar Dieta</a>
                    <a href="{{ route('diets.index') }}" class="text-indigo-600 hover:underline font-bold">← Volver al listado</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
