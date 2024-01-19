<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table='group';
    protected $fillable=[
        'group_name',
        'group_created_by',
        'group_member',
        'group_profile',
    ];


    public function members()
    {
        return $this->hasMany(User::class, 'id', 'group_member');
    }

    public static function getUserGroups($userId)
    {
        return self::whereRaw("JSON_SEARCH(group_member, 'one', :userId) IS NOT NULL", ['userId' => $userId])->get();
    }
}
