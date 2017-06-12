@extends('layouts.main')

@section('title')
    Profile
@endsection

@section('breadcrumbs')

@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <span style="font-size: large">{{ $user->name }} : Profile</span>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('users.save-profile', ['user_id' => $user->id]) }}" class="js-ajax-form form-horizontal" method="post" data-form="simpleform" role="form">

                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Name:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                                    <div class="form-error" data-error="name"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Email:</label>
                                <div class="col-md-9">
                                    <input type="text" class=" form-control" name="email" value="{{ $user->email }}" disabled>
                                    <div class="form-error" data-error="email"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Old Password:</label>
                                <div class="col-md-9">
                                    <input type="password" class=" form-control" name="old_password" value="">
                                    <div class="form-error" data-error="old_password"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Password:</label>
                                <div class="col-md-9">
                                    <input type="password" class=" form-control" name="password" value="">
                                    <div class="form-error" data-error="password"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-3 control-label">Confirm Password</label>

                                <div class="col-md-9">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                    <div class="form-error" data-error="password_confirmation"></div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary pull-right">Save</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection