<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogController;
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

// Login
Route::get('/login', [LogController::class,'loginView'])->name('login')->middleware('guest');
Route::post('/login', [LogController::class,'loginAuth']);

// Register
Route::get('/register', [LogController::class,'registerView'])->middleware('guest');
Route::post('/register', [LogController::class,'store']);

// Logout
Route::post('/logout', [LogController::class,'logout']);

// Just uncomment Routes below if you want separate log view with app view
// Auth::routes();


// Yeah You Right. this app just has 2 Main Routes. Happy to learn
Route::get('/', [HomeController::class,'getIndex'])->name('home')->middleware('auth');
Route::post('/', [HomeController::class,'postIndex'])->middleware('auth');





