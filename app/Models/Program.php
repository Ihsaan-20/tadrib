<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $table = "gym_programs";

  


    protected $fillable = [
        'name',
        'description',
        'progress',
        'introductory_video',
        'external_video',
        'thumbnail',
        'text_bio',
        'training_type',
        'tag_equipment',
        'coach_id',
        'duration_weeks',
        'level',
        'price_usd',
        'forum_chat',
        'number_of_workout',
        // Add other fields as needed
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }

}
