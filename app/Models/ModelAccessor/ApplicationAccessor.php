<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Classes\Helper;
use App\Models\Application;
use Illuminate\Support\Facades\Validator;

class ApplicationAccessor extends BaseAccessor
{
    public function createOrUpdate($data, $user_id, $app_id = null){
        $validator = Validator::make($data,Application::creationRules());
        $resp = new AppResponse(false);

        if($validator->passes()){
            $application = null;
            if($app_id == null){
                $application = new Application();
                $application->created_at = time();
                $application->user_id = $user_id;
                $application->api_token = $this->createNewToken();
            }else{
                $application = Application::firstOrNew([
                    'id' =>$app_id,
                    'user_id'=>$user_id
                ]);
            }

            $application->fb_appid = Helper::getWithDefault($data,'fb_appid',$application->fb_appid);
            $application->fb_appsecret = Helper::getWithDefault($data,'fb_appsecret',$application->fb_appsecret);
            $application->name = Helper::getWithDefault($data,'name');
            $application->modified_at = time();
            $application->save();
            $resp->data = $application;
            $resp->setStatus(true);
        }

        $resp->addErrorsFromValidator($validator);
        return $resp;
    }

    public function getUserApplications($user_id){
        $resp = new AppResponse();
        $app = Application::where('user_id',$user_id)->get();
        $resp->data = $app;
        $resp->setStatus(true);
        return $resp;
    }

    /**
     * Not secure
     * @param $id
     * @return AppResponse
     */
    public function getApplication($id){
        $resp = new AppResponse();
        $app = Application::where('id',$id)->first();
        $resp->data = $app;
        $resp->setStatus(true);
        return $resp;
    }

    public function getApplicationSecure ($application_id, $user_id){
        $res= new AppResponse(true);
        $res->data = Application::where('id', $application_id)
            ->where('user_id',$user_id)
            ->first();

        return $res;
    }

    public function destroyApplication($app_id,$user_id) {
        $res = new AppResponse();
        $res->data = Application::where('id',$app_id)->where('user_id',$user_id)->delete();
        $res->setStatus(true);
        return $res;
    }
}