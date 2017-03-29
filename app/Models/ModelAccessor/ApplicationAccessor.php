<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Models\Application;
use Illuminate\Support\Facades\Validator;

class ApplicationAccessor extends BaseAccessor
{
    public function create($data){
        $validator = Validator::make($data,Application::$CREATION_RULES);
        $resp = new AppResponse(false);


        if($validator->passes()){
            $resp->data = Application::create([
                'name' => $data['name'],
                'api_token' => $this->createNewToken(),
                'created_at' => time(),
                'modified_at' => time(),
            ]);
            $resp->status = true;
        }

        $resp->setValidator($validator);
        return $resp;
    }
}