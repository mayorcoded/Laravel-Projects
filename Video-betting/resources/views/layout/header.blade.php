
<header>
    <!-- Header Top Strip Start -->
    <!-- Navigation Strip Start -->
    <div class="navigationstrip bordercolor-top">
        <div class="custom-container">
            <div class="row">
                <!-- Navigation Start -->
                <div class="col-lg-10 col-md-9 col-sm-6 col-xs-4">
                    <div class="navigation">
                        <!-- navbar Start -->
                        <div class="navbar yamm navbar-default">
                            <div class="row">
                                <div class="navbar-header">
                                    <button type="button" data-toggle="collapse" data-target="#navbar-collapse-1" class="navbar-toggle">
                                        <i class="fa fa-bars"></i> Menu
                                    </button>
                                </div>
                                <div id="navbar-collapse-1" class="navbar-collapse collapse">
                                    <ul class="nav navbar-nav">
                                        <!-- Home Page Start -->
                                        <li class="dropdown">
                                            <a href="{{route('index')}}" class="dropdown-toggle">Home</a>
                                        </li>
                                        <!-- Home Page End -->
                                        <!-- Admin Start -->
                                        <li class="dropdown">
                                            @if((Auth::check()) && (Auth::User()->role == 2))
                                                <a href="{{route('setup')}}">Admin</a>
                                            @endif
                                        </li>
                                        <!-- Admin End -->
                                        <!-- Video Pages Start -->
                                        <li class="dropdown">
                                            <a href="{{route('videos')}}" data-toggle="dropdown" class="dropdown-toggle">Videos</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <!-- Content container to add padding -->
                                                    <div class="yamm-content">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <a href="{{route('videos')}}" class="h2"><b>All Videos</b></a>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                <h5>New Video Bets</h5>
                                                                <ul class="list-unstyled">
                                                                    @foreach(App\Video::where('active', 1)->orderBy('updated_at', 'desc')->take(3)->get() as $video)
                                                                        <li><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($video->video_id))}}">{{$video->title}}</a></li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                <h5>Featured Video Bets</h5>
                                                                <ul class="list-unstyled">
                                                                    @foreach(App\Video::where('active', 1)->where('featured', 1)->take(3)->get() as $video)
                                                                        <li><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($video->video_id))}}">{{$video->title}}</a></li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>

                                                            <div class="col-lg-12 hidden-xs">
                                                                <h2 class="heading">Today's Hot Videos</h2>
                                                            </div>

                                                            @foreach(App\Video::where('active', 1)->orderBy('created_at', 'desc')->take(3)->get() as $value)
                                                                <div class="col-lg-4 hidden-xs">
                                                                    <!-- Video Box Start -->
                                                                    <div class="videobox">
                                                                        <figure>
                                                                            <!-- Video Thumbnail Start -->
                                                                            <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($value->video_id))}}">
                                                                                <img src="{{$value->image}}" alt="" class="img-responsive hovereffect" />
                                                                            </a>
                                                                            <!-- Video Thumbnail End -->
                                                                            <!-- Video Title + Info Start -->
                                                                            <figcaption>
                                                                                <h2><a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($value->video_id))}}">{{$value->title}}</a></h2>
                                                                                <ul>
                                                                                    <li><i class="fa fa-eye"></i>{{$value->views}}</li>
                                                                                    <li><i class="fa fa-star"></i>{{$value->bets}}</li>
                                                                                    <li><button class="btn btn-default btn-xs" onclick="startAddBetToCart('{{\Illuminate\Support\Facades\Crypt::encrypt($value->video_id)}}')">Bet Now</button> </li>
                                                                                </ul>
                                                                                <div class="clearfix"></div>
                                                                            </figcaption>
                                                                            <!-- Video Title + Info End -->
                                                                        </figure>
                                                                    </div>
                                                                    <!-- Video Box End -->
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <!-- Video Pages End -->
                                        <!-- Artists Pages Start -->
                                        <li class="dropdown">
                                            <a href="{{route('artists')}}" data-toggle="dropdown" class="dropdown-toggle">Artists</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <!-- Content container to add padding -->
                                                    <div class="yamm-content">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <a href="{{route('artists')}}" class="h2"><b>All Artists</b></a>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                <h5>New Artists</h5>
                                                                <ul class="list-unstyled">
                                                                    @foreach(App\Models\Artist::orderBy('created_at', 'desc')->take(3)->get() as $artist)
                                                                        <li><a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($artist->artist_id))}}">{{$artist->name}}</a></li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                <h5>Featured Artists</h5>
                                                                <ul class="list-unstyled">
                                                                    @foreach(App\Models\Artist::where('featured', 1)->take(3)->get() as $artist)
                                                                        <li><a href="{{route('artist', \Illuminate\Support\Facades\Crypt::encrypt($artist->artist_id))}}">{{$artist->name}}</a></li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <!-- Artists Pages End -->
                                        <!-- Contact Us Start -->
                                        <li class="dropdown yamm-fw">
                                            <a href="contact-us.html" data-toggle="dropdown" class="dropdown-toggle">Contact Us</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <div class="yamm-content">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <p>Ut volutpat consectetur aliquam. Curabitur auctor in nis ulum ornare. Sed consequat, augue condimentum fermentum gravida, metus elit vehicula dui.</p>
                                                                <hr />
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <a href="{{route('contact')}}">
                                                                    <strong>
                                                                        <i class="fa fa-envelope"></i>
                                                                        View contact us page or write your message here
                                                                    </strong>
                                                                </a>
                                                                <hr />
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                                <div class="contact-forms">
                                                                    <form>
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-md-6 col-sm-12 .col-xs-12">
                                                                                <input type="text" placeholder="Your Name" />
                                                                            </div>
                                                                            <div class="col-lg-6 col-md-6 col-sm-12 .col-xs-12">
                                                                                <input type="text" placeholder="Email Address" />
                                                                            </div>
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 .col-xs-12">
                                                                                <input type="text" placeholder="Subject" />
                                                                            </div>
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 .col-xs-12">
                                                                                <textarea placeholder="Message"></textarea>
                                                                            </div>
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 .col-xs-12">
                                                                                <button type="button" class="btn btn-primary backcolor">
                                                                                    <span>Submit message</span>
                                                                                    <i class="fa fa-angle-right"></i>
                                                                                </button>
                                                                                <p>Make sure you put a valid email.</p>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 hidden-xs">
                                                                <div class="dropdownmap">
                                                                    <iframe src="https://maps.google.com/?ie=UTF8&amp;ll=51.428327,-0.086517&amp;spn=0.64303,1.674042&amp;t=m&amp;z=10&amp;output=embed"></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <!-- navbar End -->
                    </div>
                </div>
                <!-- Navigation End -->
                <!-- Login Start -->
                <div class="col-lg-2 col-md-3 col-sm-6 col-xs-8">
                    <div class="loginsec pull-right">
                        <a href="{{route('bet.cart.fetch')}}" class="pointer colorhover"><span class="fa fa-shopping-cart"></span> My Cart</a>
                        @if(Auth::check())
                            <a href="{{route('profile')}}" class="pointer colorhover"><img class="profile-icon" src="{{Auth::user()->avatar}}"> {{Auth::user()->fullname}}</a>
                            <a href="{{route('logout')}}" class="pointer text-muted"><i class="fa fa-sign-in"></i>Logout</a>
                        @else
                            <a href="#" class="pointer colorhover" data-toggle="modal" data-target="#loginModal"><i class="fa fa-lock"></i>Login / Sign Up</a>
                        @endif
                    </div>
                </div>
                <!-- Login End -->
            </div>
        </div>
    </div>

    <!-- Navigation Strip End -->
    <!-- Logo + Search + Advertisment Start -->
    <div class="logobar">
        <div class="custom-container">
            <div class="row">
                <!-- Logo Start -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="logo">
                        <a href="{{route('index')}}"><img src="{{asset('images/logo.png')}}" alt="Music Video Betting" /></a>
                    </div>
                </div>
                <!-- Logo End -->
                <!-- Search Start -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="searchbox">
                        <form action="{{'/search'}}">
                            <ul>
                                <li><input type="text" placeholder="Search MVB" name="search" onkeyup="user.search(this.value)" /></li>
                                <li class="pull-right"><input type="submit" value="GO" /></li>
                            </ul>
                        </form>
                    </div>
                </div>
                <!-- Search End -->
                <!-- Advertisment Start -->
                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                    <figure class="header-adv">
                        <a href="#"><img src="{{asset('images/adv.gif')}}" class="img-responsive" alt="Advertisment" /></a>
                        <a href="#"><img src="{{asset('images/adv.gif')}}" class="img-responsive" alt="Advertisment" /></a>
                    </figure>
                </div>
                <!-- Advertisment End -->
            </div>
        </div>
    </div>
    <!-- Logo + Search + Advertisment End -->
</header>

