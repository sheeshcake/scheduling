<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teacher extends Models
{
    use HasFactory;
    protected $guard = "teacher";
    protected $fillable = [
        'f_name',
        'l_name',
        'username',
        'password',
    ];
    protected $hidden = [
        'password',
    ];
}
