@extends('moneymaker.layouts.main')

@section('title', 'create')

@section('content')
    <div class="container">
        <div class="col-md-offset-2 col-md-8">
            <h2>Create Application</h2>
            <hr style="width:360px;" align="left">
            <form action="{{ route('application.store') }}" method="post">
                {{ csrf_field() }}
                @include('moneymaker.partial.application-form', ['submitButton' => 'Create'])
            </form>
        </div>
    </div>
@endsection
