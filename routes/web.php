<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ComplaintRegisterController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/index-other', [HomeController::class, 'indexOther'])->name('home.index-other');
Route::get('/updatesmore', [HomeController::class, 'updatesMore'])->name('updatesmore');
Route::get('/order-circular/{type}', [HomeController::class, 'orderCircular'])->name('home.order-circular');
Route::get('/search', [HomeController::class, 'search'])->name('home.search');

Route::get('/upload-request', [HomeController::class, 'uploadRequest'])->name('home.upload-request');
Route::post('/upload-request/save', [HomeController::class, 'storeUploadRequest'])->name('home.store-upload-request');
Route::get('/upload-request/check-status', action: [HomeController::class, 'checkStatus'])->name('home.check-upload-request');
Route::get('/advanced-search', [HomeController::class, 'advancedSearch'])->name('home.advanced-search');

//Complaint Register
Route::get('/employees/list', [EmployeeController::class, 'list']);


Route::get('/employees', [EmployeeController::class, 'index'])->name('home.employees');
Route::get('/employees/data', [EmployeeController::class, 'getEmployees'])->name('employees.data');
Route::get('/employees/{attendanceId}', [EmployeeController::class, 'employeeShow'])->name('employees.show');
// Retired Staff
Route::get('/retired-staff', [EmployeeController::class, 'retiredStaff'])->name('home.retired-staff');
Route::get('/retired-staff/data', [EmployeeController::class, 'getRetiredEmployees'])->name('retired-staff.data');
Route::get('/retired-staff/{id}', [EmployeeController::class, 'retiredStaffShow'])->name('retired-staff.show');

// IT Complaint Register routes for dynamic dropdowns

Route::get('/get-floors/{location}', [ComplaintRegisterController::class, 'getFloors']);
Route::get('/get-rooms/{location}/{floor}', [ComplaintRegisterController::class, 'getRooms']);
//IT Complaint Register store
Route::post('/complaintregister/store', [ComplaintRegisterController::class, 'store'])->name('complaintregister.store');
//Live screen
Route::get('/complaintregister/live-screen', [ComplaintRegisterController::class, 'liveScreen']);
Route::get('/complaintregister/live-data', [ComplaintRegisterController::class, 'liveData']);
Route::post('/complaintregister/take-ticket/{ticket}', [ComplaintRegisterController::class, 'takeTicket']);
Route::post('/complaintregister/resolve-ticket/{ticket}', [ComplaintRegisterController::class, 'resolveTicket']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';