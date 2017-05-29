<?php
namespace App\Validator;
use App\Classes\AppResponse;
use Illuminate\Support\MessageBag;
use \Illuminate\Validation\Validator;

class Error{
    protected $data;

    public function __construct($message)
    {
        $this->data = [];
        $this->data['message'] = $message;
    }

    public function jsonSerialize() {
        return $this->data['message'];
    }

    public function getData(){
        return $this->data['message'];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->data['message'];
    }
}