<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 12/17/2016
 * Time: 1:16 PM
 */

namespace App\Models\BusinessLogic;
use App\Models\QueuedRequest;
use Doctrine\DBAL\Exception\ServerException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class QueuedRequestExecutor
{
    protected $httpClient;

    public function __construct(){
        $this->httpClient = new Client([
            'verify'=>false,
            'base_uri'=>config('APP_URL').'/api/'
        ]);
    }

    protected function getUrl($url){
        return env('APP_URL').'/api/'.$url;
    }

    public function executeRequest($queuedRequest){
        $requestParams = [];
        $query = json_decode($queuedRequest->query,true);
        $requestParams['query'] = [];
        if(!empty($query)){
            foreach ($query as $key => $val){
                $requestParams['query'][$key] = $val;
            }
        }

        $requestParams['query']['prevent_queue'] = true;
        $headers = json_decode($queuedRequest->headers,true);
        $requestParams['headers'] = [];
        if(!empty($headers)) {
            foreach ($headers as $key => $val) {
                $requestParams['headers'][$key] = $val;
            }
        }

        if(strtolower($queuedRequest->method) == 'post'){
            $data = json_decode($queuedRequest->data,true);
            $type = '';
            if($queuedRequest->data_type == QueuedRequest::$TYPE_MULTIPART){
                $type = 'multipart';
            }else{
                $type = 'form_params';
            }

            $requestParams[$type] = [];
            if(!empty($data)) {
                foreach ($data as $key => $val) {
                    $requestParams[$type][$key] = $val;
                }
            }
        }

        $decoded = null;
        $resp = "";
        try{
            $response = $this->httpClient->request($queuedRequest->method,$this->getUrl($queuedRequest->url), $requestParams);
            $resp = $response->getBody()->getContents();
        }
        catch (RequestException $e){
            if($e->getResponse()->getBody()!=null){
                $resp = $e->getResponse()->getBody()->getContents();
            }
        }
        catch (\GuzzleHttp\Exception\ServerException $e){
            if($e->getResponse()->getBody()!=null){
                $resp = $e->getRespnse()->getBody()->getContents();
            }
        }
        catch (ClientException $e){
            if($e->getResponse()->getBody()!=null){
                $resp = $e->getResponse()->getBody()->getContents();
            }
        }

        return $resp;
    }
}