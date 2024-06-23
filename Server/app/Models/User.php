<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'list_friend',
        'status',
        'online'
    ];
    public const Status = [
        'active' => 1,
        'in_active' => 2
    ];
    public const Online = [
        'online' => 1,
        'offline' => 2
    ];
    public const UserToken = 'UserToken';
    protected $hidden = [
        'password',
        'list_friend',
        'remember_token'
    ];
}
