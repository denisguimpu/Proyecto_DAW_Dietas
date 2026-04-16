<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Crear Lista de la Compra</h2>

                <form action="{{ route('shopping-lists.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la lista</label>
                        <input type="text" name="name" required class="w-full border rounded px-3 py-2" placeholder="Ej: Compra semanal">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Selecciona las dietas</label>
                        @if($diets->isEmpty())
                            <p class="text-gray-500">No hay dietas disponibles. <a href="{{ route('diets.create') }}" class="text-blue-600 hover:underline">Crea una dieta primero</a></p>
                        @else
                            <div class="space-y-2">
                                @foreach($diets as $diet)
                                <label class="flex items-center gap-2 p-3 border rounded hover:bg-gray-50">
                                    <input type="checkbox" name="diet_ids[]" value="{{ $diet->id }}" class="rounded">
                                    <span class="font-medium">{{ $diet->name }}</span>
                                    <span class="text-gray-500 text-sm">({{ $diet->ingredients->count() }} ingredientes)</span>
                                </label>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                            Generar Lista
                        </button>
                        <a href="{{ route('shopping-lists.index') }}" class="px-6 py-2 border rounded hover:bg-gray-50">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
