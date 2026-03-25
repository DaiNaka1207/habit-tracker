<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestLoginController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::post('guest-login', GuestLoginController::class)->name('guest.login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/settings.php';
