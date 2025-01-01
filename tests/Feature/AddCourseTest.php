<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\VideoCategory;
use App\Models\AgeGroup;
use App\Models\Course;
use Livewire\Livewire;

class AddCourseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_validation_rules_are_applied()
    {
        Livewire::test(\App\Livewire\AddCourse::class)
            ->set('title', '') // Campo vacío
            ->set('description', '') // Campo vacío
            ->call('store')
            ->assertHasErrors(['title', 'description']);
    }

    public function test_add_video_adds_to_videoUrls_array()
    {
        Livewire::test(\App\Livewire\AddCourse::class)
            ->set('videoTitle', 'Video Test')
            ->set('videoDescription', 'This is a test video')
            ->set('videoUrl', 'https://example.com/video')
            ->set('videoCategoryId', 1)
            ->call('addVideo')
            ->assertSet('videoUrls', [
                [
                    'title' => 'Video Test',
                    'description' => 'This is a test video',
                    'url' => 'https://example.com/video',
                    'category_id' => 1,
                ]
            ]);
    }

    public function test_store_saves_course_and_videos()
    {
        $this->withoutExceptionHandling();

        Livewire::test(\App\Livewire\AddCourse::class)
            ->set('title', 'Curso de Laravel')
            ->set('description', 'Introducción a Laravel')
            ->set('categoryId', 1)
            ->set('groupId', [1, 2]) // Grupos asociados
            ->set('videoUrls', [
                [
                    'title' => 'Video 1',
                    'description' => 'Introducción',
                    'url' => 'https://example.com/video1',
                    'category_id' => 1,
                ],
            ])
            ->call('store');

        $this->assertDatabaseHas('courses', [
            'title' => 'Curso de Laravel',
            'description' => 'Introducción a Laravel',
            'category_id' => 1,
        ]);

        $this->assertDatabaseHas('videos', [
            'title' => 'Video 1',
            'description' => 'Introducción',
            'url' => 'https://example.com/video1',
            'video_category_id' => 1,
        ]);
    }


}
