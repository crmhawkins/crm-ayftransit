<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getClients', [ApiController::class, 'getClients']);

Route::get('/getPresupuesto', [ApiController::class, 'getPresupuesto']);

Route::get('/getUsuarios', [ApiController::class, 'getUsuarios']);

Route::get('/getServicios', [ApiController::class, 'getServicios']);

Route::get('/getArticulos', [ApiController::class, 'getArticulos']);

Route::get('/getContratos', [ApiController::class, 'getContratos']);

Route::get('/getEventos', [ApiController::class, 'getEventos']);

Route::get('/getGastos', [ApiController::class, 'getGastos']);


