@extends('layouts.main')
@section('title', 'Application DashBoard')

@section('content')

                <h1 style="text-align: left;">Applications</h1>
                <hr style="width:250px;" align="left">

                <div class="list-group">
                    @foreach($applications as $app)
                        <?php $appConfig = \App\Applications\BaseApplication::getApplication($app->mapped_name) ?>
                        <a href="{{ route($appConfig->getRouteNamePrefix().'application.show', ['application_id' => $app->id]) }}" class="list-group-item">
                            <strong>Application Name: </strong>
                            {{ $app->name }}
                        </a>
                    @endforeach
                </div>

@endsection