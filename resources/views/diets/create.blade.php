<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Nueva Dieta</h2>

                <form action="{{ route('diets.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                        <input type="text" name="name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500">
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                        <textarea name="description" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4">Datos para calcular objetivo</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Peso (kg)</label>
                                <input type="number" step="0.1" name="weight" id="diet_weight" class="w-full border rounded px-2 py-1 text-sm" placeholder="70">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Altura (cm)</label>
                                <input type="number" step="0.1" name="height" id="diet_height" class="w-full border rounded px-2 py-1 text-sm" placeholder="175">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Edad</label>
                                <input type="number" name="age" id="diet_age" class="w-full border rounded px-2 py-1 text-sm" placeholder="30">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Género</label>
                                <select name="gender" id="diet_gender" class="w-full border rounded px-2 py-1 text-sm">
                                    <option value="">Seleccionar</option>
                                    <option value="male">Masculino</option>
                                    <option value="female">Femenino</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Nivel de actividad</label>
                                <select name="activity_level" id="diet_activity" class="w-full border rounded px-2 py-1 text-sm">
                                    <option value="">Seleccionar</option>
                                    <option value="1.2">Sedentario (sin ejercicio)</option>
                                    <option value="1.375">Ligero (1-3 días/semana)</option>
                                    <option value="1.55">Moderado (3-5 días/semana)</option>
                                    <option value="1.725">Activo (6-7 días/semana)</option>
                                    <option value="1.9">Muy activo (ejercicio intenso)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Objetivo</label>
                                <select name="goal" id="diet_goal" class="w-full border rounded px-2 py-1 text-sm">
                                    <option value="">Seleccionar</option>
                                    <option value="deficit">Déficit (-500 kcal) → Perder peso</option>
                                    <option value="maintenance">Mantenimiento → Mantener peso</option>
                                    <option value="volume">Volumen (+500 kcal) → Ganar músculo</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="button" onclick="calculateTarget()" class="w-full bg-blue-600 text-white py-1 px-3 rounded text-sm hover:bg-blue-700">
                                    Calcular Objetivo
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="target_result" class="hidden mb-6 p-4 bg-green-50 rounded-lg border border-green-200">
                        <h3 class="text-lg font-semibold text-green-900 mb-2">Tu Objetivo Diario</h3>
                        <div class="grid grid-cols-4 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600" id="target_kcal">-</div>
                                <div class="text-xs text-gray-600">Kcal</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-red-500" id="target_protein">-</div>
                                <div class="text-xs text-gray-600">Proteína (30%)</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-yellow-500" id="target_carbs">-</div>
                                <div class="text-xs text-gray-600">Carbs (40%)</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-500" id="target_fats">-</div>
                                <div class="text-xs text-gray-600">Grasas (30%)</div>
                            </div>
                        </div>
                        <input type="hidden" name="target_calories" id="input_target_calories">
                        <input type="hidden" name="target_protein" id="input_target_protein">
                        <input type="hidden" name="target_carbs" id="input_target_carbs">
                        <input type="hidden" name="target_fats" id="input_target_fats">
                    </div>

                    <div class="mb-6">
    <label class="block text-gray-700 text-sm font-bold mb-4">Ingredientes disponibles:</label>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        @forelse($ingredients as $ingredient)
            <label class="flex items-start p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200 group">
                <input type="checkbox" name="ingredients[]" value="{{ $ingredient->name }}" class="mt-1 h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                
                <div class="ml-4 w-full">
                    <span class="block text-sm font-bold text-gray-900 group-hover:text-indigo-900">{{ $ingredient->name }}</span>
                    
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span class="px-2 py-0.5 rounded-md bg-orange-100 text-orange-700 text-[10px] font-bold uppercase tracking-wider">{{ $ingredient->kcal }} kcal</span>
                        <span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-700 text-[10px] font-bold uppercase tracking-wider">P: {{ $ingredient->protein }}g</span>
                        <span class="px-2 py-0.5 rounded-md bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider">C: {{ $ingredient->carbs }}g</span>
                        <span class="px-2 py-0.5 rounded-md bg-yellow-100 text-yellow-700 text-[10px] font-bold uppercase tracking-wider">G: {{ $ingredient->fats }}g</span>
                    </div>
                </div>
            </label>
        @empty
            <p class="text-gray-500 text-sm">No hay ingredientes creados.</p>
        @endforelse
    </div>
</div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200">
                        <button type="submit" class="appearance-none bg-gray-900 hover:bg-black text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-200" style="appearance: none; -webkit-appearance: none; background-color: #111827; border: none;">
    Guardar Dieta
</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function calculateTarget() {
    const weight = parseFloat(document.getElementById('diet_weight').value);
    const height = parseFloat(document.getElementById('diet_height').value);
    const age = parseInt(document.getElementById('diet_age').value);
    const gender = document.getElementById('diet_gender').value;
    const activity = parseFloat(document.getElementById('diet_activity').value);
    const goal = document.getElementById('diet_goal').value;

    if (!weight || !height || !age || !gender || !activity || !goal) {
        alert('Por favor, completa todos los campos');
        return;
    }

    let tmb;
    if (gender === 'male') {
        tmb = 10 * weight + 6.25 * height - 5 * age + 5;
    } else {
        tmb = 10 * weight + 6.25 * height - 5 * age - 161;
    }

    let maintenance = tmb * activity;
    let targetKcal;

    if (goal === 'deficit') {
        targetKcal = maintenance - 500;
    } else if (goal === 'volume') {
        targetKcal = maintenance + 500;
    } else {
        targetKcal = maintenance;
    }

    const protein = Math.round(targetKcal * 0.3 / 4);
    const carbs = Math.round(targetKcal * 0.4);
    const fats = Math.round(targetKcal * 0.3 / 9);

    document.getElementById('target_kcal').textContent = Math.round(targetKcal);
    document.getElementById('target_protein').textContent = protein + 'g';
    document.getElementById('target_carbs').textContent = carbs + 'g';
    document.getElementById('target_fats').textContent = fats + 'g';

    document.getElementById('input_target_calories').value = Math.round(targetKcal);
    document.getElementById('input_target_protein').value = protein;
    document.getElementById('input_target_carbs').value = carbs;
    document.getElementById('input_target_fats').value = fats;

    document.getElementById('target_result').classList.remove('hidden');
}
</script>