<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl p-8">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-900">Mis Dietas</h2>
                    <a href="{{ route('diets.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl transition duration-200">
                        + Nueva Dieta
                    </a>
                </div>

                @if($diets->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">No hay dietas creadas.</p>
                        <a href="{{ route('diets.create') }}" class="text-blue-600 hover:underline mt-2 inline-block">Crea tu primera dieta</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($diets as $diet)
                        <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition">
                            <h3 class="text-xl font-bold text-gray-900">{{ $diet->name }}</h3>
                            <p class="text-gray-600 mt-2 text-sm">{{ $diet->description ?? 'Sin descripción' }}</p>
                            
                            @if($diet->target_calories)
                            <div class="mt-4 grid grid-cols-2 gap-2 text-sm">
                                <div class="bg-blue-50 rounded p-2 text-center">
                                    <div class="font-bold text-blue-600">{{ round($diet->target_calories) }}</div>
                                    <div class="text-xs text-gray-500">kcal</div>
                                </div>
                                <div class="bg-red-50 rounded p-2 text-center">
                                    <div class="font-bold text-red-500">{{ round($diet->target_protein ?? 0) }}g</div>
                                    <div class="text-xs text-gray-500">proteína</div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('diets.show', $diet->id) }}" class="text-blue-600 hover:underline text-sm">Ver</a>
                                <a href="{{ route('diets.edit', $diet->id) }}" class="text-green-600 hover:underline text-sm">Editar</a>
                                <form action="{{ route('diets.destroy', $diet->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>