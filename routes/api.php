<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categoria', 'App\Http\Controllers\CategoriaController@index');
Route::post('/categoria', 'App\Http\Controllers\CategoriaController@store');
Route::put('/categoria/{id}', 'App\Http\Controllers\CategoriaController@update');
Route::delete('/categoria/{id}', 'App\Http\Controllers\CategoriaController@destroy');


Route::get('/producto', 'App\Http\Controllers\ProductoController@index');
Route::get('/producto/{id}', 'App\Http\Controllers\ProductoController@show');
Route::post('/producto/create', 'App\Http\Controllers\ProductoController@store');
Route::put('/producto/update/{id}', 'App\Http\Controllers\ProductoController@update');
Route::delete('/producto/delete/{id}', 'App\Http\Controllers\ProductoController@destroy');

//Rutas para el Login
Route::post('registrar',[AuthController::class, 'registrar']);
Route::post('login',[AuthController::class, 'login']);

//Rutas protegidas por Sanctum
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('logout',[AuthController::class, 'logout']);
});


