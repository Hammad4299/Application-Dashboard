<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 12/17/2016
 * Time: 1:16 PM
 */

namespace App\Models\FacebookApi;


use App\Classes\AppResponse;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\FacebookRequest;
use Facebook\GraphNodes\GraphPicture;
use League\Flysystem\Exception;

class FacebookUserApi extends BaseFacebookApi
{
    protected $permissions;

    public function __construct($appid, $secret)
    {
        parent::__construct($appid,$secret);
        $this->permissions = [
            'read_insights',
            'manage_pages',
            'email',
            'public_profile',
            'publish_pages',
            'business_management'
        ];
    }

    protected function getCallbackUrl(){
        return route('fbCallback');
    }

    public function getLoginUrl(){
        $resp = new AppResponse(true);
	    $helper = $this->fbObj->getRedirectLoginHelper();
    	$loginUrl = $helper->getLoginUrl($this->getCallbackUrl(), $this->permissions);
        $resp->data = $loginUrl;
        return $resp;
    }

    public function disconnect($token) {
        $url = "/me/permissions";
        $resp = new AppResponse(true);

        try{
            $response = $this->executeRequest($this->getRequest($url,$token,'DELETE'),$token);
        }catch (\Exception $e){
            $resp->setStatus(false);
        }
        return $resp;
    }

    public function getClientCodeFromToken($longlivedToken){
        $resp = new AppResponse(true);
        try{
            $oAuth2Client = $this->fbObj->getOAuth2Client();
            $resp->data = $oAuth2Client->getCodeFromLongLivedAccessToken($longlivedToken,$this->getCallbackUrl());
        }catch (\Exception $e){
            $resp->setStatus(false);
            $resp->message = $e->getMessage();
        }

        return $resp;
    }

    public function getLongLivedTokenForClient($clientCode){
        $resp = new AppResponse(true);
        try{
            $oAuth2Client = $this->fbObj->getOAuth2Client();
            $resp->data = $oAuth2Client->getAccessTokenFromCode($clientCode,$this->getCallbackUrl());
        }catch (\Exception $e){
            $resp->setStatus(false);
            $resp->message = $e->getMessage();
        }

        return $resp;
    }

    public function getLongLivedTokenFromCallback(){
        $resp = new AppResponse(false);
        $helper = $this->fbObj->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(FacebookResponseException $e) {
            $resp->message = $e->getMessage();
        } catch(FacebookSDKException $e) {
            $resp->message = $e->getMessage();
        }

        if (isset($accessToken)) {
            $resp->setStatus(true);
            $oAuth2Client = $this->fbObj->getOAuth2Client();
            // Exchanges a short-lived access token for a long-lived one
            $resp->data = $oAuth2Client->getLongLivedAccessToken((string)$accessToken)->getValue();
        }

        return $resp;
    }

    public function getUserInfo($accessToken){
        $resp = new AppResponse(true);
        $addIn = [];
        $url = "/me?fields=id";
        try{
            $response = $this->executeRequest($this->getRequest($url,$accessToken),$accessToken);
            $edge = $response->getGraphUser();
            $addIn['id'] = $edge->getField('id');
            $resp->data = $addIn;
        }catch (\Exception $exception){
            $resp->setStatus(false);
            $resp->message = $exception->getMessage();
        }
        return $resp;
    }
}