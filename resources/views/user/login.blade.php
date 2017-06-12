@extends('layouts.main ')

@section('title')
    Sign in or Register
@endsection
@section('content')
    <div class="container" style="min-height: 100vh;">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(Session::has(\App\Classes\SessionHelper::$MESSAGE_LOGIN_PAGE))
                    <div class="alert alert-info">
                        <strong>{{ Session::get(\App\Classes\SessionHelper::$MESSAGE_LOGIN_PAGE) }}</strong>
                    </div>
                @endif

                <div class="panel panel-primary">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">
                        <form id="user-login-form" class="form-horizontal js-ajax-form" role="form" data-form="simpleform" method="POST" action="{{ route('users.login') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                    <div class="form-error" data-error="email"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                    <div class="form-error" data-error="password"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <a style="text-decoration: underline; padding-left: 250px;" href="{{ route('users.forgot-password') }}">Forgot your password</a>

                            <div class="form-group" style="margin-top: 10px;">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection