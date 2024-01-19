<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramWorkoutExerciseSet extends Model
{
    use HasFactory;
    protected $fillable = [
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
        'workout_name',
        'workout_intro_video',
        'workout_text_bio',
        'workout_training_type',
        'workout_equi_needed',
        'workout_estimated_duration',
        'workout_rest_days',
        'workout_number_of_exercises',
        'set_type',
        'set_exercises',
        'set_number_of_time_set',
        'set_intra_set_rest',
        'set_inter_set_rest',
        'set_duration_set',
        'exercise_text_bio',
        'exercise_number_of_repeat',
        'exercise_input_example',
    ];

}
