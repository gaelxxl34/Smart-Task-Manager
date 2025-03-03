<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Middleware\AuthenticateUser;
use App\Http\Controllers\ManageSemesterController;
use App\Http\Controllers\TaskController;


Route::post('/signup', [AuthenticationController::class, 'signup']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword']);
Route::get('/get-users', [AuthenticationController::class, 'getUsers']);
Route::delete('/delete-user/{uid}', [AuthenticationController::class, 'deleteUser']);
Route::put('/users/{uid}', [AuthenticationController::class, 'updateUser']);
Route::post('/edit-user/{uid}', [AuthenticationController::class, 'editUser']);


// -- LOGIN AND LOGOUT ROUTING
Route::get('/login', function () {
    return view('/Auth/login');
})->name('login');
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

// Display the Forget Password form
Route::get('/forget-password', function () {
    return view('Auth.forget-password');
})->name('forget-password');

// Handle the Forget Password form submission
Route::post('/forget-password', [AuthenticationController::class, 'forgotPassword'])->name('forget-password');


// -- DASHBOARDS MIDDLEWARES 
Route::middleware([AuthenticateUser::class])->group(function () {
    Route::get('/Dashboard', function () {
        return view('superadmin/dashboard');
    });

    Route::get('/department/dashboard', function () {
        return view('department/dashboard');
    });
});



Route::get('/users', function () {
    return view('users');
});

Route::get('/reports', function () {
    return view('reports');
});

Route::get('/task/semester/details', function () {
    return view('partials/pages/superadmin-semester-details');
});


// -- SEMESTER ROUTING

// Display the task page with semesters
Route::get('/task', [ManageSemesterController::class, 'index'])->name('task.view');

// Store semester data
Route::post('/semester/store', [ManageSemesterController::class, 'store'])->name('semester.store');

// Dynamic semester details page
Route::get('/task/semester/details/{semester}', [TaskController::class, 'show'])->name('semester.details');

// Store tasks
Route::post('/task/semester/details/{semester}/add', [TaskController::class, 'store'])->name('task.store');