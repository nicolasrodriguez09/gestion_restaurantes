<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MesaController as AdminMesaController;
use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\cafeagregar;
use App\Http\Controllers\Mesero\MeseroController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'mesero' => redirect()->route('mesero.dashboard'),
        default => view('dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('mesas', AdminMesaController::class)->except(['show']);
    Route::resource('productos', AdminProductoController::class)->except(['show']);
    Route::resource('meseros', \App\Http\Controllers\Admin\MeseroGestionController::class);
    Route::get('cocina', [\App\Http\Controllers\Admin\CocinaController::class, 'index'])->name('cocina.index');
    Route::post('cocina/pedidos/{pedido}/estado', [\App\Http\Controllers\Admin\CocinaController::class, 'cambiarEstado'])->name('cocina.pedidos.estado');
});

// ----------------- RUTAS PARA MESERO -----------------
Route::middleware(['auth', 'role:mesero'])->prefix('mesero')->name('mesero.')->group(function () {
    Route::get('dashboard', [MeseroController::class, 'index'])->name('dashboard');
    Route::get('mesa/{id}', [MeseroController::class, 'show'])->name('mesa.show');

    // pantalla de armar pedido
    Route::get('mesa/{id}/pedido/nuevo', [MeseroController::class, 'crearPedido'])->name('pedido.nuevo');

    
    Route::post('mesa/{id}/pedido/agregar', [MeseroController::class, 'agregarProducto'])->name('pedido.agregar');
    Route::post('mesa/{id}/pedido/detalle/{detalle}/actualizar', [MeseroController::class, 'actualizarDetalle'])->name('pedido.detalle.actualizar');
    Route::post('mesa/{id}/pedido/cancelar', [MeseroController::class, 'cancelarPedido'])->name('pedido.cancelar');
    Route::post('mesa/{id}/pedido/cerrar', [MeseroController::class, 'cerrarPedido'])->name('pedido.cerrar');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__.'/auth.php';
