@extends('layouts.main')
@section('title')
    Account Confirmation
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Confirm Account</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('users.send-confirmation-mail') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <div class="col-sm-12">
                                    Your account email is not verified. View your email to receive instruction to verify your account
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Didn't Receive Email! Click Here
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
