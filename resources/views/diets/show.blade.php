<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-2xl p-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between mb-2">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $diet->name }}</h1>
                        <p class="text-gray-600">{{ $diet->description }}</p>
                    </div>

                    <a href="{{ route('diets.edit', $diet->id) }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700">
                        Editar dieta
                    </a>
                </div>

                <div class="mb-6 border-t pt-6">
                    <p class="text-sm font-semibold text-gray-700">Resumen de ingredientes</p>
                    <p class="text-sm text-gray-500">Desde aquí puedes revisar la composición actual o pasar al editor para añadir o quitar alimentos.</p>
                </div>

                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Ingredientes:</h3>
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    @foreach($diet->ingredients as $ingredient)
                        <li>{{ $ingredient->name }} ({{ $ingredient->kcal }} kcal)</li>
                    @endforeach
                </ul>

                <div class="mt-8">
                    <a href="{{ route('diets.index') }}" class="text-indigo-600 hover:underline font-bold">← Volver al listado</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
