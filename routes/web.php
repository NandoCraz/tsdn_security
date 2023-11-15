<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SecurityController;
use App\Models\Pasien;
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

Route::get('/login', [LoginController::class, 'index'])->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::get('/face-recognation', [SecurityController::class, 'index'])->middleware('recognition');
Route::post('/face-check', [SecurityController::class, 'faceCheck'])->middleware('recognition');
Route::get('/check-active', [SecurityController::class, 'checkActive'])->middleware('dokter');

Route::get('/', [DashboardController::class, 'index'])->middleware('dokter');
Route::get('/data-pasien', [PasienController::class, 'index'])->middleware('dokter');
