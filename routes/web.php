<?php

use App\Http\Controllers\OfficeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('api', [OfficeController::class, 'api']);
Route::get('/', [OfficeController::class, 'index']);
// Route::get('/profile', [UserController::class, 'show'])->middleware('auth');
