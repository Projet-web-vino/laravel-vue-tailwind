<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SAQController;
use App\Http\Controllers\BouteilleController;
use App\Http\Controllers\AuthController;

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

// Route::get('/', function () {
//     return true;
// });

// Route::get('/users', function () {
//     $users = \App\Models\User::all();
//     return $users;
// });

// Auth::routes();

// Catch-all route
Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');





