<?php
/**
 * @var \App\Applications\BaseApplication $applicationConfig
 */
?>
@extends('moneymaker.layouts.main')

@section('title', 'create')

@section('content')
    @parent
        <div>
            <div>
                <strong>Application Name: </strong>
                <br>&nbsp&nbsp{{ $application->name }}<br>
                <strong>API token: </strong><br>
                <span style="word-break: break-all;">&nbsp&nbsp{{ $application->api_token }}</span>
            </div>
            <br/>
            <div>
                <a class="btn btn-warning btn-sm" href="{{ route($applicationConfig->getRouteNamePrefix().'application.edit', ['application_id' => $application->id]) }}">Edit</a>
                {{--<form action="{{ route($applicationConfig->getRouteNamePrefix().'application.destroy', ['application_id' => $application->id]) }}" method="post" style="display:inline-block;">--}}
                    {{--{{ csrf_field() }}--}}
                    {{--<input type="hidden" name="_method" value="delete">--}}
                    {{--<button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this application?');" type="submit" value="Delete">Delete</button>--}}
                {{--</form>--}}
            </div>
        </div>
@endsection