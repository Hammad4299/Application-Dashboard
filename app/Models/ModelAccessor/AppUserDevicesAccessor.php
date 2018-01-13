<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Classes\Helper;
use App\Models\AppUserDevice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AppUserDevicesAccessor extends BaseAccessor
{
    public function createUpdateDeviceForUser($app_user_id,$data){
        $resp = new AppResponse(true);
        $validator = Validator::make($data,AppUserDevice::creationUpdateRules());

        if($validator->passes()) {
            $device = AppUserDevice::where('app_user_id',$app_user_id)
                ->where('device_name',Helper::getWithDefault($data,'device_name'))
                ->first();

            if($device == null){
                $device = new AppUserDevice();
            }

            $device->last_updated_at = Carbon::now()->getTimestamp();
            $device->app_user_id = $app_user_id;
            $device->device_name = Helper::getWithDefault($data,'device_name');
            $device->save();
            $resp->data = $device;
        }

        $resp->addErrorsFromValidator($validator);
        return $resp;
    }
}