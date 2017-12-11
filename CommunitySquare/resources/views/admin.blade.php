<?php
$geo = new \App\Http\Controllers\GeoController();
$user = new \App\Http\Controllers\AccountController();
$topic = $topic->get()[0];
?>
@include('includes.top')
@include('includes.header')
<div class="body ">
    <div class="row">
        <div class="virral col-lg-10 col-md-12 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-" style=" min-height: 400px;">
            <div class="top-box col-lg-12 col-md-12 col-sm-12  col-xs-12">
                <div class="forum-header" style="">
                    <a href="/index.php">
                        <div class="forum-ls">Home</div>
                    </a>
                    <a href="/community">
                        <div class="forum-ls">Communities</div>
                    </a>
                    <a href="/community/topics/{!! $geo->getLgId($topic->local_government)[0]->id !!}">
                        <div class="forum-ls">{!! $topic->local_government !!}</div>
                    </a>


                </div>

                <div id="community" style="padding: 10px;">
                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-1">
                        <div class="topic-title-wrapper">
                        @if (count($errors) > 0)
                            <!-- Form Error List -->
                                <div class="alert alert-{!! json_decode($errors->first(), true)['status'] ? 'success' : 'danger' !!}">
                                    {{ json_decode($errors->first(), true)['message'] }}
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <!-- The Topic owner info-->
                                    <img class="thumbnail" style="width: 120px; height: 120px;" src="{{ $user->getUserByUname($topic->created_by)[0]->profile_pic ? $user->getUserByUname($topic->created_by)[0]->profile_pic : 'images/user.jpg'}}">
                                    <div class="user-description">
                                        <a href=""><span class="disp-detail">{{$topic->created_by}}</span></a>
                                        <span class="disp-detail">{!! $geo->getLgState($geo->getLgId($topic->local_government)[0]->id)->state !!}, {!! $topic->local_government !!}, {!! \App\User::where('username',$topic->created_by)->get()[0]->area !!}</span>
                                        <span class="disp-detail">Ile-Ife</span>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                    @if(isset($data) && $data['status'])
                                        <div class="alert alert-success">
                                            <strong>Success!</strong> {!! $data['message'] !!}
                                        </div>
                                    @endif
                                    <form action="topics/{!! $topic->id !!}/edit" method="POST" class="form">
                                            <h2 class="h3">Topic:</h2>
                                                @if(isset($data) && !$data['status'] && isset($data['message']['topic']))
                                                    <div class="alert alert-danger">
                                                        <strong>Error!</strong> {!! $data['message']['topic'] !!}
                                                    </div>
                                                @endif
                                                <input type="text" name="topic" class="form-control" value="{!! $topic->title !!}">
                                            <h2 class="h3">Content:</h2>
                                                @if(isset($data) && !$data['status'] && isset($data['message']['content']))
                                                    <div class="alert alert-danger">
                                                        <strong>Error!</strong> {!! $data['message']['content'] !!}
                                                    </div>
                                                @endif
                                            <textarea class="form-control" style="min-height: 200px;" name="content">{{ $topic->content }}</textarea>
                                                {!! csrf_field() !!}
                                            <input type="submit" value="Edit" class="form-control btn btn-success" >
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>

        </div>
    </div>
</div>
@include('includes.modal')
@include('includes.footer')