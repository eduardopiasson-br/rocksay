<?php

use App\Http\Controllers\Admin\UserController;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'App\Http\Controllers\Admin\HomeController@index')->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    // Rotas de usuários
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');
    Route::post('/usuarios/cadastro', [UserController::class, 'store'])->name('usuarios.cadastro');
    Route::get('/usuarios/edicao/{id}', [UserController::class, 'edit'])->name('usuarios.edicao');
    Route::put('/usuarios/atualizacao', [UserController::class, 'update'])->name('usuarios.atualizacao');
    Route::get('/usuarios/alternar/{id}', [UserController::class, 'toggle'])->name('usuarios.alternar');
    Route::get('/usuarios/deletar/{id}', [UserController::class, 'destroy'])->name('usuarios.deletar');
});
