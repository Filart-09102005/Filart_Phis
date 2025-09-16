<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Tell Eloquent NOT to automatically manage timestamps
    public $timestamps = false;

    // Allow mass assignment for these fields
    protected $fillable = [
        'email',
        'password',
    ];

    // Hide the password when serializing
    protected $hidden = [
        'password',
    ];
}
