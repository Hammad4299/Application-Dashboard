<?php

namespace App\Models;

use App\Validator\ErrorCodes;
use Illuminate\Database\Eloquent\Model;

/**
 * @api {None} user-transaction-status-enum TransactionStatus (UserTransaction)
 * @apiGroup Enums
 * @apiParam (Code) {Integer} 1 Pending
 * @apiParam (Code) {Integer} 2 Accepted
 * @apiParam (Code) {Integer} 3 Rejected
 */
class AppUserTransaction extends Model
{
    public static function creationUpdateRules()
    {
        return [
            'amount'=>"required:error_code," . ErrorCodes::$AMOUNT_REQUIRED
        ];
    }

    public static $STATUS_PENDING = 1;
    public static $STATUS_ACCEPTED = 2;
    public static $STATUS_REJECTED = 3;

    protected $table = 'user_transaction_request';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_user_id',
        'application_id',
        'amount',
        'status',
        'updated_at',
        'request_time'
    ];

    protected $appends = [
        'status_str'
    ];

    public $timestamps = false;

    public function getStatusStrAttribute()
    {
        $g = "";
        if($this->status == AppUserTransaction::$STATUS_PENDING) {
            $g = "Pending";
        }else if($this->status == AppUserTransaction::$STATUS_ACCEPTED) {
            $g = "Accepted";
        }else if($this->status == AppUserTransaction::$STATUS_REJECTED) {
            $g = "Rejected";
        }

        return $g;
    }
    public function app_users(){
        return $this->belongsTo(AppUser::class,'app_user_id');
    }

    public function getUsername($uId){
        return $this->app_users->where('id',$uId)->first()->username;
    }
}
