<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl p-8">

                <div class="flex justify-between items-center mb-8 border-b pb-6">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900">Mis Dietas</h2>
                        <p class="text-gray-500 mt-1">Gestiona y consulta tus planes nutricionales.</p>
                    </div>
                    <a href="{{ route('diets.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl transition duration-200 shadow-md transform hover:scale-105">
                        + Nueva Dieta
                    </a>
                </div>

                <div class="overflow-hidden border border-gray-200 sm:rounded-xl">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Descripción</th>
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
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-500 font-medium">
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
</x-app-layout>
