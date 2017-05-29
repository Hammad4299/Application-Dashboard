<?php
namespace App\Validator;
use App\Classes\AppResponse;
use Illuminate\Support\MessageBag;
use \Illuminate\Validation\Validator;

class ErrorWithCode extends Error {
    public $code;

    public function __construct($message, $code = -1)
    {
        parent::__construct($message);
        $this->data['code'] = $code;
    }

    public function jsonSerialize() {
        return $this->data;
    }

    public function getData()
    {
        return $this->data;
    }
}