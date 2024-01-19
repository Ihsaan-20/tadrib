<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description_video',
        'text_bio',
        'coach_id',
        'repetitions',
        // Add other fields as needed
    ];

    public function set()
    {
        return $this->belongsTo(Set::class);
    }
}
