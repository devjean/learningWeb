<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseUser extends Pivot
{
    protected $fillable = ['user_id', 'course_id', 'progress'];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con curso
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
