<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\RoleMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth routes (TIDAK perlu dibungkus middleware 'web')
require __DIR__.'/auth.php';

// Redirect awal
Route::get('/', function () {
    if (session('user')) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});


// ================= USER AREA =================
Route::middleware([\App\Http\Middleware\AuthSessionMiddleware::class])->group(function () {

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/books', [UserController::class, 'books'])->name('books');

    Route::get('/peminjaman', [UserController::class, 'requestBorrow'])->name('peminjaman');

    Route::post('/peminjaman/store', [UserController::class, 'storeRequestBorrow'])->name('peminjaman.store');

    Route::get('/pengembalian', [UserController::class, 'returns'])->name('pengembalian');

    Route::post('/pengembalian/process/{loan}', [UserController::class, 'processReturn'])->name('pengembalian.process');

});


// ================= ADMIN AREA =================
Route::middleware([
    \App\Http\Middleware\AuthSessionMiddleware::class,
    RoleMiddleware::class . ':admin'
])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/books', [AdminController::class, 'books'])->name('books');

    Route::get('/books/create', [AdminController::class, 'booksCreate'])->name('books.create');

    Route::post('/books', [AdminController::class, 'booksStore'])->name('books.store');

    Route::get('/books/{book}/edit', [AdminController::class, 'booksEdit'])->name('books.edit');

    Route::put('/books/{book}', [AdminController::class, 'booksUpdate'])->name('books.update');

    Route::delete('/books/{book}', [AdminController::class, 'booksDestroy'])->name('books.destroy');

    Route::get('/loans', [AdminController::class, 'loans'])->name('loans');

    Route::post('/loans/{loan}/approve', [AdminController::class, 'loanApprove'])->name('loans.approve');

    Route::post('/loans/{loan}/reject', [AdminController::class, 'loanReject'])->name('loans.reject');

});
