@extends('moneymaker.layouts.main')

@section('title', 'Application Users')


@section('scripts')
    @parent
    <script src="{{ URL::asset('js/app/moneymaker/user.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="col-sm-offset-1 col-sm-9">
            <h1 style="text-align: left;">"{{$application->name}}" Users</h1>
            <hr style="width:250px;" align="left">

            <input type="hidden" id="appId" value="{{$application->id}}"/>
            <input type="hidden" id="appSlug" value="{{$application->route_prefix}}"/>
            <div class="list-group">
                <table class="table-hover table">
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>{{ config('moneymaker.leaderboards.coin.name') }}</th>
                    <th>{{ config('moneymaker.leaderboards.ingot.name') }}</th>
                    <th>State</th>
                    <th></th>
                    {{--<th>Details</th>--}}
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->getCoinScoreAttribute() }}</td>
                        <td>{{ $user->getIngotScoreAttribute() }}</td>
                        <td>
                            @if($user->state===1)
                                <button class="js-user-unblock btn btn-primary" data-state="2" data-user-id="{{$user->id}}">Unblock</button>
                            @else
                                <button class="js-user-block btn btn-danger"  data-state="1" data-user-id="{{$user->id}}">Block</button>
                            @endif
                        </td>
                        <td>
                            <button class="js-user-delete btn btn-danger"  data-user-id="{{$user->id}}">Delete</button>
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
@endsection