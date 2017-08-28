@extends('moneymaker.layouts.main')

@section('title', 'create')

@section('content')
    <div class="container">
        <div class="col-sm-offset-1 col-sm-9">
            <div>
                <strong>Application Name: </strong>
                <br>&nbsp&nbsp{{ $application->name }}<br>
                <strong>API token: </strong><br>
                <span>&nbsp&nbsp{{ $application->api_token }}</span>
            </div>
            <br/>
            <div>
                <a class="btn btn-warning btn-sm" href="{{ route('application.edit', ['application_id' => $application->id,'application_slug'=>$application->route_prefix]) }}">Edit</a>
                <form action="{{ route('application.destroy', ['application_id' => $application->id,'application_slug'=>$application->route_prefix]) }}" method="post" style="display:inline-block;">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="delete">
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this application?');" type="submit" value="Delete">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection