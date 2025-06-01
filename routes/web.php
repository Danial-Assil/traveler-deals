<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Dash\TestController;
use App\Http\Controllers\FileController;
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

Route::get('/test', [TestController::class, 'test']);

Route::get('/storage/{folder}/{id}/{file_name}', [FileController::class, 'getFile'])->name('storage.file');
//Route::get('/storage/users/{id}/{type}/{file_name}', [UserController::class, 'getFile'])->name('users.file');
