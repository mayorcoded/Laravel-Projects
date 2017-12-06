@extends('layout.master')

@section('content')
    <div class="contents">
        <div class="custom-container">
            <div class="row">
                <!-- Bread Crumb Start -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{route('index')}}">Home</a></li>
                        <li class="active"><a href="{{route('artists')}}">Artists</a></li>
                        <li class="active">{{$artist->name}}</li>
                    </ol>
                </div>
                <!-- Bread Crumb End -->
                <!-- Content Column Start -->
                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 equalcol conentsection">
                    <!-- Blog Detail Started -->
                    <div class="blogdetail sections">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="avatar">
                                    <figure>
                                        <a href="#"><img src="{{$videos[0]->image}}" alt=""></a>
                                    </figure>
                                    <h5>{{$artist->nickname}}</h5>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                                <div class="blogtext">
                                    <h2 class="heading">{{$artist->name}}</h2>
                                    <div class="clearfix"></div>
                                    <div class="blogmetas">
                                        <ul>
                                            <li><i class="fa fa-calendar"></i>{{\Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $artist->created_at)->format('Y-m-d')}}</li>
                                            {{--<li>--}}
                                                {{--<i class="fa fa-align-justify"></i>--}}
                                                {{--<a href="#">{{$artist->reputation}}</a>--}}
                                            {{--</li>--}}
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <p>
                                        {{$artist->description}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Blog Detail End -->
                    <div class="clearfix"></div>
                    <!-- Contents Section Started -->
                    <div class="sections">
                        <h2 class="heading">Videos</h2>
                        <div class="clearfix"></div>
                        <div class="row">
                            @foreach($videos as $video)
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <!-- Video Box Start -->
                                <div class="videobox">
                                    <figure>
                                        <!-- Video Thumbnail Start -->
                                        <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($video->video_id))}}">
                                            <img src="{{$video->image}}" alt="" class="img-responsive hovereffect" />
                                        </a>
                                        <!-- Video Thumbnail End -->
                                        <!-- Video Title + Info Start -->
                                        <figcaption>
                                            <h2><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($video->video_id))}}">
                                                    @if(strlen($video->title) < 75)
                                                        {{$video->title}}
                                                    @else
                                                        {{substr($video->title, 0, 75)}}...
                                                    @endif
                                                </a></h2>
                                            <ul>
                                                <li><i class="fa fa-money"></i>{{$video->bets}}</li>
                                                <li><i class="fa fa-star"></i>{{$video->odds}}</li>
                                                <li><button class="btn btn-default btn-xs">Bet Now</button> </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </figcaption>
                                        <!-- Video Title + Info End -->
                                    </figure>
                                </div>
                                <!-- Video Box End -->
                                <div class="clearfix"></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Contents Section End -->
                    <div class="clearfix"></div>
                </div>
                <!-- Content Column End -->
                <!-- Gray Sidebar Start -->
                @include('utils.gray-sidebar')
                <!-- Gray Sidebar End -->
            </div>
        </div>
    </div>
@endsection