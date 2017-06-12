<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,ModelTrait;
    public static $STATUS_PENDING = 0;
    public static $STATUS_VERIFIED = 1;

    public $table = 'user';

    public static $loginRules = [
        'email' => 'required',
        'password' => 'required|min:6'
    ];

    public static $profileRules = [
        'nameRules' => [
            'name' => 'required|min:6'
        ],
        'passwordRules' => [
            'password' => 'confirmed'
        ]
    ];

    public static $registerRules = [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:user',
        'password' => 'required|min:6|confirmed',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'confirm_password', 'confirmation', 'status'
    ];

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
