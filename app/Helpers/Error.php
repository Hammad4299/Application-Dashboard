<?php

/**
 * Compatible with blade $errors
 * @param $errors
 * @param $field
 * @return string
 */
function getFirstError($errors, $field){
    $arr = $errors->getBag('default')->toArray();
    if(isset($arr[$field]) && isset($arr[$field][0])){
        return \App\Classes\AppResponse::getErrorMessage($arr[$field][0]);
    }
    return '';
}