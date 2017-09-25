@extends('moneymaker.layouts.main')

@section('title', 'Application Users')


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

    @include('partials.piwk-info',['application'=>$application])
@endsection