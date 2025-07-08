<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PeriodicalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsUpdateController;
use App\Http\Controllers\PeriodicalMasterController;
use App\Http\Controllers\OrderCircularController;
use App\Http\Controllers\EmployeeController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/index-other', [HomeController::class, 'indexOther'])->name('home.index-other');
Route::get('/updatesmore', [HomeController::class, 'updatesMore'])->name('updatesmore');
Route::get('/order-circular/{type}', [HomeController::class, 'orderCircular'])->name('home.order-circular');
Route::get('/search', [HomeController::class, 'search'])->name('home.search');

Route::get('/upload-request', [HomeController::class, 'uploadRequest'])->name('home.upload-request');
Route::post('/upload-request/save', [HomeController::class, 'storeUploadRequest'])->name('home.store-upload-request');
Route::get('/upload-request/check-status', action: [HomeController::class, 'checkStatus'])->name('home.check-upload-request');
Route::get('/advanced-search', [HomeController::class, 'advancedSearch'])->name('home.advanced-search');

Route::get('/employees', [EmployeeController::class, 'index'])->name('home.employees');
Route::get('/employees/data', [EmployeeController::class, 'getEmployees'])->name('employees.data');
// Route::get('/employees/filters', [EmployeeController::class, 'getFilters'])->name('employees.filters');
// Route::get('/employees/{id}', [HomeController::class, 'employeeShow'])->name('home.employee-show');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/periodicals/store', [PeriodicalController::class, 'store'])->name('periodicals.store');
    Route::get('/periodicals/create', [PeriodicalController::class, 'create'])->name('periodicals.create');
    Route::get('/periodicals/show/{id}', [PeriodicalController::class, 'show'])->name('periodicals.show');
    Route::get('/periodicals/edit/{id}', [PeriodicalController::class, 'edit'])->name('periodicals.edit');
    Route::patch('/periodicals/update/{id}', [PeriodicalController::class, 'update'])->name('periodicals.update');
    Route::get('/periodicals', [PeriodicalController::class, 'index'])->name('periodicals.index');

    Route::get('/news-updates', [NewsUpdateController::class, 'index'])->name('news-updates.index');
    Route::get('/news-updates/create', [NewsUpdateController::class, 'create'])->name('news-updates.create');
    Route::post('/news-updates/store', [NewsUpdateController::class, 'store'])->name('news-updates.store');
    Route::get('/news-updates/edit/{id}', [NewsUpdateController::class, 'edit'])->name('news-updates.edit');
    Route::patch('/news-updates/update/{id}', [NewsUpdateController::class, 'update'])->name('news-updates.update');
    Route::delete('/news-updates/destroy/{id}', [NewsUpdateController::class, 'destroy'])->name('news-updates.destroy');
    // Periodical Masters CRUD
    Route::get('/periodical-masters', [PeriodicalMasterController::class, 'index'])->name('periodical-masters.index');
    Route::get('/periodical-masters/create', [PeriodicalMasterController::class, 'create'])->name('periodical-masters.create');
    Route::post('/periodical-masters/store', [PeriodicalMasterController::class, 'store'])->name('periodical-masters.store');
    Route::get('/periodical-masters/edit/{id}', [PeriodicalMasterController::class, 'edit'])->name('periodical-masters.edit');
    Route::patch('/periodical-masters/update/{id}', [PeriodicalMasterController::class, 'update'])->name('periodical-masters.update');
    Route::delete('/periodical-masters/destroy/{id}', [PeriodicalMasterController::class, 'destroy'])->name('periodical-masters.destroy');
    // Orders-Circular CRUD
    Route::get('/orders-circular', [OrderCircularController::class, 'index'])->name('orders-circular.index');
    Route::get('/orders-circular/create', [OrderCircularController::class, 'create'])->name('orders-circular.create');
    Route::post('/orders-circular/store', [OrderCircularController::class, 'store'])->name('orders-circular.store');
    Route::get('/orders-circular/edit/{id}', [OrderCircularController::class, 'edit'])->name('orders-circular.edit');
    Route::patch('/orders-circular/update/{id}', [OrderCircularController::class, 'update'])->name('orders-circular.update');
    Route::delete('/orders-circular/destroy/{id}', [OrderCircularController::class, 'delete'])->name('orders-circular.delete');
});

require __DIR__ . '/auth.php';
