<?php
/**
 * @var \App\Applications\BaseApplication $applicationConfig
 */
?>
@extends('moneymaker.layouts.main')

@section('title', 'edit')

@section('content')
    @parent
        <div>
            <h2>Edit Application Name</h2>
            <form action="{{ route($applicationConfig->getRouteNamePrefix().'application.update', ['application_id' => $application->id]) }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="put">
                @include('moneymaker.partial.application-form', ['application' => $application, 'submitButton' => 'Edit'])
            </form>
        </div>
@endsection