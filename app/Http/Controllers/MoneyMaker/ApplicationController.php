<?php

namespace App\Http\Controllers\MoneyMaker;

use App\Models\ModelAccessor\ApplicationAccessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends \App\Http\Controllers\ApplicationController
{
    public function __construct(ApplicationAccessor $accessor){
        parent::__construct($accessor);
        $this->viewPrefix = "moneymaker.";
    }

    public function edit (Request $request) {
        $application_id = $request->route()->parameter('application_id');
        $data = $this->applicationAccessor->getApplicationSecure($application_id,Auth::user()->id);
        return view($this->viewPrefix.'applications.edit', ['application' => $data->data]);
    }

    public function update (Request $request) {
        $application_id = $request->route()->parameter('application_id');
        $resp = $this->applicationAccessor->createOrUpdate($request->all(), Auth::user()->id,$application_id);
        if($resp->getStatus()){
            return redirect()
                ->route('application.show',['application_slug'=>$resp->data->route_prefix,'application_id'=>$resp->data->id])
                ->withErrors($resp->errors)
                ->withInput($request->all());
        }else{
            return redirect()
                ->back()
                ->withErrors($resp->errors)
                ->withInput($request->all());
        }
    }

    public function show (Request $request){
        $application_id = $request->route()->parameter('application_id');
        $resp = $this->applicationAccessor->getApplicationSecure($application_id,Auth::user()->id);

        return view($this->viewPrefix.'applications.show', ['application' => $resp->data]);
    }

    public function destroy (Request $request){
        $application_id = $request->route()->parameter('application_id');
        $data = $this->applicationAccessor->destroyApplication($application_id,Auth::user()->id);
        return redirect()->route('application.index');
    }
}
