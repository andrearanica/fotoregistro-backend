<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Classroom extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'class_id'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
