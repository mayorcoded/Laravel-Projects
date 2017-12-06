@extends('layout.master')

@section('content')

    <div class="contents">
        <div class="custom-container">
            <!-- New featuredVideos -->
            <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 .col-xs-6">
                        <!-- Video Box Start -->
                        <div class="videobox">
                            <figure>
                                <!-- Video Thumbnail Start -->

                                </a>
                                <!-- Video Thumbnail End -->
                                <!-- Video Title + Info Start -->

                                <!-- Video Title + Info End -->
                            </figure>
                        </div>
                        <!-- Video Box End -->
                    </div>

            </div>
            <div class="row" id="videos-search">
                <!-- Content Column Start -->
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 equalcol conentsection">
                    <!-- Video Slider Start -->

                <!-- Video Slider End -->
                    <!-- Contents Section Started -->


                    </div>
                    <!-- Contents Section End -->
                    <div class="clearfix"></div>
                    <!-- Contents Section Start -->
                    <div class="sections">
                        <h2 class="heading">Video Results</h2>
                        <h6>{{sizeof($videos)==0?"No results":""}}</h6>
                        <div class="clearfix"></div>

                        <div class="row" >

                            @foreach($videos as $video)
                                @if($video->active)
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 equalcol" >
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
                                                        <li><i class="fa fa-money"></i>{{$video->bets}}</li>
                                                        <li><i class="fa fa-star"></i>{{$video->odd}}/1</li>
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
                </div>

            <div class="sections">
                <h2 class="heading">Artist Results</h2>
                <h6>{{sizeof($artists)==0?'No results':""}}</h6>
                <div class="clearfix"></div>
                <div class="row">

                </div>

                <div class="row" id="artists-search">

                    @foreach($artists as $artist)
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
                            <div class="blogposttwo">
                                <figure>
                                    <a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($artist['artist_id']))}}">
                                        <img src="{{App\Video::where('artist_id',$artist['artist_id'])->first()->image}}" class="img-responsive hovereffect" alt="" />
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
                        <div class="clearfix"></div>
                    @endforeach
                </div>
                <!-- Content Column End -->
                <!-- Dark Sidebar Start -->
            <!-- Dark Sidebar End -->
                <!-- Gray Sidebar Start -->

            <!-- Gray Sidebar End -->
            </div>
        </div>
    </div>
@endsection