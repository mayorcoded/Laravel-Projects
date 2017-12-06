
<div class="videoslider backcolor">
    <div class='tabbed_content'>
        <div class='tabs'>
            <div class='moving_bg'>
                <span class="pointer"></span>
            </div>
            @foreach($newVideos as $newVid)
            <div class='tab_item'>
                <h5>{{$newVid->title}}</h5>
                <span class="hidden-xs">{{\Carbon\Carbon::createFromFormat('Y-m-d', explode(' ',$newVid->created_at)[0])->toFormattedDateString()}}</span>
            </div>
            @endforeach
        </div>
        <div class='slide_content'>
            <div class='tabslider'>
                @foreach($newVideos as $newVid)
                <div class="video">
                    <!-- Video Box Start -->
                    <div class="videobox">
                        <figure>
                            <!-- Video Preview Start -->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 playershadow">
                                <div class="playeriframe">
                                    <iframe src="https://www.youtube.com/embed/{{$newVid->youtube_id}}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                </div>
                            </div>
                            <!-- Video Preview End -->
                            <!-- Video Title + Info Start -->
                            <figcaption>
                                <h2><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($newVid->video_id))}}">{{$newVid->title}}</a></h2>
                                <ul>
                                    <li><i class="fa fa-eye"></i>{{$newVid->views}}</li>
                                    <li><i class="fa fa-star"></i>{{$newVid->bets}}</li>
                                    <li><button class="btn btn-default btn-xs">Bet Now</button> </li>
                                </ul>
                                <div class="clearfix"></div>
                            </figcaption>
                            <!-- Video Title + Info End -->
                        </figure>
                    </div>
                    <!-- Video Box End -->
                </div>
                @endforeach
                <!-- content goes here -->
            </div>
        </div>
    </div>
</div>