@extends('layout.master')

@section('content')
    <div class="contents">
        <div class="custom-container">
            <div class="row">
                <!-- Bread Crumb Start -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Profile</li>
                    </ol>
                </div>
                <!-- Bread Crumb End -->
                <!-- Content Column Start -->
                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 equalcol conentsection">
                    <!-- Contents Section Started -->
                    <div class="sections">
                        <div class="clearfix"></div>
                        <!-- Nav tabs -->
                        <div class="tabsect">
                            <ul class="nav nav-tabs" id="newTab">
                                <li class="active"><a href="#home" data-toggle="tab">Profile</a></li>
                                <li id="wallet-bar"><a href="#profile" data-toggle="tab">Wallet</a></li>
                                <li><a href="#messages" data-toggle="tab">Bet History</a></li>
                                <li id="settings-bar"><a href="#settings" data-toggle="tab">Settings</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane {{(isset($msg) ? '' : 'active')}}" id="home">
                                    {{-- User Details --}}
                                    <div class="text-center">
                                        <h2><img src="{{Auth::user()->avatar}}" class="profile-pic"></h2>
                                        <h3>{{$user->fullname}}</h3>
                                        <h4>{{$user->email}}</h4>
                                        <h4>{{$user->mobile_number}}</h4>
                                    </div>
                                </div>
                                <div class="tab-pane" id="profile">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="btn btn-block text-center btn-warning" onclick="checkIfAccountExist('withdrawal')">
                                                <span class="fa fa-minus-circle fa-5x"></span>
                                                <h4>WITHDRAW</h4>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="text-center">
                                                        <h1 class="fa-5x" id="balance"> ₦{{$user->balance}}</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="btn btn-block text-center btn-success"  onclick="checkIfAccountExist('deposit')">
                                                <span class="fa fa-plus-circle fa-5x"></span>
                                                <h4>DEPOSIT</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h2>Transaction History</h2>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped" id="transactiontable">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>Transaction Type</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th>Issuer</th>
                                                <th>Date Created</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transactions as $key => $trans)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{\App\Http\Controllers\Bet\BetItem::trailingChar($trans->transaction_id,8)}}</td>
                                                        <td>{{$trans->transaction_type}}</td>
                                                        <td>{{\App\Http\Statuses\TransactionStatus::statusMessage($trans->status)}}</td>
                                                        <td>N{{number_format( $trans->amount )}}</td>
                                                        <td>MVB</td>
                                                        <td>{{$trans->created_at}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            {{ $transactions->links() }}
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="messages">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Slip ID</th>
                                                <th>No of Videos</th>
                                                <th>Amount</th>
                                                <th>Duration</th>
                                                <th>Status</th>
                                                <th>Date Created</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $key=0;

                                            function us_($bet){
                                                switch ($bet->status){
                                                    case \App\Http\Statuses\BetStatus::LOSE:
                                                        return '<span class="bet-lose"><i class="fa fa-level-down"></i> '.$bet->amount.'</span>';
                                                        break;
                                                    case \App\Http\Statuses\BetStatus::WIN:
                                                        return '<span class="bet-win"><i class="fa fa-level-up"></i> '.$bet->amount.'</span>';
                                                        break;
                                                    case \App\Http\Statuses\BetStatus::ONGOING:
                                                        return '<span class="bet-win"><i class="fa fa-play"></i> '.$bet->amount.'</span>';
                                                        break;
                                                }
                                            }
                                            ?>
                                            @foreach($bets as $bet)
                                            <tr data-toggle="modal" data-target="#betslip" onclick="loadSlip({{$bet->bet_id}})">
                                                <td>{{++$key}}</td>
                                                <td>{{App\Http\Controllers\Bet\BetItem::trailingChar($bet->bet_id,8)}}</td>
                                                <td>{{count(explode(',',$bet->videos))}}</td>
                                                <td><?php
                                                        echo us_($bet);
                                                    ?></td>
                                                <td><a href="#">{{\App\Http\Controllers\Bet\BetItem::duration($bet->created_at,$bet->expiry_date)}}</a></td>
                                                <td>{{strtoupper(\App\Http\Statuses\BetStatus::status($bet->status))}}</td>
                                                <td>{{$bet->created_at}}</td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                                    </table>
                                </div>
                                        <div class="pagination">
                                            {!! $bets->render() !!}
                                    </div>
                                </div>
                                <div class="tab-pane {{!isset($msg) ? '' : 'active'}}" id="settings" tabindex="1">
                                    <form role="form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <h2>Account Details Update</h2>
                                        <p class="text text-warning">Your account detail is for payment only, it will not be shared to the public</p>
                                        <div class="form-group">
                                            @if(isset($msg))
                                                <div class="alert alert-{{$msg['status'] ? 'success' : 'danger'}}">
                                                    {{$msg['status'] ? $msg['message'] : 'We could not update your account info because some errors were found. please check and correct all '}}
                                                </div>
                                            @endif
                                        </div>
                                        <?php
                                            $style = '';
                                            if(isset($msg)){
                                                $style = $msg['status'] ? 'style="border-color: green;"' : 'style="border-color: red;"';
                                            }

                                        ?>
                                        <div class="form-group">
                                            <label for="account_name">Account Name</label>
                                            <input value="{{$account_name}}" {!! (isset($msg) && !$msg['status'] && $msg['message']['account_name'] != '') ? $style : '' !!} placeholder="Your account name with correct order" name="account_name" class="form-control" type="text">
                                            <span class="text text-danger">{!! (isset($msg) && !$msg['status'] && $msg['message']['account_name'] != '') ? $msg['message']['account_name'] : '' !!}</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="account_number">Account Number</label>
                                            <input value="{{$account_number}}" {!! (isset($msg) && !$msg['status'] && $msg['message']['account_number'] != '') ? $style : '' !!} placeholder="Your account number" name="account_number" class="form-control" type="number">
                                            <span class="text text-danger">{!! (isset($msg) && !$msg['status'] && $msg['message']['account_number'] != '') ? $msg['message']['account_number'] : '' !!}</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="account_number">Bank</label>
                                            <input value="{{$bank}}"  {!! (isset($msg) && !$msg['status'] && $msg['message']['bank'] != '') ? $style : '' !!} placeholder="your bank name" name="bank" class="form-control" type="text">
                                            <span class="text text-danger">{!! (isset($msg) && !$msg['status'] && $msg['message']['bank'] != '') ? $msg['message']['bank'] : '' !!}</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="account_number">Bank Sort Code</label>
                                            <input value="{{$bank_sort_code}}"  {!! (isset($msg) && !$msg['status'] && $msg['message']['bank_sort_code'] != '') ? $style : '' !!} placeholder="your bank name" name="bank_sort_code" class="form-control" type="text">
                                            <span class="text text-danger">{!! (isset($msg) && !$msg['status'] && $msg['message']['bank_sort_code'] != '') ? $msg['message']['bank_sort_code'] : '' !!}</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="account_number">Account Type</label>
                                            <select  {!! (isset($msg) && !$msg['status'] && $msg['message']['account_type'] != '') ? $style : '' !!} placeholder="your bank type" name="account_type" class="form-control" type="text">
                                                <option value="">Select account type</option>
                                                @foreach((new \App\Http\Statuses\BankAccountTypes())->get() as $acc)
                                                    <option {{strtolower($account_type) == $acc ? 'selected' : ''}} value="{{$acc}}">{{strtoupper($acc)}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text text-danger">{!! (isset($msg) && !$msg['status'] && $msg['message']['account_type'] != '') ? $msg['message']['account_type'] : '' !!}</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="account_number">Email</label>
                                            <input value="{{Auth::user()->email}}" disabled class="form-control" type="text">
                                        </div>

                                        <div class="form-group">
                                            <button class="form-control btn btn-info" type="submit"><i class="fa fa-user-secret"></i>Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        {{--@include('utils.video-slider')--}}
                    </div>
                    <!-- Contents Section End -->
                </div>
                <!-- Content Column End -->
                <!-- Gray Sidebar Start -->
                @include('utils.gray-sidebar')
                <!-- Gray Sidebar End -->
            </div>
        </div>
    </div>
    <div id="betslip" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="loading-anim" style="text-align: center; color: white; padding-top: 30px;">
                <span class="" style="font-size: 150px; display: block;">
                    <i class="fa fa-circle-o fa-spin"></i>
                </span>
                <span class="text text-primary" style="font-size: 30px; display: block; padding: 5px; background-color: #cbc9be; border-radius: 10px;">Loading bet slip...</span>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="{{asset('js/account.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/vendor/bootbox.min.js')}}"></script>
    <script>
        $body = $("body");

        $(document).on({
            ajaxStart: function() {
                $body.append('<div class="loader" id="load"><!-- Place at bottom of page --></div>');
                $body.addClass("loading");},
            ajaxStop: function() { $("#load").remove(); }
        });
    </script>

@stop