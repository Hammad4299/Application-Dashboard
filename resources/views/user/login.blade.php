@extends('layouts.main')

@section('title','Login')

@section('content')

    @if(Session::has(\App\Classes\SessionHelper::$MESSAGE_LOGIN_PAGE))
        <div class="alert alert-info">
            <strong>{{ Session::get(\App\Classes\SessionHelper::$MESSAGE_LOGIN_PAGE) }}</strong>
        </div>
    @endif

    <form role="form" action="{{ route('login-user') }}" method='post' class='col-xs-4' style='float:none;margin: auto'>
        {{ csrf_field() }}
        <h3 class='text-center'>Login</h3>
        <div class="form-group">
            <label for="email" class="control-label">E-Mail Address</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
            <div class="form-error" data-error="email">{{ getFirstError($errors,'email') }}</div>
        </div>

        <div class="form-group">
            <label for="password" class="control-label">Password</label>
            <input id="password" type="password" class="form-control" name="password" required>
            <div class="form-error" data-error="password">{{ getFirstError($errors,'password') }}</div>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                </label>
            </div>
        </div>

        <a style="text-decoration: underline;float: right" href="{{ route('users.forgot-password') }}">Forgot your password</a>

        <button type="submit" class="btn btn-default">Login</button>
    </form>
@endsection