<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'video_url', 'video_category_id'];

    // Relación con curso
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relación con categoría de video
    public function category()
    {
        return $this->belongsTo(VideoCategory::class, 'video_category_id');
    }

    // Relación con comentario
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relación con like
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
