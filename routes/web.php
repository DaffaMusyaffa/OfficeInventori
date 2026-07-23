<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Employee;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// --- Root redirect ---
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('employee.dashboard');
    }

    return redirect()->route('login');
});

// --- Authentication ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// --- Shared profile (both roles) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// --- Admin ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('items', Admin\ItemController::class)->except('show');

    Route::get('/requests', [Admin\RequestController::class, 'index'])->name('requests.index');
    Route::post('/requests/{request}/approve', [Admin\RequestController::class, 'approve'])->name('requests.approve');
    Route::post('/requests/{request}/reject', [Admin\RequestController::class, 'reject'])->name('requests.reject');
    Route::post('/requests/{request}/confirm-return', [Admin\RequestController::class, 'confirmReturn'])->name('requests.confirm-return');
    Route::post('/requests/{request}/reject-return', [Admin\RequestController::class, 'rejectReturn'])->name('requests.reject-return');

    Route::get('/history', [Admin\HistoryController::class, 'index'])->name('history');

    Route::resource('users', Admin\UserController::class)->except('show');
});

// --- Employee ---
Route::middleware(['auth', 'role:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [Employee\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/items', [Employee\ItemController::class, 'index'])->name('items.index');

    Route::get('/requests', [Employee\RequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [Employee\RequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [Employee\RequestController::class, 'store'])->name('requests.store');
    Route::post('/requests/{request}/return', [Employee\RequestController::class, 'requestReturn'])->name('requests.return');
});
