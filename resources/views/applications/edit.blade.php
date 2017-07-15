@extends('layouts.main')

@section('title', 'edit')

@section('content')
    <div class="container">
        <div class="col-md-offset-2 col-md-8">
            <h2>Edit Application Name</h2>
            <hr style="width: 400px;" align="left;">
            <form action="{{ route('application.update', ['application_id' => $application->id]) }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="put">
                @include('partials.application-form', ['application' => $application, 'submitButton' => 'Edit'])
            </form>
        </div>
    </div>
@endsection