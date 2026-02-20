<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $courses = Courses::with('students')->get();
        return response()->json($courses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course = Courses::create($data);

        return response()->json($course, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Courses $course): JsonResponse
    {
        return response()->json($course->load('students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Courses $course): JsonResponse
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course->update($data);

        return response()->json($course->load('students'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Courses $course): JsonResponse
    {
        $course->delete();
        return response()->json(null, 204);
    }
}
