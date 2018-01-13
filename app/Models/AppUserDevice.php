<?php

namespace App\Models;

use App\Validator\ErrorCodes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @api {None} gender-enum Gender (Application User)
 * @apiGroup Enums
 * @apiParam (Code) {Integer} 1 Male
 * @apiParam (Code) {Integer} 0 Female
 */
class AppUserDevice extends Authenticatable
{
    use ModelTrait;

    public static function creationUpdateRules()
    {
        return [
            'device_name'=>"required:error_code," . ErrorCodes::DEVICE_NAME_MISSING
        ];
    }

    protected $table = 'app_user_devices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    public $timestamps = false;
}
