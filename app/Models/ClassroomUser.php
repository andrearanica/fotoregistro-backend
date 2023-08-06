<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomUser extends Model
{
    use HasFactory;
    protected $table = 'classroom_user';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'classroom_id', 'role'
    ];
}
