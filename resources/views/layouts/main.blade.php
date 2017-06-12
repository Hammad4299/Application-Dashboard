<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <title>{{ config('app.name') }} - @yield('title')</title>
        <meta name="description" content="@yield('description')" />
        <meta name="keyword" content="@yield('keywords')" />
        <meta name="charset" content="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ URL::asset('/css/app/shared.css') }}" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css"/>
        <link rel="stylesheet" href="{{ URL::asset('/css/libs/jquery.toast.min.css') }}">

        <link rel="stylesheet" href="{{ URL::asset('/toolbarjs/jquery.toolbar.css') }}" />
        @yield('head') 
        @yield('styles')
    </head>

    <body class="page-body">
    <a href="" download id="download-anchor" class="hidden"></a>
        @include('partials/main-header')
            @yield('breadcrumbs')
        <div style="min-height: 100vh" class="clearfix">
            @yield('content')
        </div>
        @if(!isset($hideFooter) || !$hideFooter) 
            @include('partials/footer') 
        @endif

        @include('modals.confirmation-dialog')
        @include('modals.create-group')
        @include('modals.checklist-subtitle')
        @include('modals.edit-checklist-title')
        @include('modals.generate-sigpage')
        @include('partials/templates')
        @include('partials/ajax-urls')
        <input type="hidden" id="tinymce-css" value="{{ URL::asset('/css/app/tinymce.css') }}" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

        <script src="{{ URL::asset('/toolbarjs/jquery.toolbar.min.js') }}"></script>
        <script src='{{ URL::asset('/js/tinymce/tinymce.min.js') }}'></script>
        <script src="{{ URL::asset('/js/app/time.js') }}"></script>
        <script src="{{ URL::asset('/js/app/main.js') }}"></script>
        <script src="{{ URL::asset('/js/app/FormSubmitters/FormSubmitter.js') }}"></script>
        <script src="{{ URL::asset('/js/app/ajax.js') }}"></script>
        <script src="{{ URL::asset('/js/app/order.js') }}"></script>
        <script src="{{ URL::asset('/js/app/resources/AutoloadHelper.js') }}"></script>
        <script src="{{ URL::asset('/js/app/resources/CrudHelper.js') }}"></script>
        <script src="{{ URL::asset('/js/app/resources/ChecklistDropdown.js') }}"></script>
        <script src="{{ URL::asset('/js/app/resources/VersionDropdown.js') }}"></script>
        <script src="{{ URL::asset('/js/app/resources/DocumentGroupDropdown.js') }}"></script>
        <script src="{{ URL::asset('/js/libs/jquery.toast.min.js') }}"></script>

        @yield('scripts')

        @if(Auth::check())
            <input type="hidden"
                    id="user-info"
                    data-is-logged-in="true"
                    data-timezone=""
                    data-id="{{ Auth::user()->id }}"
                />
        @else
            <input type="hidden"
                id="user-info"
                data-timezone=""
                data-is-logged-in="false"
                data-id=""
                />
        @endif
    </body>
</html>