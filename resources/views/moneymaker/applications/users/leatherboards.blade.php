@extends('moneymaker.layouts.main')

@section('title', 'Application Users')

@section('content')
    <div class="container">
        <div class="col-sm-offset-1 col-sm-9">
            <h1 style="text-align: left;">"{{$application->name}}" Users</h1>
            <hr style="width:250px;" align="left">

            <div class="list-group">
                <table class="table-hover table">
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>State</th>
                    {{--<th>Details</th>--}}
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->state===1)
                                <button class="js-user-unblock btn btn-primary">Unblock</button>
                            @else
                                <button class="js-user-block btn btn-danger">Block</button>
                            @endif
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