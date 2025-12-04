<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('books', BookController::class)->except(['create','edit']);
    Route::resource('members', MemberController::class)->except(['create','edit','show']);

    Route::get('borrows', [BorrowController::class, 'index'])->name('borrows.index');
    Route::post('borrows', [BorrowController::class, 'store'])->name('borrows.store');
    Route::post('borrows/return', [BorrowController::class, 'return'])->name('borrows.return');
});

require __DIR__.'/auth.php';
