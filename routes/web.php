<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Hash;
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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


// view login 
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login/proses', [AuthController::class, 'proses'])->name('login');

Route::middleware(['auth'])->group(function() {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kategori', KategoriController::class);
    Route::resource('menu', MenuController::class);
    
    Route::get('menu/ingredient/{id}', [MenuController::class, 'ingredient'])->name('ingredient');
    Route::post('menu/ingredient/{id}', [MenuController::class, 'ingredient_store'])->name('ingredient');
    Route::post('menu/ingredient/update/{id_menu}/{id}', [MenuController::class, 'ingredient_update']);
    Route::post('menu/ingredient/delete/{id_menu}/{id}', [MenuController::class, 'ingredient_delete']);


    // logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});