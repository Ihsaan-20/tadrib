<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'tags',
        'introductory_video',
        'text_bio',
        'coach_id',
        'estimated_duration_hours',
        'rest',
        'number_of_exercises',
        // Add other fields as needed
    ];

    public function sets()
    {
        return $this->hasMany(Set::class);
    }

    public function tags()
{
    return $this->belongsToMany(Tag::class);
}

public function exercises()
{
    return $this->belongsToMany(Exercise::class);
}
}
