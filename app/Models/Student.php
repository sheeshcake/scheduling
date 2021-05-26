<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    use HasFactory;
    protected $guard = "student";
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
