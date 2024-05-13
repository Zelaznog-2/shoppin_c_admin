<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\OnlyAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth', 'verified', OnlyAdmin::class])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('categories', CategoryController::class)->missing(function () { return Redirect::route('categories.index'); });
    Route::resource('sales', SaleController::class)->missing(function () { return Redirect::route('sales.index'); });
    Route::resource('products', ProductController::class)->missing(function () { return Redirect::route('products.index'); });
    Route::resource('users', UserController::class)->missing(function () { return Redirect::route('users.index'); });
    Route::resource('clients', ClientController::class)->missing(function () { return Redirect::route('users.index'); });
    Route::resource('suppliers', SupplierController::class)->missing(function () { return Redirect::route('suppliers.index'); });
    Route::resource('incomes', IncomeController::class)->missing(function () { return Redirect::route('incomes.index'); });

});

require __DIR__.'/auth.php';
