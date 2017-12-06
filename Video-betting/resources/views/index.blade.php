@extends('layout.master')

@section('content')

    <div class="contents">
        <div class="custom-container">
            <!-- New featuredVideos -->
            <div class="row">
                @if(isset($randomValues[0]) && isset($featuredVideos[$randomValues[0]]))
                    <div class="col-lg-3 col-md-3 col-sm-6 .col-xs-6">
                        <!-- Video Box Start -->
                        <div class="videobox">
                            <figure>
                                <!-- Video Thumbnail Start -->
                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($featuredVideos[$randomValues[0]]->video_id))}}">
                                    <img src="{{$featuredVideos[$randomValues[0]]->image}}" alt="" class="img-responsive hovereffect" />
                                </a>
                                <!-- Video Thumbnail End -->
                                <!-- Video Title + Info Start -->
                                <figcaption>
                                    <h2><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($featuredVideos[$randomValues[0]]->video_id))}}">{{$featuredVideos[$randomValues[0]]->title}}</a></h2>
                                    <ul>
                                        <li><i class="fa fa-eye"></i>{{$featuredVideos[$randomValues[0]]->views}}</li>
                                        <li><i class="fa fa-star"></i>{{$featuredVideos[$randomValues[0]]->bets}}</li>
                                        <li><button class="btn btn-default btn-xs"  onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($featuredVideos[$randomValues[0]]->video_id)}}')">Bet Now</button> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </figcaption>
                                <!-- Video Title + Info End -->
                            </figure>
                        </div>
                        <!-- Video Box End -->
                    </div>
                @endif
                @if(isset($randomValues[1]) && $featuredVideos[$randomValues[1]])
                    <div class="col-lg-3 col-md-3 col-sm-6 .col-xs-6">
                        <!-- Video Box Start -->
                        <div class="videobox">
                            <figure>
                                <!-- Video Thumbnail Start -->
                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($featuredVideos[$randomValues[1]]->video_id))}}">
                                    <img src="{{$featuredVideos[$randomValues[1]]->image}}" alt="" class="img-responsive hovereffect" />
                                </a>
                                <!-- Video Thumbnail End -->
                                <!-- Video Title + Info Start -->
                                <figcaption>
                                    <h2><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($featuredVideos[$randomValues[1]]->video_id))}}">{{$featuredVideos[$randomValues[1]]->title}}</a></h2>
                                    <ul>
                                        <li><i class="fa fa-eye"></i>{{$featuredVideos[$randomValues[1]]->views}}</li>
                                        <li><i class="fa fa-star"></i>{{$featuredVideos[$randomValues[1]]->bets}}</li>
                                        <li><button class="btn btn-default btn-xs" onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($featuredVideos[$randomValues[1]]->video_id)}}')">Bet Now</button> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </figcaption>
                                <!-- Video Title + Info End -->
                            </figure>
                        </div>
                        <!-- Video Box End -->
                    </div>
                @endif
                @if(isset($randomValues[2]) && $featuredVideos[$randomValues[2]])
                    <div class="col-lg-3 col-md-3 col-sm-6 .col-xs-6">
                        <!-- Video Box Start -->
                        <div class="videobox">
                            <figure>
                                <!-- Video Thumbnail Start -->
                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($featuredVideos[$randomValues[2]]->video_id))}}">
                                    <img src="{{$featuredVideos[$randomValues[2]]->image}}" alt="" class="img-responsive hovereffect" />
                                </a>
                                <!-- Video Thumbnail End -->
                                <!-- Video Title + Info Start -->
                                <figcaption>
                                    <h2><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($featuredVideos[$randomValues[2]]->video_id))}}">{{$featuredVideos[$randomValues[2]]->title}}</a></h2>
                                    <ul>
                                        <li><i class="fa fa-eye"></i>{{$featuredVideos[$randomValues[2]]->views}}</li>
                                        <li><i class="fa fa-star"></i>{{$featuredVideos[$randomValues[2]]->bets}}</li>
                                        <li><button class="btn btn-default btn-xs" onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($featuredVideos[$randomValues[2]]->video_id)}}')">Bet Now</button> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </figcaption>
                                <!-- Video Title + Info End -->
                            </figure>
                        </div>
                        <!-- Video Box End -->
                    </div>
                @endif
                @if(isset($randomValues[3]) && $featuredVideos[$randomValues[3]])
                    <div class="col-lg-3 col-md-3 col-sm-6 .col-xs-6">
                        <!-- Video Box Start -->
                        <div class="videobox">
                            <figure>
                                <!-- Video Thumbnail Start -->
                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($featuredVideos[$randomValues[3]]->video_id))}}">
                                    <img src="{{$featuredVideos[$randomValues[3]]->image}}" alt="" class="img-responsive hovereffect" />
                                </a>
                                <!-- Video Thumbnail End -->
                                <!-- Video Title + Info Start -->
                                <figcaption>
                                    <h2><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($featuredVideos[$randomValues[3]]->video_id))}}">{{$featuredVideos[$randomValues[3]]->title}}</a></h2>
                                    <ul>
                                        <li><i class="fa fa-eye"></i>{{$featuredVideos[$randomValues[3]]->views}}</li>
                                        <li><i class="fa fa-star"></i>{{$featuredVideos[$randomValues[3]]->bets}}</li>
                                        <li><button class="btn btn-default btn-xs" onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($featuredVideos[$randomValues[3]]->video_id)}}')">Bet Now</button> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </figcaption>
                                <!-- Video Title + Info End -->
                            </figure>
                        </div>
                        <!-- Video Box End -->
                    </div>
                @endif
            </div>
            <div class="row">
                <!-- Content Column Start -->
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 equalcol conentsection">
                    <!-- Video Slider Start -->
                    @include('utils.video-slider')
                            <!-- Video Slider End -->
                    <!-- Contents Section Started -->
                    <div class="sections">
                        <h2 class="heading">Most Recent Bets</h2>
                        <div class="clearfix"></div>
                        <div class="row">
                            @foreach($recentBets as $bet)

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Video Box Start -->
                                    <div class="videobox2">
                                        <figure>
                                            <!-- Video Thumbnail Start -->
                                            <a href="video-detail-double-sidebar.html">
                                                <img src="{{$bet["video"]->image}}" class="img-responsive hovereffect" alt="" />
                                            </a>
                                            <!-- Video Thumbnail End -->
                                            <!-- Video Info Start -->
                                            <div class="vidopts">
                                                <ul>
                                                    <li><i class="fa fa-eye-slash"></i>{{$bet["bet"]->maximum_view}}</li>
                                                    <li><i class="fa fa-star-o"></i>{{$bet["bet"]->odd}}</li>
                                                    <li><button class="btn btn-default btn-xs"  onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($bet['bet']->video_id)}}')">Bet Now</button> </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <!-- Video Info End -->
                                        </figure>
                                        <!-- Video Title Start -->
                                        <h4><a href="video-detail-double-sidebar.html">{{$bet["video"]->title}}</a></h4>
                                        <!-- Video Title End -->
                                    </div>
                                    <!-- Video Box End -->
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Contents Section End -->
                    <div class="clearfix"></div>
                    <!-- Contents Section Start -->
                    <div class="sections">
                        <h2 class="heading">Featured Artists</h2>
                        <div class="clearfix"></div>
                        <div class="row">
                            @if(isset($featuredArtist[0]))
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="blogpost">
                                        <figure>
                                            <a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($featuredArtist[0]['artist']->artist_id))}}">
                                                <img class="img-responsive hovereffect" src="{{$featuredArtist[0]['channel']->canvas}}" alt="" />
                                            </a>
                                            <figcaption>
                                                <ul>
                                                    <li><i class="fa fa-calendar"></i>{{\Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $featuredArtist[0]['artist']->created_at)->format('Y-m-d')}}</li>
                                                    {{--<li> <i class="fa fa-eye"></i> 1000 </li>--}}
                                                </ul>
                                            </figcaption>
                                        </figure>
                                        <div class="text">
                                            <h4 class="heading"><a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($featuredArtist[0]['artist']->artist_id))}}">{{$featuredArtist[0]['artist']->name}}</a></h4>
                                            <p class="text-clipped">
                                                {{$featuredArtist[0]['channel']->description}}
                                            </p>
                                            <a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($featuredArtist[0]['artist']->artist_id))}}" class="btn btn-primary btn-xs backcolor">Read More</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <ul class="bloglist">
                                    @if(isset($featuredArtist[1]))
                                        <li>
                                            <div class="media">
                                                <a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($featuredArtist[1]['artist']->artist_id))}}" class="pull-left">
                                                    <img src="{{$featuredArtist[1]['channel']->canvas}}" class="media-object img-responsive hovereffect" alt="" />
                                                </a>
                                                <div class="media-body">
                                                    <h4><a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($featuredArtist[1]['artist']->artist_id))}}">{{$featuredArtist[1]['artist']->name}}</a></h4>
                                                    <ul>
                                                        <li><i class="fa fa-calendar"></i>{{\Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $featuredArtist[1]['artist']->created_at)->format('Y-m-d')}}</li>
                                                        {{--<li> <i class="fa fa-eye"></i> 1000 </li>--}}
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if(isset($featuredArtist[2]))
                                        <li>
                                            <div class="media">
                                                <a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($featuredArtist[2]['artist']->artist_id))}}" class="pull-left">
                                                    <img src="{{$featuredArtist[2]['channel']->canvas}}" class="media-object img-responsive hovereffect" alt="" />
                                                </a>
                                                <div class="media-body">
                                                    <h4><a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($featuredArtist[2]['artist']->artist_id))}}">{{$featuredArtist[2]['artist']->name}}</a></h4>
                                                    <ul>
                                                        <li><i class="fa fa-calendar"></i>{{\Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $featuredArtist[2]['artist']->created_at)->format('Y-m-d')}}</li>
                                                        {{--<li> <i class="fa fa-eye"></i> 1000 </li>--}}
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if(isset($featuredArtist[3]))
                                        <li>
                                            <div class="media">
                                                <a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($featuredArtist[3]['artist']->artist_id))}}" class="pull-left">
                                                    <img src= "{{$featuredArtist[3]['channel']->canvas}}" class="media-object img-responsive hovereffect" alt="" />
                                                </a>
                                                <div class="media-body">
                                                    <h4><a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($featuredArtist[3]['artist']->artist_id))}}">{{$featuredArtist[3]['artist']->name}}</a></h4>
                                                    <ul>
                                                        <li><i class="fa fa-calendar"></i>{{\Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $featuredArtist[3]['artist']->created_at)->format('Y-m-d')}}</li>
                                                        {{--<li> <i class="fa fa-eye"></i> 1000 </li>--}}
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Contents Section End -->
                    <div class="clearfix"></div>
                </div>
                <!-- Content Column End -->
                <!-- Dark Sidebar Start -->
                @include('utils.dark-sidebar')
                        <!-- Dark Sidebar End -->
                <!-- Gray Sidebar Start -->
                @include('utils.gray-sidebar')
                        <!-- Gray Sidebar End -->
            </div>
        </div>
    </div>
@endsection