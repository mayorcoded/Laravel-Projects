<div class="widget">
    <h2 class="heading">Today's Hot Videos</h2>
    <div class="carousals">
        <div id="carouselvideo" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                @if(isset($hotVideos[0], $hotVideos[1], $hotVideos[2]))
                    <div class="item active">
                        <!-- Video Box Start -->
                        <div class="videobox2">
                            <figure>
                                <!-- Video Thumbnail Start -->
                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[0]->video_id))}}">
                                    <img src="{{$hotVideos[0]->image}}" class="img-responsive hovereffect" alt="" />
                                </a>
                                <!-- Video Thumbnail End -->
                                <!-- Video Info Start -->
                                <div class="vidopts">
                                    <ul>
                                        <li><i class="fa fa-eye"></i>{{$hotVideos[0]->views}}</li>
                                        <li><i class="fa fa-star"></i>{{$hotVideos[0]->bets}}</li>
                                        <li><button class="btn btn-default btn-xs" onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($hotVideos[0]->video_id)}}')">Bet Now</button> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <!-- Video Info End -->
                            </figure>
                            <!-- Video Title Start -->
                            <h4><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[0]->video_id))}}">{{$hotVideos[0]->title}}</a></h4>
                            <!-- Video Title End -->
                        </div>
                        <!-- Video Box End -->
                        <!-- Video Box Start -->
                        <div class="videobox2">
                            <figure>
                                <!-- Video Thumbnail Start -->
                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[1]->video_id))}}">
                                    <img src="{{$hotVideos[1]->image}}" class="img-responsive hovereffect" alt="" />
                                </a>
                                <!-- Video Thumbnail End -->
                                <!-- Video Info Start -->
                                <div class="vidopts">
                                    <ul>
                                        <li><i class="fa fa-eye"></i>{{$hotVideos[1]->views}}</li>
                                        <li><i class="fa fa-star"></i>{{$hotVideos[1]->bets}}</li>
                                        <li><button class="btn btn-default btn-xs" onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($hotVideos[1]->video_id)}}')">Bet Now</button> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <!-- Video Info End -->
                            </figure>
                            <!-- Video Title Start -->
                            <h4><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[1]->video_id))}}">{{$hotVideos[1]->title}}</a></h4>
                            <!-- Video Title End -->
                        </div>
                        <!-- Video Box End -->
                        <!-- Video Box Start -->
                        <div class="videobox2">
                            <figure>
                                <!-- Video Thumbnail Start -->
                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[2]->video_id))}}">
                                    <img src="{{$hotVideos[2]->image}}" class="img-responsive hovereffect" alt="" />
                                </a>
                                <!-- Video Thumbnail End -->
                                <!-- Video Info Start -->
                                <div class="vidopts">
                                    <ul>
                                        <li><i class="fa fa-eye"></i>{{$hotVideos[2]->views}}</li>
                                        <li><i class="fa fa-star"></i>{{$hotVideos[2]->bets}}</li>
                                        <li><button class="btn btn-default btn-xs" onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($hotVideos[2]->video_id)}}')">Bet Now</button> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <!-- Video Info End -->
                            </figure>
                            <!-- Video Title Start -->
                            <h4><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[2]->video_id))}}">{{$hotVideos[2]->title}}</a></h4>
                            <!-- Video Title End -->
                        </div>
                        <!-- Video Box End -->
                    </div>
                @endif
                @if(isset($hotVideos[3], $hotVideos[4], $hotVideos[5]))
                    <div class="item">
                        <!-- Video Box Start -->
                        <div class="videobox2">
                            <figure>
                                <!-- Video Thumbnail Start -->
                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[3]->video_id))}}">
                                    <img src="{{$hotVideos[3]->image}}" class="img-responsive hovereffect" alt="" />
                                </a>
                                <!-- Video Thumbnail End -->
                                <!-- Video Info Start -->
                                <div class="vidopts">
                                    <ul>
                                        <li><i class="fa fa-eye"></i>{{$hotVideos[3]->views}}</li>
                                        <li><i class="fa fa-star"></i>{{$hotVideos[3]->bets}}</li>
                                        <li><button class="btn btn-default btn-xs" onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($hotVideos[3]->video_id)}}')">Bet Now</button> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <!-- Video Info End -->
                            </figure>
                            <!-- Video Title Start -->
                            <h4><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[3]->video_id))}}">{{$hotVideos[3]->title}}</a></h4>
                            <!-- Video Title End -->
                        </div>
                        <!-- Video Box End -->
                        <!-- Video Box Start -->
                        <div class="videobox2">
                            <figure>
                                <!-- Video Thumbnail Start -->
                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[4]->video_id))}}">
                                    <img src="{{$hotVideos[4]->image}}" class="img-responsive hovereffect" alt="" />
                                </a>
                                <!-- Video Thumbnail End -->
                                <!-- Video Info Start -->
                                <div class="vidopts">
                                    <ul>
                                        <li><i class="fa fa-eye"></i>{{$hotVideos[4]->views}}</li>
                                        <li><i class="fa fa-star"></i>{{$hotVideos[4]->bets}}</li>
                                        <li><button class="btn btn-default btn-xs" onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($hotVideos[4]->video_id)}}')">Bet Now</button> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <!-- Video Info End -->
                            </figure>
                            <!-- Video Title Start -->
                            <h4><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[4]->video_id))}}">{{$hotVideos[4]->title}}</a></h4>
                            <!-- Video Title End -->
                        </div>
                        <!-- Video Box End -->
                        <!-- Video Box Start -->
                        <div class="videobox2">
                            <figure>
                                <!-- Video Thumbnail Start -->
                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[5]->video_id))}}">
                                    <img src="{{$hotVideos[5]->image}}" class="img-responsive hovereffect" alt="" />
                                </a>
                                <!-- Video Thumbnail End -->
                                <!-- Video Info Start -->
                                <div class="vidopts">
                                    <ul>
                                        <li><i class="fa fa-eye"></i>{{$hotVideos[5]->views}}</li>
                                        <li><i class="fa fa-star"></i>{{$hotVideos[5]->bets}}</li>
                                        <li><button class="btn btn-default btn-xs" onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($hotVideos[5]->video_id)}}')">Bet Now</button> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <!-- Video Info End -->
                            </figure>
                            <!-- Video Title Start -->
                            <h4><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[5]->video_id))}}">{{$hotVideos[5]->title}}</a></h4>
                            <!-- Video Title End -->
                        </div>
                        <!-- Video Box End -->
                    </div>
                @endif
                @if(isset($hotVideos[6], $hotVideos[7], $hotVideos[8]))
                    <div class="item">
                        <!-- Video Box Start -->
                        <div class="videobox2">
                            <figure>
                                <!-- Video Thumbnail Start -->
                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[6]->video_id))}}">
                                    <img src="{{$hotVideos[6]->image}}" class="img-responsive hovereffect" alt="" />
                                </a>
                                <!-- Video Thumbnail End -->
                                <!-- Video Info Start -->
                                <div class="vidopts">
                                    <ul>
                                        <li><i class="fa fa-eye"></i>{{$hotVideos[6]->views}}</li>
                                        <li><i class="fa fa-star"></i>{{$hotVideos[6]->bets}}</li>
                                        <li><button class="btn btn-default btn-xs" onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($hotVideos[6]->video_id)}}')">Bet Now</button> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <!-- Video Info End -->
                            </figure>
                            <!-- Video Title Start -->
                            <h4><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[6]->video_id))}}">{{$hotVideos[6]->title}}</a></h4>
                            <!-- Video Title End -->
                        </div>
                        <!-- Video Box End -->
                        <!-- Video Box Start -->
                        <div class="videobox2">
                            <figure>
                                <!-- Video Thumbnail Start -->
                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[7]->video_id))}}">
                                    <img src="{{$hotVideos[7]->image}}" class="img-responsive hovereffect" alt="" />
                                </a>
                                <!-- Video Thumbnail End -->
                                <!-- Video Info Start -->
                                <div class="vidopts">
                                    <ul>
                                        <li><i class="fa fa-eye"></i>{{$hotVideos[7]->views}}</li>
                                        <li><i class="fa fa-star"></i>{{$hotVideos[7]->bets}}</li>
                                        <li><button class="btn btn-default btn-xs" onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($hotVideos[7]->video_id)}}')">Bet Now</button> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <!-- Video Info End -->
                            </figure>
                            <!-- Video Title Start -->
                            <h4><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[7]->video_id))}}">{{$hotVideos[7]->title}}</a></h4>
                            <!-- Video Title End -->
                        </div>
                        <!-- Video Box End -->
                        <!-- Video Box Start -->
                        <div class="videobox2">
                            <figure>
                                <!-- Video Thumbnail Start -->
                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[8]->video_id))}}">
                                    <img src="{{$hotVideos[8]->image}}" class="img-responsive hovereffect" alt="" />
                                </a>
                                <!-- Video Thumbnail End -->
                                <!-- Video Info Start -->
                                <div class="vidopts">
                                    <ul>
                                        <li><i class="fa fa-eye"></i>{{$hotVideos[8]->views}}</li>
                                        <li><i class="fa fa-star"></i>{{$hotVideos[8]->bets}}</li>
                                        <li><button class="btn btn-default btn-xs" onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($hotVideos[8]->video_id)}}')">Bet Now</button> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <!-- Video Info End -->
                            </figure>
                            <!-- Video Title Start -->
                            <h4><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($hotVideos[8]->video_id))}}">{{$hotVideos[8]->title}}</a></h4>
                            <!-- Video Title End -->
                        </div>
                        <!-- Video Box End -->
                    </div>
                @endif
            </div>
            <div class="carouselpagination">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carouselvideo" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselvideo" data-slide-to="1"></li>
                    <li data-target="#carouselvideo" data-slide-to="2"></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>