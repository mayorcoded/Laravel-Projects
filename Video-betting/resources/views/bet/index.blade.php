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
                            <div >
                                <h2>My Cart Items</h2>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <td>
                                                S/N
                                            </td>
                                            <td>
                                                Video
                                            </td>
                                            <td>
                                                Video Views
                                            </td>
                                            <td>
                                                Bet Views
                                            </td>
                                            <td>
                                                Odds
                                            </td>
                                            <td>
                                                Amount to be placed
                                            </td>
                                            <td>
                                                price
                                            </td>
                                            <td>
                                                Bet period
                                            </td>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $total_pay = 0;
                                        $total_price = 0;
                                        ?>
                                        @foreach($bets as $key => $bet)
                                            <?php
                                                $v_ = $bet->video()->first();
                                            ?>
                                            <tr>
                                                <td><strong>{{($key+1)}}.</strong></td>
                                                <td><a href="#">{{$v_->title}}</a></td>
                                                <td><span class="badge">{{$v_->views}} views</span> </td>
                                                <td><span class="badge">{{$bet->maximum_views}} views </span> </td>
                                                <td><span class="badge">{{$bet->odds}}</span> </td>
                                                <td><span class="badge">#{{$bet->amount_deposited}}</span> </td>
                                                <td><span class="badge">#{{$bet->price}}</span> </td>
                                                <td><span class="badge">{{\App\Http\Controllers\Bet\BetItem::duration($bet->expiry_date,$bet->created_at)}}</span> </td>
                                                <td>
                                                    <div class="btsn-group" style="display: flex;">
                                                        <button class="btn btn-info" onclick="startUpdateCartItem('{{$bet->item_id}}')"  style="padding: 2px; display: inline-block;"><i class="fa fa-edit"></i></button>
                                                        <a class="btn btn-danger" style="padding: 2px; display: inline-block;" href="{{route('bet.cart.item.delete', $bet->item_id)}}"><i class="fa fa-trash-o"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            $total_pay += $bet->amount_deposited;
                                            $total_price += $bet->price;
                                            ?>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr style="background-color: #ffd6ce; color: #5a5a5a; text-align: right">
                                            <td></td>
                                            <td colspan="4"><strong>Total Pay: {{isset($total_pay) ? $total_pay : 0}}</strong></td>
                                            <td colspan="4"><strong>Total Price: {{isset($total_price) ? $total_price : 0}}</strong></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="pull-right">
                                    <form action="{{route('bet.cart.get')}}">
                                        <button class="btn btn-info" style="font-size: 20px;" type="submit">Checkout Bet Items...</button>
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
                    <i class="fa fa-apple"></i>
                </span>
                <span class="text text-primary" style="font-size: 30px; display: block; padding: 5px; background-color: #cbc9be; border-radius: 10px;">Loading bet slip...</span>
            </div>
        </div>
    </div>


    <div id="betS232" class="modal fade in" role="dialog">
        <div class="modal-dialog">
            <div class="loading-anim" style="text-align: center; color: white; padding-top: 30px;">
                <span class="" style="font-size: 150px; display: block;">
                    <i class="fa fa-apple"></i>
                </span>
                <span class="text text-primary" style="font-size: 30px; display: block; padding: 5px; background-color: #cbc9be; border-radius: 10px;">Loading bet...</span>
            </div>
        </div>
    </div>
    <?php
    $reload = true;
    ?>
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