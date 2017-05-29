<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 12/17/2016
 * Time: 1:16 PM
 */

namespace App\Models\FacebookApi;

use Facebook\Facebook;
use Facebook\FacebookRequest;

class BaseFacebookApi
{
    protected $fbObj;

    public function __construct($appid, $appsecret){
        $this->fbObj = new Facebook([
            'app_id' => $appid,
            'app_secret' => $appsecret,
            'default_graph_version' => env('fb_api_version','v2.9')
        ]);
    }

    public static function getPageUrl($page_id){
        return "https://web.facebook.com/".$page_id;
    }

    public static function getPostUrl($page_id, $post_id_single){
        return 'https://web.facebook.com/'.$page_id.'/posts/'.$post_id_single;
    }

    protected  function getRequest($url,$token,$method = "GET",$params = []){
        return $request = new FacebookRequest(
            $this->fbObj->getApp(),
            $token,
            $method,
            $url,
            $params
        );
    }

    protected function executeRequest($requests,$token){
        $requestarr = $requests;
        $isarr = true;
        if(!is_array($requestarr)){
            $isarr = false;
            $requestarr = [$requests];
        }

        $response = $this
            ->fbObj
            ->sendBatchRequest($requestarr,$token);

        if(!$isarr){
            foreach($response as $resp){
                $response = $resp;
                break;
            }
        }

        return $response;
    }
}