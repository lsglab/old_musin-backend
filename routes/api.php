<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\EntryPermissionController;

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

Route::post('auth/login',[AuthController::class,'authenticate']);
Route::get('auth/logout',[AuthController::class,'logout']);
Route::get('auth/user',[AuthController::class,'getAuthenticatedUser']);

Route::group(['middleware' => ['permission']],function(){
    $verbs = ['post','get','put','delete'];

    Route::match($verbs,'/users',[UserController::class,'handle']);
    Route::match($verbs,'/roles',[RoleController::class,'handle']);
    Route::match($verbs,'/permissions',[PermissionController::class,'handle']);
    Route::match($verbs,'/entry_permissions',[EntryPermissionController::class,'handle']);
});

Route::get('tables',function(){
    $controller = new TableController();
    return $controller->handleRead();
});


