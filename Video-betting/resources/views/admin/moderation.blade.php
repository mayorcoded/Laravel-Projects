@extends('layout.master')

@section('content')
    <div class="contents">
        <div class="custom-container">
            <div class="row">
                <!-- Bread Crumb Start -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{route('index')}}">Home</a></li>
                        <li class="active">Admin Moderation</li>
                    </ol>
                </div>
                <!-- Bread Crumb End -->
                <!-- Content Column Start -->
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 equalcol conentsection">
                    <!-- Contents Section Started -->
                    <div class="sections">
                        <h2 class="heading">Videos</h2>
                        <div class="clearfix"></div>
                        <div class="row">
                            <form>
                                @foreach($videos as $video)
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
                                                        <li><i class="fa fa-money"></i>{{$video->bets}}</li>
                                                        <li><i class="fa fa-star"></i>{{$video->odd}}/1</li>
                                                        <li><input class="text-muted" name="video_{{$video->video_id}}" type="checkbox" {{($video->active == 1)?'checked':""}} value={{$video->video_id}} id="active"> Active</li>
                                                        <li><input class="text-muted" name="video_{{$video->video_id}}_featured" type="checkbox" {{($video->featured == 1)?'checked':""}}  value={{$video->video_id}} id="featured"> Featured</li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <!-- Video Info End -->
                                            </figure>
                                            <!-- Video Title Start -->
                                            <h4>
                                                <a href="{{route('video', \Illuminate\Support\Facades\Crypt::encrypt($video->id))}}">
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
                                @endforeach
                            </form>
                        </div>
                    </div>
                    <!-- Contents Section End -->
                    <div class="clearfix"></div>
                </div>
                <!-- Content Column End -->
                <!-- Gray Sidebar Start -->
                @include('layout.admin-menu')
                        <!-- Gray Sidebar End -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="{{asset('js/moderation.js')}}"></script>
@stop