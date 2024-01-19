<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramWithExerciseSet extends Model
{
    use HasFactory;
    protected $fillable = [
        'program',
        'program_name',
        'program_intro_video',
        'program_text_bio',
        'program_equi_neede',
        'program_training_type',
        'coach_id',
        'program_profile',
        'program_duration',
        'program_level',
        'program_price',
        'workouts',
    ];
}
