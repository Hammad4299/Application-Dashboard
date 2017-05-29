<?php

namespace App\Models;

use App\Validator\ErrorCodes;
use Illuminate\Foundation\Auth\User as Authenticatable;


class QueuedRequest extends Authenticatable
{
    public static function creationUpdateRules()
    {
        return [
            'url'=>"required:error_code," . ErrorCodes::$URL_REQUIRED,
            'method'=>"required:error_code," . ErrorCodes::$METHOD_REQUIRED,
        ];
    }

    protected $table = 'queued_request';
    public static $TYPE_FORM = 1;
    public static $TYPE_MULTIPART = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'application_id',
        'method',
        'url',
        'headers',
        'data',
        'query',
        'data_type',
        'response'
    ];

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'data',
        'headers',
        'query',
        'data_type',
        'url',
        'method'
    ];
}
