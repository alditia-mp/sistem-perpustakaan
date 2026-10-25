<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Gabungkan semua route yang membutuhkan autentikasi ke dalam satu group
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. Route Dashboard (Cukup satu saja di sini)
   Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->name('dashboard');

    // 2. Route Profile Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. Route Resource untuk CRUD Modul Perpustakaan
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);
    Route::resource('members', MemberController::class);
    Route::resource('borrowings', BorrowingController::class);

    Route::patch(
        '/borrowings/{borrowing}/return',
        [BorrowingController::class, 'returnBook']
    )->name('borrowings.return');

    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';