<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PusherAuthController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


// admin routes
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('', [AdminController::class, 'index'])->name('admin');
    Route::post('store', [AdminController::class, 'store'])->name('store');
    Route::delete('/delete/{id}', [AdminController::class, 'destroy']);
    Route::put('/update/{id}', [AdminController::class, 'update'])->name('update');
    Route::post('/private-notification', [AdminController::class, 'privateNotification']);
});

