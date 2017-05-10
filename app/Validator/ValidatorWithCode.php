<?php
namespace App\Validator;
use App\Classes\AppResponse;
use Illuminate\Support\MessageBag;
use \Illuminate\Validation\Validator;

class ValidatorWithCode extends Validator{
    protected function addFailure($attribute, $rule, $parameters)
    {
        $message = $this->getMessage($attribute, $rule);
        $message = $this->makeReplacements($message, $attribute, $rule, $parameters);
        $customMessage = new MessageBag();
        $code = -1;
        $index = array_search('error_code',$parameters);
        if($index !== false && count($parameters)>($index+1)){
            $code = $parameters[$index+1];
        }

        AppResponse::addError($this->messages,$attribute,$message,$code);
    }
}