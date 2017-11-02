@extends('layouts.main')

@section('appName')
    @parent
    {{ $application->name }}
@endsection


@section('styles')
    @parent
@endsection