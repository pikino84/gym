<?php

use App\Models\EstadosDeCuenta;
use App\Models\ProveedoresCompac;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Support\Facades\Route;

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
    //return response()->json(['stuff' => phpinfo()]);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');

    
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');


    Route::get('/users/{user}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.delete');
    Route::get('proveedores-compac', [App\Http\Controllers\ProveedoresCompacController::class, 'getProveedoresCompac'])->name('proveedores-compac');
    Route::resource('posts', App\Http\Controllers\PostController::class);
    Route::resource('deudas', App\Http\Controllers\DeudasController::class);

    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);

    Route::resource('estados-de-cuenta', App\Http\Controllers\EstadosDeCuentaController::class);

    
                                      
});