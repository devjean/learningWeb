<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\AgeGroup;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $ageGroups = AgeGroup::all();

        // Crear 10 cursos
        for ($i = 1; $i <= 10; $i++) {
            $course = Course::create([
                'title' => "Curso $i",
                'description' => "Descripción del curso $i",
                'category_id' => $categories->random()->id,
            ]);

            // Asignar entre 1 y 3 grupos de edad al curso
            $course->ageGroups()->sync($ageGroups->random(rand(1, 3))->pluck('id')->toArray());
        }
    }
}
