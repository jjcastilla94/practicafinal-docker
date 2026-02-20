<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoursesController; 
use App\Http\Controllers\StudentsController; 

Route::get('/', function () {
    return view('welcome');
});

Route::get('courses', function () { return view('courses'); }); 
Route::get('students', function () { return view('students'); });