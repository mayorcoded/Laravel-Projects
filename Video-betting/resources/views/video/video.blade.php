@extends('layout.master')

@section('content')
        <!-- Video Player Section Start -->
<div class="videoplayersec">
    <div class="custom-container">
        <div class="row">
            {{--Video section start--}}
            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 equalcol">
                <div class="">
                {{--<div class="vidcontainer">--}}
                    <!-- Video Player Start -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 playershadow">
                        <div class="playeriframe">
                            <iframe src="https://www.youtube.com/embed/{{$video->youtube_id}}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </div>
                    </div>
                    <!-- Video Player End -->
                    <!-- Video Stats and Sharing Start -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 videoinfo">
                        <div class="row">
                            <!-- Uploader Start -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 uploader">
                                <figure> <a href="{{route('artist', $artist->artist_id)}}"><img src="{{$video->image}}" alt="" /></a> </figure>
                                <div class="aboutuploader">
                                    <h5><a href="{{route('artist', $artist->artist_id)}}">By {{$artist->name}}</a></h5>
                                    <time datetime="25-12-2014">Uploaded : {{\Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $video->created_at)->format('Y-m-d')}}</time>
                                    <br />
                                    <a class="btn btn-primary btn-xs backcolor" href="{{route('artist', $artist->artist_id)}}">See All Videos</a> </div>
                            </div>
                            <!-- Uploader End -->
                            <!-- Video Stats Start -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 stats">
                                <hr class="visible-xs" />
                                <ul>
                                    <li class="likes">
                                        <h5>Bets</h5>
                                        <h2>{{$video->bets}}</h2>
                                    </li>
                                    <li class="views">
                                        <h5>Odds</h5>
                                        <h2>{{$video->odd}}</h2>
                                    </li>
                                </ul>
                            </div>
                            <!-- Video Stats End -->
                            <!-- Video Share Start -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 videoshare">
                                <ul>
                                    <li class="facebook">
                                        <i class="fa fa-facebook"></i>
                                        {{--<div class="shaingstats">--}}
                                        {{--<h5>36K</h5>--}}
                                        {{--<p>Shares</p>--}}
                                        {{--</div>--}}
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}" class="link" target="_blank"></a>
                                    </li>
                                    <li class="twitter">
                                        <i class="fa fa-twitter"></i>
                                        {{--<div class="shaingstats">--}}
                                        {{--<h5>15K</h5>--}}
                                        {{--<p>Tweets</p>--}}
                                        {{--</div>--}}
                                        <a href="https://twitter.com/home?status={{"I just bet on " . $video->title . ' by ' . $artist->name . ' on MVG: ' . urlencode(Request::url())}}" class="link" target="_blank"></a>
                                    </li>
                                    <li class="gplus">
                                        <i class="fa fa-google-plus"></i>
                                        {{--<div class="shaingstats">--}}
                                        {{--<h5>7K</h5>--}}
                                        {{--<p>Shares</p>--}}
                                        {{--</div>--}}
                                        <a href="https://plus.google.com/share?url={{ urlencode(Request::url()) }}" class="link" target="_blank"></a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Video Share End -->
                        </div>
                    </div>
                    <!-- Video Stats and Sharing End -->
                    <!-- Like This Video Start -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 likeit">
                        <hr />
                        <a class="btn btn-primary backcolor btn-lg" href="#"><span class="fa fa-money"></span> BET NOW</a>
                    </div>
                    <!-- Like This Video End -->
                </div>
            </div>
            {{--Video section end--}}
            {{--quick bets section start--}}
            <!-- Gray Sidebar Start -->
            @include('utils.gray-sidebar')
            <!-- Gray Sidebar End -->
            {{--quick bets section end--}}
        </div>
    </div>
</div>
<!-- Video Player Section End -->
@endsection