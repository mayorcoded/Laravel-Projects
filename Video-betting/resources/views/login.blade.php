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
                                <h2>Login required</h2>
                                <div class="table-responsive">
                                    <h3 style="color: #888;">Please login to continue...</h3>
                                    <div>

                                        <div class="row text-center col-lg-10 col-lg-offset-1">
                                            <div class="col-sm-6">
                                                <a href="{{route('login_facebook', "google")}}" class="btn btn-block btn-danger bg-danger upper">
                                                    <span class="fa fa-google-plus-square"></span>
                                                    <b>Login</b>
                                                </a>
                                            </div>
                                            <div class="col-sm-6">
                                                <a href="{{route('login_facebook', "facebook")}}" class="btn btn-block btn-primary bg-primary">
                                                    <span class="fa fa-facebook-square"></span>
                                                    Login
                                                </a>
                                            </div>

                                        </div>
                                    </div>
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
{{--            @include('utils.gray-sidebar')--}}
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