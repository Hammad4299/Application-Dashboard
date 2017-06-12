<?php

namespace App\Models;

use App\Validator\IValidatable;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model implements IValidatable
{
    use ModelTrait;
    public static function getTableName(){
        $g = new PasswordReset();
        return $g->getTable();
    }

    protected $table = 'password_resets';
    public $timestamps = false;
    protected $fillable = ['email', 'token', 'created_at','user_id'];

    /**
     * @param array $options
     * @param array $input
     * @return \Illuminate\Validation\Validator
     */
    public function validate($options = [], $input = [])
    {
        // TODO: Implement validate() method.
    }
}
