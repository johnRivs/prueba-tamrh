<?php

use App\Http\Controllers\Auth\SessionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/register', function () {})->name('register');

Route::get('/login', [SessionController::class, 'create'])->name('session.create');
Route::post('/login', [SessionController::class, 'store'])->name('session.store');
Route::delete('/logout', [SessionController::class, 'destroy'])->name('session.destroy');

Route::middleware('auth')->get('/dashboard', function () {})->name('dashboard');
