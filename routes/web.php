<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', function () {
    return view('welcome'); // Make sure welcome.blade.php exists
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Invoice pages
Route::middleware('auth')->group(function () {

    // Invoice List
    Route::get('/invoices', function () {
        return view('invoices.index'); // Blade + Vue
    })->name('invoices.index');

    // Invoice Create
    Route::get('/invoices/create', function () {
        return view('invoices.create'); // Blade + Vue form
    })->name('invoices.create');

    // Invoice Details
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])
        ->name('invoices.show');

});

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Auth routes (login/register) if using Laravel Breeze
require __DIR__.'/auth.php';
