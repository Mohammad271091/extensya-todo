<?php

use App\Http\Controllers\ApiController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [ApiController::class, 'login']);

Route::prefix('tasks')->middleware('auth:sanctum')->group(function () {
    Route::get('', [ApiController::class, 'tasks']);
    Route::post('/create', [ApiController::class, 'createTask']);
    Route::delete('/delete/{taskId}', [ApiController::class, 'deleteTask']);
    Route::put('/update/{taskId}', [ApiController::class, 'updateTask']);
    Route::get('/view/{taskId}', [ApiController::class, 'viewTask']);
});
