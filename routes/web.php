<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SeminarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\WorkerMiddleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/dashboard', [SeminarController::class, 'index'])->middleware('auth')->name('dashboard');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Seminar-related routes
Route::post('/seminar/{id}/register', [SeminarController::class, 'register'])->name('seminar.register');
Route::post('/seminar/{id}/unregister', [SeminarController::class, 'unregister'])->name('seminar.unregister');
Route::delete('/seminar/{id}', [SeminarController::class, 'delete'])->name('seminar.delete')->middleware('auth');
Route::get('/seminar/create', [SeminarController::class, 'create'])->name('seminar.create')->middleware(['auth', AdminMiddleware::class]);
Route::post('/seminar/store', [SeminarController::class, 'store'])->name('seminar.store')->middleware('auth');
Route::get('/seminar/{id}/edit', [SeminarController::class, 'edit'])->name('seminar.edit')->middleware(['auth', AdminMiddleware::class]);
Route::put('/seminar/{id}', [SeminarController::class, 'update'])->name('seminar.update')->middleware('auth');
Route::get('/conference/{id}', [SeminarController::class, 'showConference'])->name('show');

// Admin routes for managing users
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.delete'); // Delete route
});

Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'lt'])) {
        Session::put('locale', $locale);
        App::setLocale($locale); // Set locale immediately
    }
    return redirect()->back();
})->name('locale.switch');


