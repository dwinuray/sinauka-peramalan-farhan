<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\BahanbakuController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MetodeController;
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
    return redirect('login');
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
Route::post('/login/proses', [AuthController::class, 'proses']);

Route::middleware(['auth'])->group(function() {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kategori', KategoriController::class);
    Route::resource('menu', MenuController::class);
    
    Route::get('menu/ingredient/{id}', [MenuController::class, 'ingredient'])->name('ingredient');
    Route::post('menu/ingredient/{id}', [MenuController::class, 'ingredient_store'])->name('ingredient');
    Route::post('menu/ingredient/update/{id_menu}/{id}', [MenuController::class, 'ingredient_update']);
    Route::post('menu/ingredient/delete/{id_menu}/{id}', [MenuController::class, 'ingredient_delete']);



    // bahan baku
    Route::resource('bahanbaku', BahanbakuController::class);


    Route::get('/transaksi/cetak', [TransaksiController::class, 'cetak_laporan']);
    Route::resource('transaksi', TransaksiController::class);


    Route::get('profile/info', [ProfileController::class, 'view_update_info']);
    Route::get('profile/password', [ProfileController::class, 'view_update_pw']);
    Route::post('profile/update-info', [ProfileController::class, 'update_info']);
    Route::post('profile/update-password', [ProfileController::class, 'update_password']);


    Route::resource('profile', ProfileController::class);

    // metode 
    Route::post("metode/ses/proses", [MetodeController::class, 'proses']);
    Route::get("metode/ses/detail/{id}", [MetodeController::class, 'detail']);
    Route::get("metode/ses/create", [MetodeController::class, 'view_tambah']);
    Route::get("metode/ses/delete/{id}", [MetodeController::class, 'delete']);
    Route::get("metode", [MetodeController::class, 'index']);


    // logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});