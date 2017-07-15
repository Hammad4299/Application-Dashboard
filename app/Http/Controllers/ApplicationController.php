<?php

namespace App\Http\Controllers;

use App\Models\ModelAccessor\ApplicationAccessor;
use Illuminate\Http\Request;
use Lavary\Menu\Builder;
use Lavary\Menu\Menu;

class ApplicationController extends Controller
{
    public $applicationAccessor;
    public function __construct(ApplicationAccessor $accessor){
        $this->applicationAccessor = $accessor;
    }

    public function index () {
        $resp = $this->applicationAccessor->getallApplications();
        return view('applications.index',
            [
                'applications' => $resp->data
            ]);
    }

    public function create () {
        return view('applications.create');
    }

    public function store (Request $request) {
        $resp = $this->applicationAccessor->createOrUpdate($request->all());
        $applications = $this->applicationAccessor->getAllApplications();
        return redirect()
            ->route('application.index', ['applications' => $applications])
            ->withErrors($resp->errors)
            ->withInput($request->all());
    }

    public function edit ($application_id) {
        $data = $this->applicationAccessor->findByID($application_id);
        return view('applications.edit',
            ['application' => $data->data]);
    }

    public function update (Request $request, $application_id) {
        $app = $this->applicationAccessor->findByID($application_id);
        $resp = $this->applicationAccessor->createOrUpdate($request->all(), $app->data);
        return redirect()
            ->route('application.index');
    }

    public function show ($application_id){
        $resp = $this->applicationAccessor->findByID($application_id);
        return view('applications.show',
            ['application' => $resp->data, 'applications' => '']);
    }

    public function destroy ($application_id){
        $data = $this->applicationAccessor->destroyApplication($application_id);
        return redirect()
            ->route('application.index');
    }
}
