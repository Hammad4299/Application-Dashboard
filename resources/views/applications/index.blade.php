@extends('moneymaker.layouts.main')
@section('title', 'Application DashBoard')

@section('content')
    <div class="container">
        <div class="sidenav">
            {!! $DashboardNavbar->asUl() !!}
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-8">
                <h1 style="text-align: left;">Applications</h1>
                <hr style="width:250px;" align="left">

                <div class="list-group">
                    @foreach($applications as $app)
                        <a href="{{ route('application.show', ['application_id' => $app->id,'application_slug'=>$app->route_prefix]) }}" class="list-group-item">
                            <strong>Application Name: </strong>
                            {{ $app->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection