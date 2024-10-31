<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'indexGet'])->name('image.home');

//-------

Route::get('/user/login', [App\Http\Controllers\UserController::class, 'loginGet'])->name('user.login');
Route::get('/user/registr', [App\Http\Controllers\UserController::class, 'registrGet'])->name('user.registr');

Route::get('/user/exit', [App\Http\Controllers\UserController::class, 'exit'])->name('user.exit');

Route::post('/user/login', [App\Http\Controllers\UserController::class, 'loginPost'])->name('user.login');
Route::post('/user/registr', [App\Http\Controllers\UserController::class, 'registrPost'])->name('user.registr');

//-------

Route::get('/image', [App\Http\Controllers\ImageController::class, 'indexGet'])->name('image.index');
Route::get('/image/addImage', [App\Http\Controllers\ImageController::class, 'addImageGet'])->name('image.addImage');
Route::get('/image/oneImage/{id}', [App\Http\Controllers\ImageController::class, 'oneImageGet'])->name('image.oneImage');
Route::get('/image/myImage', [App\Http\Controllers\ImageController::class, 'myImageGet'])->name('image.myImage');
Route::get('/image/likeImage', [App\Http\Controllers\ImageController::class, 'likeImageGet'])->name('image.likeImage');

Route::post('/image', [App\Http\Controllers\ImageController::class, 'indexPost'])->name('image.index');
Route::post('/image/addImage', [App\Http\Controllers\ImageController::class, 'addImagePost'])->name('image.addImage');
Route::post('/image/oneImage', [App\Http\Controllers\ImageController::class, 'oneImagePost'])->name('image.oneImage');
Route::post('/image/myImage', [App\Http\Controllers\ImageController::class, 'myImagePost'])->name('image.myImage');
Route::post('/image/likeImage', [App\Http\Controllers\ImageController::class, 'likeImagePost'])->name('image.likeImage');

//

Route::get('/aikey', [App\Http\Controllers\AiKeyController::class, 'addAiKeyGet'])->name('aikey.addAiKey');

Route::post('/aikey', [App\Http\Controllers\AiKeyController::class, 'addAiKeyPost'])->name('aikey.addAiKey');