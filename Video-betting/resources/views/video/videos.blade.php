@extends('layout.master')

@section('content')
    <div class="contents">
        <div class="custom-container">
            <div class="row">
                <!-- Bread Crumb Start -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{route('index')}}">Home</a></li>
                        <li class="active">Videos</li>
                    </ol>
                </div>
                <!-- Bread Crumb End -->
                <!-- Content Column Start -->
                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 equalcol conentsection">
                    <!-- Contents Section Started -->
                    <div class="sections">
                        <h2 class="heading">Videos</h2>
                        <div class="clearfix"></div>
                        <div class="row">
                            @foreach($videos as $video)
                                @if($video->active)
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 equalcol">
                                        <!-- Video Box Start -->
                                        <div class="videobox2">
                                            <figure>
                                                <!-- Video Thumbnail Start -->
                                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($video->video_id))}}">
                                                    <img src="{{$video->image}}" class="img-responsive hovereffect" alt="{{$video->description}}" />
                                                </a>
                                                <!-- Video Thumbnail End -->
                                                <!-- Video Info Start -->
                                                <div class="vidopts">
                                                    <ul>
                                                        <li><i class="fa fa-eye"></i>{{$video->views}}</li>
                                                        <li><i class="fa fa-star"></i>{{$video->bets}}</li>
                                                        <li><button class="btn btn-default btn-xs" onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($video->video_id)}}')">Bet Now</button> </li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <!-- Video Info End -->
                                            </figure>
                                            <!-- Video Title Start -->
                                            <h4>
                                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($video->video_id))}}">
                                                    @if(strlen($video->title) < 75)
                                                        {{$video->title}}
                                                    @else
                                                        {{substr($video->title, 0, 75)}}...
                                                    @endif
                                                </a>
                                            </h4>
                                            <div class="clearfix"></div>
                                            <!-- Video Title End -->
                                        </div>
                                        <!-- Video Box End -->
                                    </div>
                                @endif
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

    <div id="betS232" class="modal fade in" role="dialog">
        <div class="modal-dialog">
            <div class="loading-anim" style="text-align: center; color: white; padding-top: 30px;">
                <span class="" style="font-size: 150px; display: block;">
                    <i class="fa fa-circle-o fa-spin"></i>
                </span>
                <span class="text text-primary" style="font-size: 30px; display: block; padding: 5px; background-color: #cbc9be; border-radius: 10px;">Starting bet...</span>
            </div>
        </div>
    </div>
@endsection