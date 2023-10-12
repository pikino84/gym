<?php

use App\Models\EstadosDeCuenta;
use App\Models\ProveedoresCompac;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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
if(env('APP_ENV') == 'production') {
    URL::forceScheme('https');
}
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
    
    Route::resource('posts', App\Http\Controllers\PostController::class);

    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);

    Route::resource('invoices', App\Http\Controllers\InvoiceController::class);
    Route::get('invoices/{id}/up_docs', [App\Http\Controllers\InvoiceController::class, 'upDocs'])->name('invoices.up_docs');
    Route::get('invoices/{id}/download', [App\Http\Controllers\InvoiceController::class, 'download'])->name('invoices.download');
    Route::post('invoices/{id}/approved', [App\Http\Controllers\InvoiceController::class, 'approved'])->name('invoices.approved');
    Route::post('invoices/refresh_invoices', [App\Http\Controllers\InvoiceController::class, 'refresh_invoices'])->name('invoices.refresh_invoices');
    Route::post('invoices/filters', [App\Http\Controllers\InvoiceController::class, 'filters'])->name('invoices.filters');
    Route::get('frutas',[App\Http\Controllers\FrutaController::class, 'index'])->name('frutas.index');
    
    Route::get('plantas',[App\Http\Controllers\PlantaController::class, 'index'])->name('plantas.index');
    Route::get('prestamos',[App\Http\Controllers\PrestamoController::class, 'index'])->name('prestamos.index');
    Route::get('regalias',[App\Http\Controllers\RegaliasController::class, 'index'])->name('regalias.index');
    Route::get('materiales',[App\Http\Controllers\MaterialController::class, 'index'])->name('materiales.index');
    //estas Rutas ya no se usaran revisar si se pueden reciclar los controladores
    Route::get('deudas',[App\Http\Controllers\DeudaController::class, 'index'])->name('deudas.index');
    Route::get('financiamientos',[App\Http\Controllers\FinanciamientoController::class, 'index'])->name('financiamientos.index');
    

    
    
    

    

    
                                      
});