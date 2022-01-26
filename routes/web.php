<?php

use App\Http\Controllers\ProductController;
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

Route::get('/import-form',[ProductController::class,'importForm']);
Route::post('/import',[ProductController::class,'import'])->name('products.import');
Route::get('/test',[ProductController::class,'test']);
Route::get('/upload',[ProductController::class,'downloadFromUrl']);
Route::get('/progress',[ProductController::class,'progress']);
Route::get('/progress/data',[ProductController::class,'imageDownloadingProgress'])->name('image-download-progress');
//Route::get('/batch',[ProductController::class,'batch']);
