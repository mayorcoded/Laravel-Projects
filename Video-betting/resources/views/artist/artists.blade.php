@extends('layout.master')

@section('content')
    <div class="contents">
        <div class="custom-container">
            <div class="row">
                <!-- Bread Crumb Start -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Artists</li>
                    </ol>
                </div>
                <!-- Bread Crumb End -->
                <!-- Content Column Start -->
                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 equalcol conentsection">
                    <!-- Contents Section Started -->
                    <div class="sections">
                        <h2 class="heading">Artists</h2>
                        <div class="clearfix"></div>
                        <div class="row">
                            @foreach($artists as $artist)
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <div class="blogposttwo">
                                    <figure>
                                        <a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($artist['artist_id']))}}">
                                            <img src="{{$artist['video']->image}}" class="img-responsive hovereffect" alt="" />
                                        </a>
                                    </figure>
                                    <div class="text">
                                        <h4><a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($artist['artist_id']))}}">{{$artist['name']}}</a></h4>
                                        <ul>
                                            <li><i class="fa fa-calendar"></i>{{\Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $artist['created_at'])->format('Y-m-d')}}</li>
                                            {{--<li>--}}
                                                {{--<i class="fa fa-align-justify"></i>--}}
                                                {{--<a href="#">{{$artist['reputation']}}</a>--}}
                                            {{--</li>--}}
                                        </ul>
                                        <p>
                                            {{$artist['description']}}
                                        </p>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Contents Section End -->
                    <div class="clearfix"></div>
                    <!-- Pagination Start -->
                    {{--<ul class="pagination">--}}
                        {{--<li><a href="#"><i class="fa fa-angle-left"></i></a></li>--}}
                        {{--<li><a href="#">1</a></li>--}}
                        {{--<li class="disabled"><a href="#">2</a></li>--}}
                        {{--<li><a href="#">3</a></li>--}}
                        {{--<li class="active"><a href="#">4</a></li>--}}
                        {{--<li><a href="#">5</a></li>--}}
                        {{--<li><a href="#"><i class="fa fa-angle-right"></i></a></li>--}}
                    {{--</ul>--}}
                    {{--<div class="clearfix"></div>--}}
                    <!-- Pagination End -->
                </div>
                <!-- Content Column End -->
                <!-- Gray Sidebar Start -->
                @include('utils.gray-sidebar')
                <!-- Gray Sidebar End -->
            </div>
        </div>
    </div>
@endsection