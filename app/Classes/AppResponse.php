<?php

namespace App\Classes;

/**
 * Created by PhpStorm.
 * User: talha
 * Date: 3/6/2017
 * Time: 3:10 PM
 */


class AppResponse
{
    public $data;
    public $validator;
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

    public function __construct($status = false, $data = null,$validator = null, $redirect = null)
    {
        $this->data = $data;
        $this->redirectUrl = $redirect;
        $this->status = $status;
        $this->setValidator($validator);
    }

    public function setValidator($validator){
        $this->validator = $validator;
        $this->errors = $validator == null ? null : $validator->errors();
    }
}