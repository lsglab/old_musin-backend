<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\PermissionController;
use App\Models\Subject;
use App\Http\Controllers\DatabaseController;

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

Route::post('login',[AuthController::class,'authenticate']);

Route::group(['middleware' => ['jwt.verify']],function(){
    $verbs = ['post','get','put','delete'];

    Route::match($verbs,'/user',[UserController::class,'handle']);

    Route::match($verbs,'/roles',[RoleController::class,'handle']);

    Route::match($verbs,'subjects',[SubjectController::class,'handle']);
});


