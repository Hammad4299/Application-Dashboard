<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Classes\Helper;
use App\Models\Application;
use Illuminate\Support\Facades\Validator;

class ApplicationAccessor extends BaseAccessor
{
    public function createOrUpdate($data, $app = null){
        $validator = Validator::make($data,Application::creationRules());
        $resp = new AppResponse(false);

        if($validator->passes()){
            $application = null;
            if($app == null){
                $application = new Application();
                $application->created_at = time();
                $application->api_token = $this->createNewToken();
            }else{
                $application = Application::firstOrNew([
                    'id' =>$app->id
                ]);
                $application->name = $data['name'];
            }

            $application->fb_appid = Helper::getWithDefault($data,'fb_appid',$application->fb_appid);
            $application->fb_appsecret = Helper::getWithDefault($data,'fb_appsecret',$application->fb_appsecret);
            $application->name = $data['name'];
            $application->modified_at = time();
            $application->save();
            $resp->data = $application;
            $resp->setStatus(true);
        }

        $resp->addErrorsFromValidator($validator);
        return $resp;
    }

    public function getApplication($id){
        $resp = new AppResponse();
        $app = Application::where('id',$id)->first();
        $resp->data = $app;
        $resp->setStatus(true);
        return $resp;
    }

    public function getAllApplications (){
        $resp = new AppResponse(true);
        $resp->data = Application::with('appusers')
            ->get();
        $resp->isApi = false;
        return $resp;
    }

    public function findByID ($application_id){
        $res= new AppResponse(true);
        $res->data = Application::where('id', $application_id)
            ->with('appusers')
            ->first();
        return $res;
    }

    public function destroyApplication($app_id) {
        $res = new AppResponse();
        $res->data = Application::destroy($app_id);
        $res->setStatus(true);
        return $res;
    }
}