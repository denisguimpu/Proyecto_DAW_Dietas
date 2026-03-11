<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\DietController; // Importación añadida

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rutas de Ingredientes
Route::get('/ingredients', [IngredientController::class, 'index'])->name('ingredients.index');
Route::post('/ingredients', [IngredientController::class, 'store'])->name('ingredients.store');
Route::get('/ingredients/{ingredient}/edit', [IngredientController::class, 'edit'])->name('ingredients.edit');
Route::put('/ingredients/{ingredient}', [IngredientController::class, 'update'])->name('ingredients.update');
Route::delete('/ingredients/{ingredient}', [IngredientController::class, 'destroy'])->name('ingredients.destroy');

// Rutas de Dietas (Ordenadas: Index -> Create -> Store -> Show)
Route::get('/diets', [DietController::class, 'index'])->name('diets.index'); // Ruta añadida para arreglar el error
Route::get('/diets/create', [DietController::class, 'create'])->name('diets.create');
Route::post('/diets', [DietController::class, 'store'])->name('diets.store');
Route::get('/diets/{id}', [DietController::class, 'show'])->name('diets.show'); 
Route::delete('/diets/{id}', [DietController::class, 'destroy'])->name('diets.destroy');

// Rutas por defecto de Laravel
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de Perfil (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';