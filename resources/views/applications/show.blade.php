@extends('layouts.main')

@section('title', 'create')

@section('content')
    <div class="container">
        {!! $DashboardNavbar->asUl() !!}
        <div class="col-md-8">
            <div>
                <strong>Application Name: </strong>
                <br>{{ $application->name }}<br>
                <strong>API token: </strong><br>
                <span>{{ $application->api_token }}</span>
            </div>
            <div>
                <a class="btn btn-warning btn-sm" href="{{ route('application.edit', ['application_id' => $application->id]) }}">Edit</a>
                <form action="{{ route('application.destroy', ['application_id' => $application->id]) }}" method="post" style="display:inline-block;">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="delete">
                    <button class="btn btn-danger btn-sm" type="submit" value="Delete">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection