<?php

namespace App\Classes;


use App\Validator\ErrorWithCode;
use App\Validator\IValidatable;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;

class AppResponse implements \JsonSerializable
{
    public $data;
    public $message;
    /**
     * @var integer|null
     */
    protected $statusCode;

    /**
     * @var bool
     */
    protected $status;
    /**
     * @var MessageBag
     */
    public $errors;
    /**
     * @var bool
     */
    public $reload;
    /**
     * @var string|null
     */
    public $redirectUrl;

    public function firstError($name){
        if($this->errors!=null){
            return ($this->errors->get($name)!=null && isset($this->errors->get($name)[0])) ? $this->errors->get($name)[0] : null;
        }

        return '';
    }

    public static function getErrorObj($message, $code = -1){
        $e = new ErrorWithCode($message,$code);
        return $e->getData();
    }

    public function addError($field, $message, $code = -1){
        self::addErrorInBag($this->errors,$field, $message, $code);
        $this->setStatus(false);
    }

    public static function addErrorInBag(MessageBag $bag,$field, $message, $code = -1){
        $bag->merge([$field=>[self::getErrorObj($message,$code)]]);
    }

    public function setStatus($status, $statusCode = null){
        $this->status = $status;
        if($statusCode!=null)
            $this->statusCode = $statusCode;
    }

    public function setStatusCode($statusCode){
        $this->statusCode = $statusCode;
    }

    public static function getErrorMessage($error){
        return $error == null || !isset($error['message']) ? "" : $error['message'];
    }

    public function addErrorsFromValidator(Validator $validator){
        foreach ($validator->errors()->toArray() as $key => $messages){
            foreach ($messages as $message){
                $this->addError($key, self::getErrorMessage($message),$message['code']);
            }
        }
    }

    /**
     * @param IValidatable $toValidate
     * @param array $input
     * @param array $options
     * @return bool
     */
    public function validate(IValidatable $toValidate, $input = [], $options = []){
        $validator = $toValidate->validate($options,$input);
        if($validator!=null){
            $this->addErrorsFromValidator($validator);
        }
        return $this->getStatus();
    }

    public function clearErrors(){
        $this->errors = new MessageBag();
    }

    public function getStatus(){
        return $this->status;
    }

    public function getStatusCode(){
        return $this->statusCode;
    }

    public function __construct($status = false)
    {
        $this->data = null;
        $this->setStatus($status);
        $this->redirectUrl = null;
        $this->clearErrors();
    }

    public function jsonSerialize() {
        $out = array();
        $out['data'] = $this->data;
        $out['status'] = $this->getStatus();
        $out['errors'] = count($this->errors)>0 ? $this->errors : null;
        return $out;
    }
}