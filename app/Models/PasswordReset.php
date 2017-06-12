<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use ModelTrait;
    public static function getTableName(){
        $g = new PasswordReset();
        return $g->getTable();
    }

    protected $table = 'password_resets';
    public $timestamps = false;
    protected $fillable = ['email', 'token', 'created_at'];
}
