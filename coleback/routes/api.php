<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/login',[\App\Http\Controllers\UserController::class,'login']);
Route::post('/register',[\App\Http\Controllers\UserController::class,'register']);
Route::resource('/unit',\App\Http\Controllers\UnitController::class);
Route::get('/boleta/{id}',[\App\Http\Controllers\EstudianteController::class,'boleta']);

Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::post('/logout',[\App\Http\Controllers\UserController::class,'logout']);
    Route::post('/me',[\App\Http\Controllers\UserController::class,'me']);
    Route::put('/pass/{user}',[\App\Http\Controllers\UserController::class,'pass']);
    Route::put('/updatepermisos/{user}',[\App\Http\Controllers\UserController::class,'updatepermisos']);
    Route::resource('/user',\App\Http\Controllers\UserController::class);
    Route::resource('/asignacion',\App\Http\Controllers\AsignacionController::class);
    Route::post('/misremetentes',[\App\Http\Controllers\UserController::class,'misremetentes']);
    Route::post('/usuarios',[\App\Http\Controllers\UserController::class,'usuarios']);
    Route::post('/listprofesor',[\App\Http\Controllers\UserController::class,'listprofesor']);
    Route::resource('/permiso',\App\Http\Controllers\PermisoController::class);

    Route::resource('/estudiante',\App\Http\Controllers\EstudianteController::class);
    Route::post('/listado',[\App\Http\Controllers\EstudianteController::class,'listado']);
    Route::resource('/curso',\App\Http\Controllers\CursoController::class);
    Route::resource('/padre',\App\Http\Controllers\PadreController::class);
    Route::resource('/materia',\App\Http\Controllers\MateriaController::class);
    Route::resource('/grupo',\App\Http\Controllers\GrupoController::class);
    Route::resource('/libro',\App\Http\Controllers\LibroController::class);
    Route::resource('/periodo',\App\Http\Controllers\PeriodoController::class);
    Route::post('/uparchivo',[\App\Http\Controllers\LibroController::class,'uparchivo']);
    Route::post('/upimagen',[\App\Http\Controllers\LibroController::class,'upimagen']);
});

