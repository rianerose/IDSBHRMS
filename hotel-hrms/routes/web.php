<?php

use App\Http\Controllers\AttendanceRecordController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/employees');

Route::resource('employees', EmployeeController::class)->except(['show']);
Route::resource('attendance-records', AttendanceRecordController::class)->except(['show']);
Route::resource('payrolls', PayrollController::class)->only(['index', 'create', 'store', 'destroy']);
