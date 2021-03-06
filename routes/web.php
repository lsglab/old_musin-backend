<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthCookie;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Frontend\SiteController;

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


Route::group(['middleware' => [AuthCookie::class,'permission:files']],function(){
    $controller = new FileController();
    Route::get('/uploads/private/{fileName}',function($fileName) use ($controller){
        return $controller->getFile($fileName);
    });
    Route::get('/download/{fileName}',function($fileName) use ($controller){
        return $controller->downloadFile($fileName);
    });
});

Route::group(['middleware' => [AuthCookie::class,'permission:sites']],function(){
    Route::get("/pages/{filePath}",function($filePath){
        $controller = new SiteController();
        return $controller->getFileByUrl("/pages/{$filePath}");
    });
});


