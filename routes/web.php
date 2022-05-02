<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\ClientesController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/clientes', [App\Http\Controllers\ClientesController::class, 'index'] )->name('clientes.index');
Route::get('/clientes/crear', [App\Http\Controllers\ClientesController::class, 'crearCliente'] )->name('clientes.crear');
Route::post('/clientes/guardar', [App\Http\Controllers\ClientesController::class, 'guardarCliente'])->name('clientes.guardar');
Route::get('/clientes/listar', [App\Http\Controllers\ClientesController::class, 'listar'] )->name('clientes.listar');
Route::delete('/clientes/eliminar/{id}', [App\Http\Controllers\ClientesController::class, 'eliminarCliente'])->name('clientes.eliminar');
Route::get('/clientes/editar/{id}', [App\Http\Controllers\ClientesController::class, 'editarCliente'] )->name('clientes.editar');
