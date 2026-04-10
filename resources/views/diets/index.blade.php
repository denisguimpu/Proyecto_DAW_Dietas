<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl p-8">

                @if(session('success'))
                    <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-8 border-b pb-6">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900">Mis Dietas</h2>
                        <p class="text-gray-500 mt-1">Gestiona y consulta tus planes nutricionales.</p>
                    </div>
                    <a href="{{ route('diets.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl transition duration-200 shadow-md transform hover:scale-105">
                        + Nueva Dieta
                    </a>
                </div>

                <div class="mb-8 rounded-2xl border border-indigo-200 bg-indigo-50 p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-xl font-extrabold text-indigo-900">Grupos de alimentos</h3>
                            <p class="text-sm text-indigo-800">Agrupa menús existentes y obtén el recuento total de calorías.</p>
                        </div>
                        <button
                            type="button"
                            id="toggle-food-group-form"
                            class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-700"
                        >
                            + Nuevo grupo de alimentos
                        </button>
                    </div>

                    <form
                        id="food-group-form"
                        action="{{ route('diets.groups.store') }}"
                        method="POST"
                        class="mt-5 space-y-5 {{ $errors->any() ? '' : 'hidden' }}"
                    >
                        @csrf

                        <div>
                            <label for="food-group-name" class="block text-sm font-bold text-gray-800 mb-2">Nombre del grupo</label>
                            <input
                                id="food-group-name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500"
                                placeholder="Ej: Menús ricos en proteína"
                                required
                            >
                            @error('name')
                                <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <p class="text-sm font-bold text-gray-800 mb-3">Añadir menús creados</p>
                            @if($diets->isEmpty())
                                <p class="text-sm text-gray-600">No hay menús disponibles todavía. Crea una dieta antes de generar grupos.</p>
                            @else
                                <div class="grid gap-3 sm:grid-cols-2">
                                    @foreach($diets as $diet)
                                        <label class="flex items-center justify-between gap-4 rounded-lg border border-indigo-100 bg-white px-4 py-3">
                                            <span class="flex items-center gap-3 text-sm font-semibold text-gray-800">
                                                <input
                                                    type="checkbox"
                                                    name="diets[]"
                                                    value="{{ $diet->id }}"
                                                    data-diet-kcal="{{ $diet->total_kcal }}"
                                                    data-diet-protein="{{ $diet->total_protein }}"
                                                    data-diet-carbs="{{ $diet->total_carbs }}"
                                                    data-diet-fats="{{ $diet->total_fats }}"
                                                    class="food-group-diet-checkbox h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                    @checked(in_array($diet->id, old('diets', [])))
                                                >
                                                {{ $diet->name }}
                                            </span>
                                            <span class="rounded-full bg-orange-100 px-2 py-0.5 text-xs font-bold text-orange-700">
                                                {{ number_format($diet->total_kcal, 2) }} kcal
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                            @error('diets')
                                <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                            @error('diets.*')
                                <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="rounded-lg bg-white px-4 py-3 text-sm font-bold text-gray-800">
                            Recuento total de calorías (menús seleccionados):
                            <span id="food-group-total-kcal" class="text-indigo-700">0.00</span>
                            kcal
                        </div>

                        <div class="grid gap-3 sm:grid-cols-3">
                            <div class="rounded-lg bg-white px-4 py-3 text-sm font-bold text-gray-800">
                                Proteínas totales:
                                <span id="food-group-total-protein" class="text-blue-700">0.00</span>
                            </div>
                            <div class="rounded-lg bg-white px-4 py-3 text-sm font-bold text-gray-800">
                                Carbohidratos totales:
                                <span id="food-group-total-carbs" class="text-green-700">0.00</span>
                            </div>
                            <div class="rounded-lg bg-white px-4 py-3 text-sm font-bold text-gray-800">
                                Grasas totales:
                                <span id="food-group-total-fats" class="text-yellow-700">0.00</span>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-6 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-black disabled:cursor-not-allowed disabled:opacity-50"
                                @disabled($diets->isEmpty())
                            >
                                Guardar grupo
                            </button>
                        </div>
                    </form>

                    @if($foodGroups->isNotEmpty())
                        <div class="mt-6 space-y-3 border-t border-indigo-200 pt-5">
                            <p class="text-sm font-bold uppercase tracking-wider text-indigo-900">Grupos creados</p>
                            @foreach($foodGroups as $group)
                                <div class="rounded-lg border border-indigo-100 bg-white p-4">
                                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                                        <h4 class="text-base font-extrabold text-gray-900">{{ $group->name }}</h4>
                                        <span class="text-sm font-bold text-orange-700">Total kcal: {{ number_format($group->total_kcal, 2) }}</span>
                                    </div>
                                    <div class="mt-3 grid gap-2 sm:grid-cols-4 text-sm">
                                        <span class="rounded-md bg-orange-50 px-2 py-1 font-semibold text-orange-700">Kcal: {{ number_format($group->total_kcal, 2) }}</span>
                                        <span class="rounded-md bg-blue-50 px-2 py-1 font-semibold text-blue-700">Proteínas: {{ number_format($group->total_protein, 2) }}</span>
                                        <span class="rounded-md bg-green-50 px-2 py-1 font-semibold text-green-700">Carbohidratos: {{ number_format($group->total_carbs, 2) }}</span>
                                        <span class="rounded-md bg-yellow-50 px-2 py-1 font-semibold text-yellow-700">Grasas: {{ number_format($group->total_fats, 2) }}</span>
                                    </div>
                                    <p class="mt-3 text-sm text-gray-600">
                                        Menús incluidos:
                                        @if($group->diets->isEmpty())
                                            <span class="font-semibold">Sin menús asociados</span>
                                        @else
                                            <span class="font-semibold">{{ $group->diets->pluck('name')->join(', ') }}</span>
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="overflow-hidden border border-gray-200 sm:rounded-xl">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Descripción</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kcal totales</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Proteínas</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Carbohidratos</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Grasas</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($diets as $diet)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        {{ $diet->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 italic">
                                        {{ $diet->description ?? 'Sin descripción disponible' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-orange-700">
                                        {{ number_format($diet->total_kcal, 2) }} kcal
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-blue-700">
                                        {{ number_format($diet->total_protein, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-green-700">
                                        {{ number_format($diet->total_carbs, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-yellow-700">
                                        {{ number_format($diet->total_fats, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('diets.show', $diet->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold hover:underline">Ver Detalle</a>
                                            <a href="{{ route('diets.edit', $diet->id) }}" class="text-emerald-600 hover:text-emerald-900 font-bold hover:underline">Editar</a>

                                            <form action="{{ route('diets.destroy', $diet->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta dieta?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-bold hover:underline">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500 font-medium">
                                        No hay dietas creadas. ¡Empieza creando tu primer plan nutricional!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.getElementById('toggle-food-group-form');
            const form = document.getElementById('food-group-form');
            const checkboxes = document.querySelectorAll('.food-group-diet-checkbox');
            const totalKcalElement = document.getElementById('food-group-total-kcal');
            const totalProteinElement = document.getElementById('food-group-total-protein');
            const totalCarbsElement = document.getElementById('food-group-total-carbs');
            const totalFatsElement = document.getElementById('food-group-total-fats');

            const updateSelectedDietsTotal = () => {
                const selectedCheckboxes = Array.from(checkboxes)
                    .filter((checkbox) => checkbox.checked)
                    .map((checkbox) => ({
                        kcal: Number(checkbox.dataset.dietKcal || 0),
                        protein: Number(checkbox.dataset.dietProtein || 0),
                        carbs: Number(checkbox.dataset.dietCarbs || 0),
                        fats: Number(checkbox.dataset.dietFats || 0),
                    }));

                const totals = selectedCheckboxes.reduce((sum, current) => ({
                    kcal: sum.kcal + current.kcal,
                    protein: sum.protein + current.protein,
                    carbs: sum.carbs + current.carbs,
                    fats: sum.fats + current.fats,
                }), { kcal: 0, protein: 0, carbs: 0, fats: 0 });

                if (totalKcalElement) {
                    totalKcalElement.textContent = totals.kcal.toFixed(2);
                }

                if (totalProteinElement) {
                    totalProteinElement.textContent = totals.protein.toFixed(2);
                }

                if (totalCarbsElement) {
                    totalCarbsElement.textContent = totals.carbs.toFixed(2);
                }

                if (totalFatsElement) {
                    totalFatsElement.textContent = totals.fats.toFixed(2);
                }
            };

            if (toggleButton && form) {
                toggleButton.addEventListener('click', function () {
                    form.classList.toggle('hidden');
                });
            }

            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', updateSelectedDietsTotal);
            });

            updateSelectedDietsTotal();
        });
    </script>
</x-app-layout>
