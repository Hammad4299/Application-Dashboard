<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use ModelTrait;
    public $table = 'country';
    protected $fillable = ['name'];
}
