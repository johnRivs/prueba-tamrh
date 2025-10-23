<?php

use App\Http\Controllers\Auth\SessionController;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;

Route::view('/', 'home');

Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');

    Route::get('/login', [SessionController::class, 'create'])->name('session.create');
    Route::post('/login', [SessionController::class, 'store'])->name('session.store');
});

Route::middleware('auth')->group(function () {
    Route::delete('/logout', [SessionController::class, 'destroy'])->name('session.destroy');

    Route::get('/dashboard', Dashboard::class)->middleware(IsAdmin::class)->name('dashboard');
});



