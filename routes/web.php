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
    return view('auth.login');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('tablero');
    })->name('dashboard');
});


Route::get('/clientes', [App\Http\Controllers\ClientesController::class, 'index'] )->name('clientes.index');
Route::get('/clientes/crear', [App\Http\Controllers\ClientesController::class, 'crearCliente'] )->name('clientes.crear');
Route::post('/clientes/guardar', [App\Http\Controllers\ClientesController::class, 'guardarCliente'])->name('clientes.guardar');
Route::get('/clientes/listar', [App\Http\Controllers\ClientesController::class, 'listar'] )->name('clientes.listar');
Route::delete('/clientes/eliminar/{id}', [App\Http\Controllers\ClientesController::class, 'eliminarCliente'])->name('clientes.eliminar');
Route::get('/clientes/editar/{id}', [App\Http\Controllers\ClientesController::class, 'editarCliente'] )->name('clientes.editar');


Route::get('/proveedores', [App\Http\Controllers\ProveedoresController::class, 'index'] )->name('proveedores.index');
Route::get('/proveedores/listar', [App\Http\Controllers\ProveedoresController::class, 'listar'] )->name('proveedores.listar');
Route::get('/proveedores/crear', [App\Http\Controllers\ProveedoresController::class, 'crearProveedor'] )->name('proveedores.crear');
Route::post('/proveedores/guardar', [App\Http\Controllers\ProveedoresController::class, 'guardarProveedor'])->name('proveedores.guardar');
Route::get('/proveedores/editar/{id}', [App\Http\Controllers\ProveedoresController::class, 'editarProveedor'] )->name('proveedores.editar');
Route::delete('/proveedores/eliminar/{id}', [App\Http\Controllers\ProveedoresController::class, 'eliminarProveedor'])->name('proveedores.eliminar');



Route::get('/categorias', [App\Http\Controllers\CategoriasController::class, 'index'] )->name('categorias.index');
Route::get('/categorias/listar', [App\Http\Controllers\CategoriasController::class, 'listar'] )->name('categorias.listar');
Route::get('/categorias/crear', [App\Http\Controllers\CategoriasController::class, 'crearCategoria'] )->name('categorias.crear');
Route::post('/categorias/guardar', [App\Http\Controllers\CategoriasController::class, 'guardarCategoria'])->name('categorias.guardar');
Route::get('/categorias/editar/{id}', [App\Http\Controllers\CategoriasController::class, 'editarCategoria'] )->name('categorias.editar');
Route::delete('/categorias/eliminar/{id}', [App\Http\Controllers\CategoriasController::class, 'eliminarCategoria'])->name('categorias.eliminar');



Route::get('/servicios', [App\Http\Controllers\ServiciosController::class, 'index'] )->name('servicios.index');
Route::get('/servicios/listar', [App\Http\Controllers\ServiciosController::class, 'listar'] )->name('servicios.listar');
Route::get('/servicios/crear', [App\Http\Controllers\ServiciosController::class, 'crearServicio'] )->name('servicios.crear');
Route::post('/servicios/guardar', [App\Http\Controllers\ServiciosController::class, 'guardarServicio'])->name('servicios.guardar');
Route::get('/servicios/editar/{id}', [App\Http\Controllers\ServiciosController::class, 'editarServicio'] )->name('servicios.editar');
Route::delete('/servicios/eliminar/{id}', [App\Http\Controllers\ServiciosController::class, 'eliminarServicio'])->name('servicios.eliminar');



Route::get('/tablero', [App\Http\Controllers\ClientesController::class, 'tablero'] )->name('tablero');
