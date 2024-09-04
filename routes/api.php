<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\PengumumanController;
use App\Http\Controllers\Api\SponsorController;
use App\Http\Controllers\Api\LowonganPenelitianController;
use App\Http\Controllers\Api\LowonganPengabdianController;
use App\Http\Controllers\Api\PanduanController;
use App\Http\Controllers\Api\ProfilPengusulController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\SintaController;


Route::get('/formidentitas/{id}', [ProfilPengusulController::class, 'formidentitas']);

// Membatasi api akses dari luar aplikasi
Route::middleware('api.access')->group(function () {
    // Home Page
    Route::apiResource('/berita', BeritaController::class)->only(['index', 'show']);
    Route::apiResource('/sponsor', SponsorController::class);
    Route::apiResource('/pengumuman', PengumumanController::class);
    Route::apiResource('/lowonganpenelitian', LowonganPenelitianController::class);
    Route::apiResource('/lowonganpengabdian', LowonganPengabdianController::class);
    Route::apiResource('/panduan', PanduanController::class);

    // Register
    Route::apiResource('/register', RegisterController::class)->only(['store']);

    // Login
    Route::post('/login', [LoginController::class, 'login']);
    // Logout
    Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');
    
});

    // Pengusul
    Route::apiResource('/profilpengusul', ProfilPengusulController::class);
    Route::apiResource('/sinta', SintaController::class);