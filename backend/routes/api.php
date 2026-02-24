<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\CoursesController;

// Rutas API para Students y Courses
Route::apiResource('students', StudentsController::class);
Route::apiResource('courses', CoursesController::class);

