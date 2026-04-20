<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Asignar Dieta a un Día</h2>

                <form action="{{ route('meal-plans.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Día de la semana</label>
                        <select name="day_of_week" required class="w-full border rounded px-3 py-2">
                            @foreach($days as $index => $day)
                            <option value="{{ $day }}" {{ $selectedDay == $day ? 'selected' : '' }}>{{ $daysSpanish[$index] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Dieta</label>
                        @if($diets->isEmpty())
                            <p class="text-gray-500">No hay dietas disponibles. <a href="{{ route('diets.create') }}" class="text-blue-600 hover:underline">Crea una dieta primero</a></p>
                        @else
                            <select name="diet_id" required class="w-full border rounded px-3 py-2">
                                <option value="">-- Selecciona una dieta --</option>
                                @foreach($diets as $diet)
                                <option value="{{ $diet->id }}">
                                    {{ $diet->name }}
                                </option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Guardar
                        </button>
                        <a href="{{ route('meal-plans.index') }}" class="px-6 py-2 border rounded hover:bg-gray-50">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
