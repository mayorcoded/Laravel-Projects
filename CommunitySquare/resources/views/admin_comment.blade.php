<?php
$geo = new \App\Http\Controllers\GeoController();
$user = new \App\Http\Controllers\AccountController();
$forum = new \App\Http\Controllers\ForumController();
$comment_ = $comment->get()[0];

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
                    <a href="/community/topics/{!! $geo->getLgId($forum->getTopic($comment_->topic_id)->get()[0]->local_government)[0]->id !!}">

                        <div class="forum-ls">{!! $forum->getTopic($comment_->topic_id)->get()[0]->local_government !!}</div>
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
                                    <img class="thumbnail" style="width: 120px; height: 120px;" src="{{ $user->getUserByUname($comment_->comment_by)[0]->profile_pic ? $user->getUserByUname($topic->created_by)[0]->profile_pic : 'images/user.jpg'}}">
                                    <div class="user-description">
                                        <a href=""><span class="disp-detail">{{$comment_->comment_by}}</span></a>
                                        <span class="disp-detail">{!! $geo->getLgState($geo->getLgId($forum->getTopic($comment_->topic_id)->get()[0]->local_government)[0]->id)->state !!}, {!! $forum->getTopic($comment_->topic_id)->get()[0]->local_government !!}, {!! \App\User::where('username',$comment_->comment_by)->get()[0]->area !!}</span>
                                        <span class="disp-detail">Ile-Ife</span>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                    @if(isset($data) && $data['status'])
                                        <div class="alert alert-success">
                                            <strong>Success!</strong> {!! $data['message'] !!}
                                        </div>
                                    @endif
                                    @if(isset($data) && !$data['status'])
                                        <div class="alert alert-danger">
                                            <strong>Error!</strong> {!! $data['message'] !!}
                                        </div>
                                    @endif
                                    <form action="comment/{!! $comment_->id !!}/edit" method="POST" class="form">
                                        <textarea class="form-control" name="comment" >{!! $comment_->comment !!}</textarea>
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