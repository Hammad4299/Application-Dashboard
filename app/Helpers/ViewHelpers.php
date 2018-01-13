<?php

$decodedAssets = null;

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

function assetUrl($assetName){
    global $decodedAssets;
    $info = pathinfo($assetName);
    $type = $info['extension'];
    $asset = str_replace(".$type","",$assetName);
    if($decodedAssets == null){
        $json = file_get_contents(base_path('/webpack-assets.json'));
        $decodedAssets = json_decode($json,true);
    }

    $obj = \App\Classes\Helper::getWithDefault($decodedAssets,$asset);
    if(!empty($obj)){
        $obj = \App\Classes\Helper::getWithDefault($obj,$type);
    }

    return $obj;
}

function deviceIconClass($deviceName){
    if($deviceName == "Android"){
        return "fa-android";
    } else if($deviceName == "IPhonePlayer"){
        return "fa-apple";
    } else {
        return "fa-mobile";
    }
}