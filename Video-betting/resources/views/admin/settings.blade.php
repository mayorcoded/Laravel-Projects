@extends('layout.master')

@section('content')
    <div class="contents">
        <div class="custom-container">
            <div class="row">
                <!-- Bread Crumb Start -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{route('index')}}">Home</a></li>
                        <li class="active">Admin - Settings</li>
                    </ol>
                </div>
                <!-- Bread Crumb End -->
                <!-- Content Column Start -->
                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 equalcol conentsection">
                    <!-- Contents Section Started -->
                    <div class="sections">
                        <h2 class="heading">Settings</h2>
                        <div class="clearfix"></div>
                        <div class="panel panel-danger">
                            @if(isset($error))
                            <div class="alert alert-danger">{{$error}}</div>
                            @endif
                            @if(isset($success))
                            <div class="alert alert-success">{{$success}}</div>
                            @endif
                            <form class="form-horizontal" role="form" method="post" action="{{route('settings.update')}}">
                                {{csrf_field()}}
                                <div class="panel-heading">
                                        <h2 class="panel-title">Settings</h2>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="winning-limits" class="col-sm-2 control-label">Winning Limits:</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" id="winning-limits"
                                                   placeholder="Limits of cash outs"
                                                   name="cash_out_limit"
                                                   value="{{$settings->get('cash_out_limit')}}">
                                            <div class="text text-danger">{{isset($cash_out_limit_error)?$cash_out_limit_error:''}}</div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="game-limits" class="col-sm-2 control-label">Game Limits:</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" id="game-limits"
                                                   placeholder="Limits of games a person can play"
                                                   name="game_limits"
                                                   value="{{$settings->get('game_limits')}}">
                                            <div class="text text-danger">{{isset($game_limits_error)?$game_limits_error:''}}</div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="stake-limits" class="col-sm-2 control-label">Stake Limits:</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" id="stake-limits"
                                                   placeholder="Limits of amount a person can put down"
                                                   name="stake_limits"
                                                   value="{{$settings->get('game_limits')}}">
                                            <div class="text text-danger">{{isset($stake_limits_error)?$stake_limits_error:''}}</div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="betting-credit" class="col-sm-2 control-label">Free Betting Credit:</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" id="stake-limits"
                                                   placeholder="Amount of betting credit a person gets on first login"
                                                   name="starting_credit"
                                                   value="{{$settings->get('starting_credit')}}">
                                            <div class="text text-danger">{{isset($starting_credit_error)?$starting_credit_error:''}}</div>

                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <button type="submit" class="btn btn-primary backcolor"><span class="fa fa-save"></span> Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <!-- Contents Section End -->
                </div>
                <!-- Content Column End -->
                <!-- Gray Sidebar Start -->
                @include('layout.admin-menu')
                        <!-- Gray Sidebar End -->
            </div>
        </div>
    </div>
@endsection