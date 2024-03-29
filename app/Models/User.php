<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['id', 'firstName', 'middleName', 'lastName', 'mobile', 'email', 'passwordHash', 'registeredAt', 'lastLogin', 'intro', 'profile'];
}
