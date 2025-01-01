<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\AgeGroup;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query();

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('age_group')) {
            $query->whereHas('ageGroups', function ($q) use ($request) {
                $q->where('age_groups.id', $request->age_group);
            });
        }
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                // Buscar por título
                $q->where('title', 'like', '%' . $request->search . '%')
                  //buscar por categoría
                  ->orWhereHas('category', function ($query) use ($request) {
                      $query->where('name', 'like', '%' . $request->search . '%');
                  })
                  //buscar por grupo de edad
                  ->orWhereHas('ageGroups', function ($query) use ($request) {
                      $query->where('range', 'like', '%' . $request->search . '%');
                  });
            });
        }
        $courses = $query->with(['category', 'ageGroups'])->get();

        return response()->json($courses);
    }

    public function show(Course $course, Request $request)
    {
        $user = $request->user();
        $course = Course::with(['videos', 'ageGroups', 'category', 'users'])->findOrFail($course->id);
        $isSubscribed = $user && $user->courses->contains($course);
        $progress = $isSubscribed ? $course->users->first()->pivot->progress : 0;
    
        return response()->json([
            'course' => $course,
            'isSubscribed' => $isSubscribed,
            'progress' => $progress,
        ]);
    }

    public function subscribe(Course $course, Request $request)
    {
        $user = $request->user();

        if ($user->courses->contains($course->id)) {
            return response()->json(['message' => 'Ya estás suscrito a este curso.'], 400);
        }

        $user->courses()->attach($course->id, ['progress' => 0]);

        return response()->json(['message' => 'Suscripción exitosa al curso.'], 200);
    }
}
