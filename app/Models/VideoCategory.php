<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relación con video
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
