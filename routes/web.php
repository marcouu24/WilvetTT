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
        return view('panel');
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {

Route::get('/usuarios', [App\Http\Controllers\UsuariosController::class, 'index'] )->name('usuarios.index');
Route::get('/usuarios/crear', [App\Http\Controllers\UsuariosController::class, 'crearUsuario'] )->name('usuarios.crear');
Route::post('/usuarios/guardar', [App\Http\Controllers\UsuariosController::class, 'guardarUsuario'])->name('usuarios.guardar');
Route::get('/usuarios/listar', [App\Http\Controllers\UsuariosController::class, 'listar'] )->name('usuarios.listar');
Route::get('/usuarios/editar/{id}', [App\Http\Controllers\UsuariosController::class, 'editarUsuario'] )->name('usuarios.editar');
Route::delete('/usuarios/eliminar/{id}', [App\Http\Controllers\UsuariosController::class, 'eliminarUsuario'])->name('usuarios.eliminar');



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


Route::get('/productos', [App\Http\Controllers\ProductosController::class, 'index'] )->name('productos.index');
Route::get('/productos/listar', [App\Http\Controllers\ProductosController::class, 'listar'] )->name('productos.listar');
Route::get('/productos/crear', [App\Http\Controllers\ProductosController::class, 'crearProducto'] )->name('productos.crear');
Route::post('/productos/guardar', [App\Http\Controllers\ProductosController::class, 'guardarProducto'])->name('productos.guardar');
Route::get('/productos/editar/{id}', [App\Http\Controllers\ProductosController::class, 'editarProducto'] )->name('productos.editar');
Route::delete('/productos/eliminar/{id}', [App\Http\Controllers\ProductosController::class, 'eliminarProducto'])->name('productos.eliminar');
Route::post('/productos/reportePDF', [App\Http\Controllers\ProductosController::class, 'reportePDF'] )->name('productos.reportePDF');


Route::get('/compras', [App\Http\Controllers\ComprasController::class, 'index'] )->name('compras.index');
Route::get('/compras/listar', [App\Http\Controllers\ComprasController::class, 'listar'] )->name('compras.listar');
Route::get('/compras/crear', [App\Http\Controllers\ComprasController::class, 'crearCompra'] )->name('compras.crear');
Route::post('/compras/guardar', [App\Http\Controllers\ComprasController::class, 'guardarCompra'])->name('compras.guardar');
Route::get('/compras/editar/{id}', [App\Http\Controllers\ComprasController::class, 'editarCompra'] )->name('compras.editar');
Route::delete('/compras/eliminar/{id}', [App\Http\Controllers\ComprasController::class, 'eliminarCompra'])->name('compras.eliminar');
Route::get('/compras/pdf/{id}', [App\Http\Controllers\ComprasController::class, 'reportePDF'])->name('compras.reportePDF');


Route::get('/ventas', [App\Http\Controllers\VentasController::class, 'index'] )->name('ventas.index');
Route::get('/ventas/listar', [App\Http\Controllers\VentasController::class, 'listar'] )->name('ventas.listar');
Route::get('/ventas/crear', [App\Http\Controllers\VentasController::class, 'crearVenta'] )->name('ventas.crear');
Route::post('/ventas/guardar', [App\Http\Controllers\VentasController::class, 'guardarVenta'])->name('ventas.guardar');
Route::get('/ventas/editar/{id}', [App\Http\Controllers\VentasController::class, 'editarVenta'] )->name('ventas.editar');
Route::delete('/ventas/eliminar/{id}', [App\Http\Controllers\VentasController::class, 'eliminarVenta'])->name('ventas.eliminar');
Route::get('/ventas/getStockProducto/{id}', [App\Http\Controllers\VentasController::class, 'obtenerStockProducto'])->name('obtenerStockProducto');
Route::get('/ventas/pdf/{id}', [App\Http\Controllers\VentasController::class, 'reportePDF'])->name('ventas.reportePDF');


Route::get('/ajustes', [App\Http\Controllers\AjustesController::class, 'index'] )->name('ajustes.index');
Route::get('/ajustes/listar', [App\Http\Controllers\AjustesController::class, 'listar'] )->name('ajustes.listar');
Route::get('/ajustes/crear', [App\Http\Controllers\AjustesController::class, 'crearAjuste'] )->name('ajustes.crear');
Route::post('/ajustes/guardar', [App\Http\Controllers\AjustesController::class, 'guardarAjuste'])->name('ajustes.guardar');


Route::get('/panel', [App\Http\Controllers\PanelController::class, 'index'] )->name('panel');
});