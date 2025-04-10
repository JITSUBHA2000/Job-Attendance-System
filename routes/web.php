<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::redirect('/', 'login');

Route::middleware(['auth', 'role:1,2,3'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/user-profile', [ProfileController::class, 'getUserProfile']);
    Route::post('/profile/update', [ProfileController::class, 'updateUserProfile'])->name('profile.updateUserProfile');
    Route::put('/profile/password', [ProfileController::class, 'updateUserProfilePassword'])->name('password.update');
});
Route::middleware(['auth', 'role:1,2'])->group(function () {
    Route::resource('/schedule', ScheduleController::class);
    Route::resource('/employees', EmployeeController::class);
    Route::get('/sheet-report', [AttendanceController::class, 'getEmployeeSheetReport']);
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::resource('/manager', ManagerController::class);
});

Route::middleware(['auth', 'role:3'])->group(function () {
    
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
});

require __DIR__.'/auth.php';
