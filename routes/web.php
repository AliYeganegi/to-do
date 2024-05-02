<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('Auth.login');
});


Route::resource('/users', UserController::class);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', function () {
    return view('Auth.login');
});
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('/tasks', TaskController::class);
Route::post('/changeStatus/{task}', [TaskController::class, 'changeStatus'])->name('changeStatus');

Route::get('/dashboard', function(){
    return view('dashboard', ['tasks' => Auth::user()->tasks]);
})->name('dashboard');