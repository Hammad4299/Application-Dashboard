<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
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

            $application->fb_appid = self::getWithDefault($data,'fb_appid',$application->fb_appid);
            $application->fb_appsecret = self::getWithDefault($data,'fb_appsecret',$application->fb_appsecret);
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
        $resp = new AppResponse(true);
        $app = Application::where('id',$id)->first();
        $resp->data = $app;
        return $resp;
    }
}