<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\CoursesController;
use Illuminate\Support\Facades\Artisan;

// Rutas API para Students y Courses
Route::apiResource('students', StudentsController::class);
Route::apiResource('courses', CoursesController::class);

// Ruta temporal para cargar datos de ejemplo (eliminar en producción)
Route::get('/seed-data', function () {
    try {
        Artisan::call('db:seed', ['--force' => true]);
        return response()->json([
            'message' => 'Datos cargados correctamente',
            'output' => Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error al cargar datos',
            'message' => $e->getMessage()
        ], 500);
    }
});
