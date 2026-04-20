<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl p-8">
                @php
$dayTranslations = [
    'monday' => 'Lunes',
    'tuesday' => 'Martes', 
    'wednesday' => 'Miércoles',
    'thursday' => 'Jueves',
    'friday' => 'Viernes',
    'saturday' => 'Sábado',
    'sunday' => 'Domingo'
];
$daySpanish = $dayTranslations[$mealPlan->day_of_week] ?? $mealPlan->day_of_week;
@endphp
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Editar Menú - {{ $daySpanish }}</h2>
                        <p class="text-gray-600">{{ $mealPlan->diet->name }}</p>
                    </div>
                    <a href="{{ route('meal-plans.index') }}" class="text-gray-600 hover:underline">← Volver</a>
                </div>

                <div id="totals-bar" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="text-sm mb-2">
                        <span class="font-bold">Objetivo diario:</span>
                        <span class="text-blue-600 font-bold">{{ $mealPlan->diet->target_calories ? round($mealPlan->diet->target_calories) : 0 }} kcal</span>
                        @if($mealPlan->diet->target_protein)
                        | P: {{ round($mealPlan->diet->target_protein) }}g |
                        C: {{ round($mealPlan->diet->target_carbs) }}g |
                        G: {{ round($mealPlan->diet->target_fats) }}g
                        @endif
                    </div>
                    <div class="grid grid-cols-4 gap-4 text-center">
                        <div>
                            <div class="text-xl font-bold" id="current_kcal">0</div>
                            <div class="text-xs text-gray-500">kcal</div>
                            <div class="text-xs" id="kcal_diff">/ {{ $mealPlan->diet->target_calories ? round($mealPlan->diet->target_calories) : 0 }}</div>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-red-500" id="current_protein">0g</div>
                            <div class="text-xs text-gray-500">Proteína</div>
                            <div class="text-xs text-gray-400">/ {{ $mealPlan->diet->target_protein ? round($mealPlan->diet->target_protein) : 0 }}g</div>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-yellow-500" id="current_carbs">0g</div>
                            <div class="text-xs text-gray-500">Carbs</div>
                            <div class="text-xs text-gray-400">/ {{ $mealPlan->diet->target_carbs ? round($mealPlan->diet->target_carbs) : 0 }}g</div>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-green-500" id="current_fats">0g</div>
                            <div class="text-xs text-gray-500">Grasas</div>
                            <div class="text-xs text-gray-400">/ {{ $mealPlan->diet->target_fats ? round($mealPlan->diet->target_fats) : 0 }}g</div>
                        </div>
                    </div>
                    <div class="mt-3 bg-gray-200 rounded-full h-3 overflow-hidden">
                        <div id="kcal_bar" class="bg-blue-500 h-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>

                <form action="{{ route('meal-plans.update', $mealPlan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @foreach($mealTypes as $mealType)
                    <div class="mb-8 p-4 border rounded-lg">
                        <h3 class="text-lg font-semibold mb-4 capitalize">{{ $mealType }}</h3>
                        
                        <div class="space-y-3" id="meal_{{ $mealType }}">
                            @php
                                $existingMeals = $mealPlan->meals->where('meal_type', $mealType);
                            @endphp
                            
                            @foreach($existingMeals as $index => $meal)
                            <div class="flex gap-3 items-center meal-row">
                                <select name="meals[{{ $mealType }}][{{ $index }}][ingredient_name]" class="flex-1 border rounded px-3 py-2 text-sm ingredient-select" data-index="{{ $index }}">
                                    <option value="">Selecciona ingrediente</option>
                                    @foreach($mealPlan->diet->ingredients as $ingredient)
                                    <option value="{{ $ingredient->name }}" data-cal="{{ $ingredient->kcal }}" data-prot="{{ $ingredient->protein }}" data-carbs="{{ $ingredient->carbs }}" data-fats="{{ $ingredient->fats }}" {{ $meal->ingredient_name == $ingredient->name ? 'selected' : '' }}>
                                        {{ $ingredient->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <input type="number" name="meals[{{ $mealType }}][{{ $index }}][quantity]" value="{{ $meal->quantity }}" placeholder="g" class="w-24 border rounded px-3 py-2 text-sm quantity-input" min="0">
                                <span class="text-sm text-gray-500">g</span>
                                <span class="text-xs text-gray-400 row-kcal ml-2">{{ $meal->quantity > 0 && $meal->ingredient ? round($meal->quantity * $meal->ingredient->kcal / 100) : 0 }} kcal</span>
                                <button type="button" class="text-red-600 hover:text-red-800" onclick="this.parentElement.remove(); calculateTotals();">✕</button>
                            </div>
                            @endforeach
                            
                            @for($i = $existingMeals->count(); $i < 5; $i++)
                            <div class="flex gap-3 items-center meal-row">
                                <select name="meals[{{ $mealType }}][{{ $i }}][ingredient_name]" class="flex-1 border rounded px-3 py-2 text-sm ingredient-select" data-index="{{ $i }}">
                                    <option value="">Selecciona ingrediente</option>
                                    @foreach($mealPlan->diet->ingredients as $ingredient)
                                    <option value="{{ $ingredient->name }}" data-cal="{{ $ingredient->kcal }}" data-prot="{{ $ingredient->protein }}" data-carbs="{{ $ingredient->carbs }}" data-fats="{{ $ingredient->fats }}">
                                        {{ $ingredient->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <input type="number" name="meals[{{ $mealType }}][{{ $i }}][quantity]" value="" placeholder="g" class="w-24 border rounded px-3 py-2 text-sm quantity-input" min="0">
                                <span class="text-sm text-gray-500">g</span>
                                <span class="text-xs text-gray-400 row-kcal ml-2">0 kcal</span>
                                <button type="button" class="text-red-600 hover:text-red-800" onclick="this.parentElement.remove(); calculateTotals();">✕</button>
                            </div>
                            @endfor
                        </div>
                        
                        <button type="button" class="mt-3 text-sm text-blue-600 hover:underline" onclick="addMealRow('{{ $mealType }}')">
                            + Añadir ingrediente
                        </button>
                    </div>
                    @endforeach

                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Guardar Menú
                        </button>
                        <a href="{{ route('meal-plans.index') }}" class="px-6 py-2 border rounded hover:bg-gray-50">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
let counters = {desayuno: 5, comida: 5, merienda: 5, cena: 5};
const targetKcal = {{ $mealPlan->diet->target_calories ?? 0 }};
const ingredientsList = @json($ingredientsData);

function calculateTotals() {
    let totalCal = 0, totalProt = 0, totalCarbs = 0, totalFats = 0;
    
    document.querySelectorAll('.meal-row').forEach(row => {
        const select = row.querySelector('.ingredient-select');
        const input = row.querySelector('.quantity-input');
        const kcalSpan = row.querySelector('.row-kcal');
        
        if (select && input && select.value && input.value > 0) {
            const option = select.options[select.selectedIndex];
            const cal = parseFloat(option.dataset.cal) || 0;
            const prot = parseFloat(option.dataset.prot) || 0;
            const carbs = parseFloat(option.dataset.carbs) || 0;
            const fats = parseFloat(option.dataset.fats) || 0;
            const qty = parseFloat(input.value) || 0;
            
            const rowCal = qty * cal / 100;
            totalCal += rowCal;
            totalProt += qty * prot / 100;
            totalCarbs += qty * carbs / 100;
            totalFats += qty * fats / 100;
            
            if (kcalSpan) {
                kcalSpan.textContent = Math.round(rowCal) + ' kcal';
            }
        } else if (kcalSpan) {
            kcalSpan.textContent = '0 kcal';
        }
    });
    
    document.getElementById('current_kcal').textContent = Math.round(totalCal);
    document.getElementById('current_protein').textContent = Math.round(totalProt) + 'g';
    document.getElementById('current_carbs').textContent = Math.round(totalCarbs) + 'g';
    document.getElementById('current_fats').textContent = Math.round(totalFats) + 'g';
    
    const pct = targetKcal > 0 ? (totalCal / targetKcal) * 100 : 0;
    document.getElementById('kcal_bar').style.width = Math.min(pct, 100) + '%';
    
    if (pct > 100) {
        document.getElementById('kcal_bar').classList.remove('bg-blue-500');
        document.getElementById('kcal_bar').classList.add('bg-red-500');
    } else {
        document.getElementById('kcal_bar').classList.remove('bg-red-500');
        document.getElementById('kcal_bar').classList.add('bg-blue-500');
    }
    
    document.getElementById('kcal_diff').textContent = '/ ' + targetKcal;
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.ingredient-select, .quantity-input').forEach(el => {
        el.addEventListener('change', calculateTotals);
        el.addEventListener('input', calculateTotals);
    });
    calculateTotals();
});

function addMealRow(mealType) {
    const container = document.getElementById('meal_' + mealType);
    const index = counters[mealType]++;
    
    const div = document.createElement('div');
    div.className = 'flex gap-3 items-center meal-row';
    div.innerHTML = `
        <select name="meals[${mealType}][${index}][ingredient_name]" class="flex-1 border rounded px-3 py-2 text-sm ingredient-select" data-index="${index}">
            <option value="">Selecciona ingrediente</option>
            ${ingredientsList.map(i => `<option value="${i.name}" data-cal="${i.cal}" data-prot="${i.prot}" data-carbs="${i.carbs}" data-fats="${i.fats}">${i.name}</option>`).join('')}
        </select>
        <input type="number" name="meals[${mealType}][${index}][quantity]" value="" placeholder="g" class="w-24 border rounded px-3 py-2 text-sm quantity-input" min="0">
        <span class="text-sm text-gray-500">g</span>
        <span class="text-xs text-gray-400 row-kcal ml-2">0 kcal</span>
        <button type="button" class="text-red-600 hover:text-red-800" onclick="this.parentElement.remove(); calculateTotals();">✕</button>
    `;
    
    div.querySelector('.ingredient-select').addEventListener('change', calculateTotals);
    div.querySelector('.quantity-input').addEventListener('input', calculateTotals);
    
    container.appendChild(div);
}
</script>