<?php
namespace App\Classes;
use Illuminate\Support\MessageBag;
use JsonSerializable;

/**
 * Created by PhpStorm.
 * User: talha
 * Date: 3/6/2017
 * Time: 3:10 PM
 */


class AppResponse implements JsonSerializable
{
    public $data;
    public $validator;

    protected $isApi;

    /**
     * @var bool
     */
    public $status;

    public $errors;

    /**
     * @var bool
     */
    public $reload;

    public $message;

    /**
     * @var string|null
     */
    public $redirectUrl;

    public function needRedirect(){
        return $this->redirect != null;
    }

    public function setApi($isApi = true){
        $this->isApi = $isApi;
    }

    public static function getErrorObj($message, $code = -1){
        return ['message'=>$message,'code'=>$code];
    }

    public static function addError(MessageBag $messageBag, $field, $message, $code = -1){
        $messageBag->merge([$field=>[self::getErrorObj($message,$code)]]);
    }


    public function jsonSerialize() {
        $out = array();
        $out['data'] = $this->data;
        $out['status'] = $this->status;
        $out['errors'] = $this->errors;
        return $out;
    }

    public function __construct($status = false, $data = null,$validator = null, $redirect = null)
    {
        $this->setApi();
        $this->data = $data;
        $this->redirectUrl = $redirect;
        $this->status = $status;
        $this->setValidator($validator);
    }

    public function setValidator($validator){
        $this->validator = $validator;
        $this->errors = $validator == null || count($validator->errors())==0 ? null : $validator->errors();
    }
}