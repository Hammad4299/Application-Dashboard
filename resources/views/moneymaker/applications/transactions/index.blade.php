<?php
/**
 * @var \App\Applications\BaseApplication $applicationConfig
 */
?>
@extends('moneymaker.layouts.main')

@section('title', 'Application Transactions')


@section('scripts')
    @parent
    <script src="{{ URL::asset('js/app/moneymaker/transaction.js') }}"></script>
@endsection

@section('content')
    @parent
    @section('scripts')
        <script>
            $(document).ready(function(){
                var tab=$('input[name=tab]').val();
                $('.nav-tabs li a:contains('+tab+')').parent().addClass('active');
            });
        </script>
    @endsection
    <div>
        <input type="hidden" id="appId" value="{{$application->id}}"/>
        <input type="hidden" id="appSlug" value="{{$application->route_prefix}}"/>
        <div>
            <h1 style="text-align: left;">"{{$application->name}}" Transactions</h1>

            <input type="hidden" name="tab" value="{{$tab}}"/>
            <div class="list-group">
                <ul class="nav nav-tabs">
                    <li id="pending"><a href="{{route($applicationConfig->getRouteNamePrefix().'application.transactions.pending',['application_id'=>$application->id]) }}">Pending</a></li>
                    <li id="accepted"><a  href="{{route($applicationConfig->getRouteNamePrefix().'application.transactions.accepted',['application_id'=>$application->id]) }}">Accepted</a></li>
                    <li id="rejected"><a  href="{{route($applicationConfig->getRouteNamePrefix().'application.transactions.rejected',['application_id'=>$application->id]) }}">Rejected</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active">
                        <br/><br/>
                        <table class="table-bordered table table-striped">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>User ID</th>
                                    <th>Amount</th>
                                    @if($tab==='Pending')
                                        <th colspan="2">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                        @foreach($transactions as $tran)
                            <tr>
                                <td>{{ $tran->getUsername($tran->app_user_id) }}</td>
                                <td>{{ $tran->app_user_id }}</td>
                                <td>{{config('moneymaker.currency')}}{{ $tran->amount }}</td>
                                @if($tab==='Pending')
                                    @if($tran->status===\App\Models\AppUserTransaction::$STATUS_PENDING)
                                        <td class="text-center">
                                            <button class="js-transaction-accept btn btn-primary" data-status="{{ \App\Models\AppUserTransaction::$STATUS_ACCEPTED }}"  data-trans-id="{{$tran->id}}">Accept</button>
                                        </td>
                                        <td class="text-center">
                                            <button class="js-transaction-reject btn btn-danger" data-status="{{ \App\Models\AppUserTransaction::$STATUS_REJECTED }}" data-trans-id="{{$tran->id}}">Reject</button>
                                        </td>
                                    @else
                                        <td class="text-center" colspan="2">
                                            <span class="text-center status-text" >{{  $tran->status_str }}</span>
                                        </td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                        </table>

                        <div class="center-block text-center">
                            {{$transactions->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection