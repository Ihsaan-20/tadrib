<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;
    
    protected $table = "gym_coaches";

    protected $fillable = [
        'name', 'email','phone_number','bio'
    ];
}
