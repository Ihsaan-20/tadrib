<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag',
    ];

    
    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }

   
}
