<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgeGroup extends Model
{
    use HasFactory;

    protected $fillable = ['range'];

    // Relación con curso
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}
