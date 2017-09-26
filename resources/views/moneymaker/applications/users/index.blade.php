@extends('moneymaker.layouts.main')

@section('title', 'Application Users')

@section('styles')
    <style>
        @media screen and (min-width: 600px){
            .modal-dialog{
                width: 80%;
            }
        }
    </style>
@endsection

@section('scripts')
    @parent
    <script src="{{ URL::asset('js/app/moneymaker/user.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="col-sm-offset-1 col-sm-11">
            <h1 style="text-align: left;">"{{$application->name}}" Users</h1>
            <hr style="width:250px;" align="left">

            <input type="hidden" id="appId" value="{{$application->id}}"/>
            <form id="filter-form"></form>

            <div class="list-group">
                <table class="table-hover table">
                    <tr>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>{{ config('moneymaker.leaderboards.coin.name') }}</th>
                        <th>{{ config('moneymaker.leaderboards.ingot.name') }}</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <input value="{{ request()->get('exact_username') }}" form="filter-form" name="exact_username" type="text" class="form-control" placeholder="Exact Username" />
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>
                            <button class="btn btn-primary" form="filter-form">Filter</button>
                        </th>
                    </tr>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->getCoinScoreAttribute() }}</td>
                        <td>{{ $user->getIngotScoreAttribute() }}</td>
                        <td>
                            {{ $user->country  }}
                        </td>
                        <td>
                            @if($user->state===1)
                                <button class="js-user-unblock btn btn-primary" data-state="{{ \App\Models\AppUser::$STATE_ACTIVE }}" data-user-id="{{$user->id}}">Unblock</button>
                            @else
                                <button class="js-user-block btn btn-danger"  data-state="{{ \App\Models\AppUser::$STATE_BLOCKED }}" data-user-id="{{$user->id}}">Block</button>
                            @endif
                        </td>
                        <td>
                            <button class="js-user-delete btn btn-danger"  data-user-id="{{$user->id}}">Delete</button>
                            <button class="js-analytics-detail btn btn-danger"  data-uid="{{$user->id}}">View Analytics</button>
                        </td>
                    </tr>
                @endforeach
                </table>

                <div class="center-block text-center">
                    {{$users->links()}}
                </div>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog" style="">

            <!-- Modal content-->
            <div class="modal-content" style="margin-top: 100px;">
                <div class="modal-header" style="background-color: #8A4F94;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Analytics</h4>
                </div>
                <div class="modal-body" style="max-height: 500px;overflow-y: scroll;">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#screens">Visited Screens</a></li>
                        <li><a data-toggle="tab" href="#events">Events</a></li>
                    </ul>
                    <br>
                    <div class="tab-content">
                        <div id="screens" class="tab-pane fade in active">
                            <div class="col-md-6" style="padding-right: 0px;padding-left: 0px;">
                                <p><b>Username:</b> <span class="username"></span></p>
                                <p><b>Emal:</b> <span class="email"></span></p>
                            </div>
                            <div class="col-md-6" style="padding-right: 0px;padding-left: 0px;">
                                <div class="form-group col-md-6 col-md-offset-6" style="padding-right: 0px;padding-left: 0px;">
                                    <label for="date">Search By Dates:</label>
                                    <input data-attr="value"
                                           type="text"
                                           data-dateFormat="Y-m-d"
                                           data-altFormat="Y-m-d"
                                           data-mode="range"
                                           data-enableTime="false"
                                           class="form-control date js-flatpickr">
                                    <br>
                                    <input type="button" name="search" class="js-analytics-by-date btn btn-success" value="Search">
                                </div>
                            </div>
                            <table class="display" style="width: 100%"></table>
                        </div>
                        <div id="events" class="tab-pane fade">
                            <div class="col-md-6" style="padding-right: 0px;padding-left: 0px;">
                                <p><b>Username:</b> <span class="username"></span></p>
                                <p><b>Emal:</b> <span class="email"></span></p>
                            </div>
                            <div class="col-md-6" style="padding-right: 0px;padding-left: 0px;">
                                <div class="form-group col-md-6 col-md-offset-6" style="padding-right: 0px;padding-left: 0px;">
                                    <label for="date">Search By Dates:</label>
                                    <input data-attr="value"
                                           type="text"
                                           data-dateFormat="Y-m-d"
                                           data-altFormat="Y-m-d"
                                           data-mode="range"
                                           data-enableTime="false"
                                           class="form-control date js-flatpickr">
                                    <br>
                                    <input type="button" name="search" class="js-analytics-by-date btn btn-success" value="Search">
                                </div>
                            </div>
                            <table class="display" style="width: 100%"></table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    @include('partials.piwk-info',['application'=>$application])
@endsection