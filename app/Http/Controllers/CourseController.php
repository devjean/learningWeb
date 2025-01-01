<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function show(Course $course)
    {
        return view('courses.show', [
            'course' => $course
        ]);
    }

    public function subscribe(Course $course)
    {
        $user = auth()->user();

        if (!$user->courses->contains($course->id)) {
            $user->courses()->attach($course->id, ['progress' => 0]);
        }

        return redirect()->route('courses.show', $course->id)->with('status', 'Te has suscrito al curso exitosamente.');
    }
}
