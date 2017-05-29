<?php
namespace App\Validator;
use \Illuminate\Validation\Validator;

interface IValidatable{
    /**
     * @param array $options
     * @param array $input
     * @return \Illuminate\Validation\Validator
     */
    public function validate($options = [],$input = []);
}