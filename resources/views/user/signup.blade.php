@extends('layouts.main')

@section('title','Login')

@section('content')
<div class="container">
    <form role="form" action="{{ route('create-user') }}" method='post' class='col-xs-4' style='float:none;margin: auto'>
        {{ csrf_field() }}
        <h3 class='text-center'>Sign Up</h3>
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class=" control-label">Name</label>
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
            <div class="form-error" data-error="name">{{ getFirstError($errors,'name') }}</div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class=" control-label">E-Mail Address</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
            <div class="form-error" data-error="email">{{ getFirstError($errors,'email') }}</div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class=" control-label">Password</label>
            <input id="password" type="password" class="form-control" name="password" required>
            <div class="form-error" data-error="password">{{ getFirstError($errors,'password') }}</div>
        </div>

        <div class="form-group">
            <label for="password-confirm" class=" control-label">Confirm Password</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            <div class="form-error" data-error="password_confirmation">{{ getFirstError($errors,'password_confirmation') }}</div>
        </div>
        <button type="submit" class="btn btn-default">Sign Up</button>
    </form>
</div>
@endsection