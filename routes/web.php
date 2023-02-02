<?php

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

use App\Http\Controllers\DashController;

Route::get('/', [DashController::class, 'index']);
Route::get('/pedidos/cadastrar', [DashController::class, 'create']);
Route::get('/pedidos/fechar', [DashController::class, 'show']);
Route::get('/pedidos', [DashController::class, 'list']);
Route::get('/pedidos/mapa', [DashController::class, 'map']);

Route::post('/cadastrar',  [DashController::class, 'store']);
Route::post('/fechar', [DashController::class, 'close']);
Route::post('/pedidos', [DashController::class, 'search']);
Route::post('/pedidos/mapa', [DashController::class, 'mapfilter']);

