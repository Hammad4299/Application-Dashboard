@extends('layouts.main')

@section('appName')
    @parent
    {{ $application->name }}
@endsection


@section('styles')
    @parent
    <link href="{{ URL::asset('css/app/moneymaker/commons.min.css') }}" rel="stylesheet" type="text/css" />
@endsection