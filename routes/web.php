<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\cafeagregar;
use App\Http\Controllers\Mesero\MeseroController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
});

// ----------------- RUTAS PARA MESERO -----------------
Route::middleware(['auth', 'role:mesero'])->prefix('mesero')->name('mesero.')->group(function () {
    Route::get('dashboard', [MeseroController::class, 'index'])->name('dashboard');
    Route::get('mesa/{id}', [MeseroController::class, 'show'])->name('mesa.show');

    // pantalla de armar pedido
    Route::get('mesa/{id}/pedido/nuevo', [MeseroController::class, 'crearPedido'])->name('pedido.nuevo');

    
    Route::post('mesa/{id}/pedido/agregar', [MeseroController::class, 'agregarProducto'])->name('pedido.agregar');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/cafecomprar', [cafeagregar::class, 'comprar'])->name('cafe.comprar');

require __DIR__.'/auth.php';
