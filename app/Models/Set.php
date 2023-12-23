<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use HasFactory;

    protected $fillable = [
        'set_type',
        'exercises',
        'no_of_time',
        'intra_set_rest',
        'inter_set_rest',
        'estimated_duration',
        'workout_id',
        // Add other fields as needed
    ];

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }
}
