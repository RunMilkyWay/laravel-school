<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\SeminarController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/dashboard', [SeminarController::class, 'index'])->middleware('auth')->name('dashboard');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Redirect to the home page or wherever you want
})->name('logout');

