@extends('layouts.main')

@section('sidebar')
    @if(Auth::check() && !empty($DashboardNavbar))
        <div class="sidenav">
            {!! $DashboardNavbar->asUl() !!}
        </div>
    @endif
@endsection
@section('styles')
    @parent
    <link href="{{ URL::asset('css/app/moneymaker/style.min.css') }}" rel="stylesheet" type="text/css" />
@endsection