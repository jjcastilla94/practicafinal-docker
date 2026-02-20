<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Courses;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            ['name' => 'Matemáticas', 'description' => 'Curso de matemáticas básicas y avanzadas.'],
            ['name' => 'Programación', 'description' => 'Introducción a la programación y buenas prácticas.'],
            ['name' => 'Física', 'description' => 'Fundamentos de la física clásica y moderna.'],
        ];

        foreach ($courses as $course) {
            Courses::create($course);
        }
    }
}
