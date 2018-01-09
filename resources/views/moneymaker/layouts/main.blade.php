@extends('layouts.main')

@section('appName')
    @parent
    {{ $application->name }}
@endsection


@section('styles')
    @parent
    <link href="{{ assetUrl('moneymaker/commons.css') }}" rel="stylesheet" type="text/css" />
@endsection