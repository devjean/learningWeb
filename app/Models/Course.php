<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'category_id'];

    // Relación con video
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    // Relación con grupos de de edad
    public function ageGroups()
    {
        return $this->belongsToMany(AgeGroup::class, 'courses_age_group');
    }

    // Relación con categoria
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación con usuario
    public function users()
    {
        return $this->belongsToMany(User::class)->using(CourseUser::class)->withPivot('progress');
    }
}
