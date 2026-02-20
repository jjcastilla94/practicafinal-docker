<?php

namespace App\Http\Controllers;

use App\Models\Students;
use App\Models\Courses;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $students = Students::with('course')->get();
        return response()->json($students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $student = Students::create($data);

        return response()->json($student->load('course'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Students $student): JsonResponse
    {
        return response()->json($student->load('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Students $student): JsonResponse
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:students,email,' . $student->id,
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $student->update($data);

        return response()->json($student->load('course'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Students $student): JsonResponse
    {
        $student->delete();
        return response()->json(null, 204);
    }
}
