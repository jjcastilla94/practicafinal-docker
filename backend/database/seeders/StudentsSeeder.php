<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Students;
use App\Models\Courses;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            ['name' => 'Ana García', 'email' => 'ana.garcia@example.com', 'course' => 'Matemáticas'],
            ['name' => 'Luis Pérez', 'email' => 'luis.perez@example.com', 'course' => 'Programación'],
            ['name' => 'María López', 'email' => 'maria.lopez@example.com', 'course' => 'Física'],
            ['name' => 'Carlos Ruiz', 'email' => 'carlos.ruiz@example.com', 'course' => 'Programación'],
        ];

        foreach ($students as $s) {
            $course = Courses::where('name', $s['course'])->first();
            Students::create([
                'name' => $s['name'],
                'email' => $s['email'],
                'course_id' => $course ? $course->id : null,
            ]);
        }
    }
}
