<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $table='message';
    protected $fillable=[
        'message',
        'sender_id',
        'reciever_id',
        'media',
        'audio',
        'program_id'
    ];
}
