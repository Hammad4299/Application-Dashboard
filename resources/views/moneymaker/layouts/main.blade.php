@extends('layouts.main')

@section('appName')
    @parent
    {{$application->name}}
@endsection

@section('sidebar')
    @if(Auth::check() && !empty($DashboardNavbar))
        <div class="sidenav">
            {!! $DashboardNavbar->asUl() !!}
        </div>
    @endif
@endsection
@section('styles')
    @parent

@endsection