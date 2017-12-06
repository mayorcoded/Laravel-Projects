<div class="widget">
    <h2 class="heading">Trending Artists</h2>
    <div class="carousals">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <ul class="bloglist">
                        @if(isset($trendingArtists[0]))
                            <li>
                                <figure>
                                    <a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($trendingArtists[0]['artist']->artist_id))}}">
                                        <img src="{{$trendingArtists[0]['channel']->canvas}}" class="img-responsive hovereffect" alt="" />
                                    </a>
                                </figure>
                                <div class="text">
                                    <h4><a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($trendingArtists[0]['artist']->artist_id))}}">
                                            {{$trendingArtists[0]['artist']->name}}
                                        </a></h4>
                                    <ul>
                                        <li><i class="fa fa-calendar"></i>{{\Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $trendingArtists[0]['artist']->created_at)->format('Y-m-d')}}</li>
                                        {{--<li> <i class="fa fa-eye"></i> 1000 </li>--}}
                                    </ul>
                                </div>
                            </li>
                        @endif
                        @if(isset($trendingArtists[1]))
                            <li>
                                <figure>
                                    <a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($trendingArtists[1]['artist']->artist_id))}}">
                                        <img src="{{$trendingArtists[1]['channel']->canvas}}" class="img-responsive hovereffect" alt="" />
                                    </a>
                                </figure>
                                <div class="text">
                                    <h4><a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($trendingArtists[1]['artist']->artist_id))}}">
                                            {{$trendingArtists[0]['artist']->name}}
                                        </a></h4>
                                    <ul>
                                        <li><i class="fa fa-calendar"></i>{{\Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $trendingArtists[1]['artist']->created_at)->format('Y-m-d')}}</li>
                                        {{--<li> <i class="fa fa-eye"></i> 1000 </li>--}}
                                    </ul>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="item">
                    <ul class="bloglist">
                        @if(isset($trendingArtists[2]))
                            <li>
                                <figure>
                                    <a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($trendingArtists[2]['artist']->artist_id))}}">
                                        <img src="{{$trendingArtists[2]['channel']->canvas}}" class="img-responsive hovereffect" alt="" />
                                    </a>
                                </figure>
                                <div class="text">
                                    <h4><a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($trendingArtists[2]['artist']->artist_id))}}">
                                            {{$trendingArtists[2]['artist']->name}}
                                        </a></h4>
                                    <ul>
                                        <li><i class="fa fa-calendar"></i>{{\Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $trendingArtists[2]['artist']->created_at)->format('Y-m-d')}}</li>
                                        {{--<li> <i class="fa fa-eye"></i> 1000 </li>--}}
                                    </ul>
                                </div>
                            </li>
                        @endif
                        @if(isset($trendingArtists[3]))
                            <li>
                                <figure>
                                    <a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($trendingArtists[3]['artist']->artist_id))}}">
                                        <img src="{{$trendingArtists[3]['channel']->canvas}}" class="img-responsive hovereffect" alt="" />
                                    </a>
                                </figure>
                                <div class="text">
                                    <h4><a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($trendingArtists[3]['artist']->artist_id))}}">
                                            {{$trendingArtists[3]['artist']->name}}
                                        </a></h4>
                                    <ul>
                                        <li><i class="fa fa-calendar"></i>{{\Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $trendingArtists[3]['artist']->created_at)->format('Y-m-d')}}</li>
                                        {{--<li> <i class="fa fa-eye"></i> 1000 </li>--}}
                                    </ul>
                                </div>
                            </li>
                    @endif
                </div>
                <div class="item">
                    <ul class="bloglist">
                        @if(isset($trendingArtists[4]))
                            <li>
                                <figure>
                                    <a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($trendingArtists[4]['artist']->artist_id))}}">
                                        <img src="{{$trendingArtists[4]['channel']->canvas}}" class="img-responsive hovereffect" alt="" />
                                    </a>
                                </figure>
                                <div class="text">
                                    <h4><a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($trendingArtists[4]['artist']->artist_id))}}">
                                            {{$trendingArtists[4]['artist']->name}}
                                        </a></h4>
                                    <ul>
                                        <li><i class="fa fa-calendar"></i>{{\Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $trendingArtists[4]['artist']->created_at)->format('Y-m-d')}}</li>
                                        {{--<li> <i class="fa fa-eye"></i> 1000 </li>--}}
                                    </ul>
                                </div>
                            </li>
                        @endif
                        @if(isset($trendingArtists[5]))
                            <li>
                                <figure>
                                    <a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($trendingArtists[5]['artist']->artist_id))}}">
                                        <img src="{{$trendingArtists[5]['channel']->canvas}}" class="img-responsive hovereffect" alt="" />
                                    </a>
                                </figure>
                                <div class="text">
                                    <h4><a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($trendingArtists[5]['artist']->artist_id))}}">
                                            {{$trendingArtists[5]['artist']->name}}
                                        </a></h4>
                                    <ul>
                                        <li><i class="fa fa-calendar"></i>{{\Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $trendingArtists[5]['artist']->created_at)->format('Y-m-d')}}</li>
                                        {{--<li> <i class="fa fa-eye"></i> 1000 </li>--}}
                                    </ul>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="carouselpagination">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>