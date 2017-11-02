<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <title>@yield('appName',config('app.name')) - @yield('title')</title>
        <meta name="description" content="@yield('description')" />
        <meta name="keyword" content="@yield('keywords')" />
        <meta name="charset" content="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        @section('default-styles')
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
            <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
            <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
            <link href="{{ URL::asset('css/app/commons.min.css') }}" rel="stylesheet" type="text/css" />
            <link rel="stylesheet" href="https://unpkg.com/flatpickr/dist/flatpickr.min.css">
            <link href="{{ URL::asset('css/app/moneymaker/style.min.css') }}" rel="stylesheet" type="text/css" />
        @show
        @yield('head')
        @yield('styles')
    </head>

    <body class="page-body">
    @section('main-header')
        @include('partials/main-header')
    @show

    <div>
        @if(Auth::check() && !empty($DashboardNavbar))
            @section('sidebar')

                    <div class="sidenav col-xs-3 col-lg-2 padding-none">
                        {!! $DashboardNavbar->asUl() !!}
                    </div>

            @show

            @section('content-container')
                <div class="col-xs-9 col-lg-10 col-xs-offset-3 col-lg-offset-2 main-content-container">
                    <div class="margin-top-main-content">
                        @yield('content')
                    </div>
                </div>
            @show
        @else
            <div class="container main-content-container">
                <div class="margin-top-main-content">
                    @yield('content')
                </div>
            </div>
        @endif
    </div>

    @section('main-footer')
        @include('partials/footer')
    @show

        @include('partials/templates')
        @include('partials/ajax-urls')

        @section('default-scripts')
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
            <script src="https://unpkg.com/flatpickr@3.0.6/dist/flatpickr.min.js"></script>
            {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js"></script>--}}
            <script src="{{ URL::asset('js/manifest.js') }}"></script>
            <script src="{{ URL::asset('js/app/commons.js') }}"></script>
        @show
        @yield('scripts')

        @if(Auth::check())
            <input type="hidden"
                id="user-info"
                data-is-logged-in="true"
                data-timezone=""
                data-imagePath="{{ Auth::user()->user_image_url  }}"
                data-name="{{ Auth::user()->name }}"
                data-id="{{ Auth::user()->id }}"
            />
        @else
            <input type="hidden"
                id="user-info"
                data-timezone=""
                data-name=""
                data-imagePath=""
                data-is-logged-in="false"
                data-id=""
                />
        @endif
    </body>
</html>