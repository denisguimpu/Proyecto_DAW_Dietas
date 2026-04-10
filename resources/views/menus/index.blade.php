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
                        <h2 class="text-3xl font-extrabold text-gray-900">Mis menús</h2>
                        <p class="text-gray-500 mt-1">Gestiona y consulta tus planes nutricionales.</p>
                    </div>
                    <a href="{{ route('menus.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl transition duration-200 shadow-md transform hover:scale-105">
                        + Nuevo menú
                    </a>
                </div>

                <div class="mb-8 rounded-2xl border border-indigo-200 bg-indigo-50 p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-xl font-extrabold text-indigo-900">Grupos de menús</h3>
                            <p class="text-sm text-indigo-800">Agrupa menús existentes y obtén el recuento total de nutrientes.</p>
                        </div>
                        <button
                            type="button"
                            id="toggle-food-group-form"
                            class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-700"
                        >
                            + Nuevo grupo de menús
                        </button>
                    </div>

                    <form
                        id="food-group-form"
                        action="{{ route('menus.groups.store') }}"
                        method="POST"
                        class="mt-5 space-y-5 {{ $errors->any() ? '' : 'hidden' }}"
                    >
                        @csrf

                        <div>
                            <label for="food-group-name" class="block text-sm font-bold text-gray-800 mb-2">Nombre del grupo de menús</label>
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
                            @if($menus->isEmpty())
                                <p class="text-sm text-gray-600">No hay menús disponibles todavía. Crea un menú antes de generar grupos.</p>
                            @else
                                <div class="grid gap-3 sm:grid-cols-2">
                                    @foreach($menus as $menu)
                                        <label class="flex items-center justify-between gap-4 rounded-lg border border-indigo-100 bg-white px-4 py-3">
                                            <span class="flex items-center gap-3 text-sm font-semibold text-gray-800">
                                                <input
                                                    type="checkbox"
                                                    name="menus[]"
                                                    value="{{ $menu->id }}"
                                                    data-menu-kcal="{{ $menu->total_kcal }}"
                                                    data-menu-protein="{{ $menu->total_protein }}"
                                                    data-menu-carbs="{{ $menu->total_carbs }}"
                                                    data-menu-fats="{{ $menu->total_fats }}"
                                                    class="food-group-menu-checkbox h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                    @checked(in_array($menu->id, old('menus', [])))
                                                >
                                                {{ $menu->name }}
                                            </span>
                                            <span class="rounded-full bg-orange-100 px-2 py-0.5 text-xs font-bold text-orange-700">
                                                {{ number_format($menu->total_kcal, 2) }} kcal
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                            @error('menus')
                                <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                            @error('menus.*')
                                <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="rounded-lg bg-white px-4 py-3 text-sm font-bold text-gray-800">
                            Recuento total de nutrientes (menús seleccionados):
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
                                @disabled($menus->isEmpty())
                            >
                                Guardar grupo de menús
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
                                        <div class="mt-2 flex items-center gap-3 sm:mt-0">
                                            <button
                                                type="button"
                                                class="text-sm font-bold text-indigo-600 hover:text-indigo-800 hover:underline"
                                                data-toggle-group-edit="{{ $group->id }}"
                                            >
                                                Editar grupo
                                            </button>
                                            <form action="{{ route('menus.groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este grupo de menús?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm font-bold text-red-600 hover:text-red-800 hover:underline">Eliminar grupo</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="mt-3 grid gap-2 sm:grid-cols-4 text-sm">
                                        <span class="rounded-md bg-orange-50 px-2 py-1 font-semibold text-orange-700">Kcal: {{ number_format($group->total_kcal, 2) }}</span>
                                        <span class="rounded-md bg-blue-50 px-2 py-1 font-semibold text-blue-700">Proteínas: {{ number_format($group->total_protein, 2) }}</span>
                                        <span class="rounded-md bg-green-50 px-2 py-1 font-semibold text-green-700">Carbohidratos: {{ number_format($group->total_carbs, 2) }}</span>
                                        <span class="rounded-md bg-yellow-50 px-2 py-1 font-semibold text-yellow-700">Grasas: {{ number_format($group->total_fats, 2) }}</span>
                                    </div>
                                    <p class="mt-3 text-sm text-gray-600">
                                        Menús incluidos:
                                        @if($group->menus->isEmpty())
                                            <span class="font-semibold">Sin menús asociados</span>
                                        @else
                                            <span class="font-semibold">{{ $group->menus->pluck('name')->join(', ') }}</span>
                                        @endif
                                    </p>

                                    <form
                                        action="{{ route('menus.groups.update', $group->id) }}"
                                        method="POST"
                                        class="mt-4 hidden rounded-lg border border-indigo-100 bg-indigo-50 p-4"
                                        data-group-edit-panel="{{ $group->id }}"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <div>
                                            <label class="block text-sm font-bold text-gray-800 mb-2">Nombre del grupo</label>
                                            <input
                                                type="text"
                                                name="name"
                                                value="{{ $group->name }}"
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500"
                                                required
                                            >
                                        </div>

                                        <div class="mt-4">
                                            <p class="text-sm font-bold text-gray-800 mb-3">Menús incluidos</p>
                                            @if($menus->isEmpty())
                                                <p class="text-sm text-gray-600">No hay menús disponibles para asociar.</p>
                                            @else
                                                <div class="grid gap-2 sm:grid-cols-2">
                                                    @foreach($menus as $menu)
                                                        <label class="flex items-center gap-3 rounded-md border border-indigo-100 bg-white px-3 py-2 text-sm font-semibold text-gray-800">
                                                            <input
                                                                type="checkbox"
                                                                name="menus[]"
                                                                value="{{ $menu->id }}"
                                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                                @checked($group->menus->contains('id', $menu->id))
                                                            >
                                                            <span>{{ $menu->name }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mt-4 flex justify-end gap-3">
                                            <button
                                                type="button"
                                                class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-bold text-gray-900 hover:bg-gray-300"
                                                data-toggle-group-edit="{{ $group->id }}"
                                            >
                                                Cancelar
                                            </button>
                                            <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-bold text-white hover:bg-black">
                                                Guardar cambios
                                            </button>
                                        </div>
                                    </form>
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
                            @forelse($menus as $menu)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        {{ $menu->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 italic">
                                        {{ $menu->description ?? 'Sin descripción disponible' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-orange-700">
                                        {{ number_format($menu->total_kcal, 2) }} kcal
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-blue-700">
                                        {{ number_format($menu->total_protein, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-green-700">
                                        {{ number_format($menu->total_carbs, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-yellow-700">
                                        {{ number_format($menu->total_fats, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('menus.show', $menu->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold hover:underline">Ver detalle</a>
                                            <a href="{{ route('menus.edit', $menu->id) }}" class="text-emerald-600 hover:text-emerald-900 font-bold hover:underline">Editar</a>

                                            <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este menú?');">
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
                                        No hay menús creados. ¡Empieza creando tu primer plan nutricional!
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
            const checkboxes = document.querySelectorAll('.food-group-menu-checkbox');
            const totalKcalElement = document.getElementById('food-group-total-kcal');
            const totalProteinElement = document.getElementById('food-group-total-protein');
            const totalCarbsElement = document.getElementById('food-group-total-carbs');
            const totalFatsElement = document.getElementById('food-group-total-fats');

            const updateSelectedMenusTotal = () => {
                const selectedCheckboxes = Array.from(checkboxes)
                    .filter((checkbox) => checkbox.checked)
                    .map((checkbox) => ({
                        kcal: Number(checkbox.dataset.menuKcal || 0),
                        protein: Number(checkbox.dataset.menuProtein || 0),
                        carbs: Number(checkbox.dataset.menuCarbs || 0),
                        fats: Number(checkbox.dataset.menuFats || 0),
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

            const groupEditToggleButtons = document.querySelectorAll('[data-toggle-group-edit]');
            groupEditToggleButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const groupId = button.getAttribute('data-toggle-group-edit');
                    const panel = document.querySelector(`[data-group-edit-panel="${groupId}"]`);

                    if (panel) {
                        panel.classList.toggle('hidden');
                    }
                });
            });

            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', updateSelectedMenusTotal);
            });

            updateSelectedMenusTotal();
        });
    </script>
</x-app-layout>
