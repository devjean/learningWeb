<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Video;
use App\Models\VideoCategory;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $courses = Course::all();

        VideoCategory::create(['name' => 'Introducción']);
        VideoCategory::create(['name' => 'Avanzado']);
        VideoCategory::create(['name' => 'Tutoriales']);
        VideoCategory::create(['name' => 'Teoría']);
        VideoCategory::create(['name' => 'Ejercicios Prácticos']);

        $videoCategories = VideoCategory::all();

        foreach ($courses as $course) {
            // Crear 5 videos por curso
            for ($i = 1; $i <= 5; $i++) {
                Video::create([
                    'title' => 'Video ' . $i . ' para ' . $course->title,
                    'course_id' => $course->id,
                    'video_category_id' => $videoCategories->random()->id,
                    'description' => 'Descripción del video ' . $i . ' para el curso ' . $course->title,
                    'video_url' => 'https://www.example.com/video' . $i,
                ]);
            }
        }
    }
}
