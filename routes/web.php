<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SateliteController;
use App\Http\Controllers\FichaTecnicaController;
use App\Http\Controllers\AuthController; // <-- ASEGÚRATE DE QUE ESTA LÍNEA EXISTA
use App\Http\Controllers\OrdenPedidoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// --- RUTAS DE AUTENTICACIÓN ---
Route::middleware('guest')->group(function () {
    // La ruta de login está fuera para que nuestro código personalizado se ejecute
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- RUTA PRINCIPAL DENTRO DE LA APLICACIÓN ---
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::resource('satelites', SateliteController::class);
    Route::resource('fichas-tecnicas', FichaTecnicaController::class);

    Route::get('/ordenes-pedido', [OrdenPedidoController::class, 'index'])->name('ordenes-pedido.index');
    Route::get('/ordenes-pedido/create', [OrdenPedidoController::class, 'create'])->name('ordenes-pedido.create');
    Route::post('/ordenes-pedido', [OrdenPedidoController::class, 'store'])->name('ordenes-pedido.store');
    Route::get('/ordenes-pedido/{documento}', [OrdenPedidoController::class, 'show'])->name('ordenes-pedido.show');
    Route::get('/ordenes-pedido/{documento}/edit', [OrdenPedidoController::class, 'edit'])->name('ordenes-pedido.edit');
    Route::put('/ordenes-pedido/{documento}', [OrdenPedidoController::class, 'update'])->name('ordenes-pedido.update');
    Route::delete('/ordenes-pedido/{documento}', [OrdenPedidoController::class, 'destroy'])->name('ordenes-pedido.destroy');

    // AJAX
    Route::get('/ordenes-pedido/sucursales/{codcli}', [OrdenPedidoController::class, 'getSucursales'])->name('ordenes-pedido.sucursales');
    Route::get('/ordenes-pedido/producto/{codr}', [OrdenPedidoController::class, 'getProducto'])->name('ordenes-pedido.producto');
});