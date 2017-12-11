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
             @if(Auth::user() && \App\User::where('username', $topic->created_by)->get()[0]->local_government == Auth::user()->local_government)
                 <a href=""  data-toggle="modal" data-target="#addTopic">
                     <div class="forum-ls float-right">Create Topic</div>
                 </a>
             @elseif(!Auth::user())

                 <div class="forum-ls float-right"  data-toggle="modal" data-target="#info" style="min-width: 50px !important; background-color: pink; border-radius: 100%;
                    font-size: 25px; padding-left: 20px;
                 "><i class="fa fa-info text-warning"></i></div>
                 <div id="info" class="modal fade" role="dialog">
                         <div class="modal-dialog">
                             <!-- Modal content-->
                             <div class="modal-content">
                                 <div class="modal-body">
                                     <p class="text text-danger">
                                         You are not allowed to add topic to this community because you are not logged in please log in to be able to contribute to the community.
                                     </p>
                                 </div>
                                 <div class="modal-footer">
                                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                 </div>
                             </div>

                         </div>
                     </div>
             @else
                 <div class="forum-ls float-right"  data-toggle="modal" data-target="#info"><img src="images/info.png" style="width: 40px; height: 30px;"> </div>
                 <div id="info" class="modal fade" role="dialog">
                     <div class="modal-dialog">
                         <!-- Modal content-->
                         <div class="modal-content">
                             <div class="modal-body">
                                 <p class="text text-danger">
                                     You are not allowed to add topic to this community because you are not a member of this community. since
                                     you do not belong to this community, you are not allowed to add a topic to this community and this is inline
                                     with our terms and condition.
                                 </p>
                             </div>
                             <div class="modal-footer">
                                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                             </div>
                         </div>

                     </div>
                 </div>
             @endif
             
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
                                <a href="profile/{{$topic->created_by}}"><span class="disp-detail">{{$topic->created_by}}</span></a>
                                <span class="disp-detail">{!! $geo->getLgState($geo->getLgId($topic->local_government)[0]->id)->state !!}, {!! $topic->local_government !!}, {!! \App\User::where('username',$topic->created_by)->get()[0]->area !!}</span>
                                <span class="disp-detail">Ile-Ife</span>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <h2>TOPIC: {!! $topic->title !!}</h2>
                            <p>
                                {{ $topic->content }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-1">
                <h2>Comments: </h2>
                <div class="forum-comment">
                    @foreach($comments as $comment)
                    <div class="each-comment">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <!-- The Topic owner info-->
                                <img class="thumbnail"  style="width: 80px; height: 80px;"  src="{{  $user->getUserByUname($comment->comment_by)[0]->profile_pic ? $user->getUserByUname($comment->comment_by)[0]->profile_pic : 'images/user.jpg' }}">
                                <div class="user-description">
                                    <a href="profile/{!! $comment->comment_by !!}"><span class="disp-detail">{!! $comment->comment_by !!}</span></a>
                                    <span class="disp-detail">{{ $geo->getState($user->getUserByUname($comment->comment_by)[0]->state)->state }}</span>
                                    <span class="disp-detail">{{$user->getUserByUname($comment->comment_by)[0]->local_government}}, {{$user->getUserByUname($comment->comment_by)[0]->area}}</span>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                <p>
                                    {{ $comment->comment }}
                                </p>
                            </div>
                        </div>
                    </div>

                        @if($user->isAdmin() && (int)$user->adminLevel() >= 1)
                            <div style="float: right;">
                                <a href="comment/{!! $comment->id !!}/edit"><span class="delete green"><span class="glyphicon glyphicon-pencil"></span> </span></a>
                                <a href="comment/{!! $comment->id !!}/delete"  onclick="if(Confirm()){return true; }else{return false;} "><span class="delete red"><span class="glyphicon glyphicon-flag"></span> </span></a>
                            </div>
                        @endif

                        <hr>
                        @endforeach
                    @if($comments->count() == 0)
                        <h3 class="text text-success">No Comments on this topic, be the first to comment</h3>
                    @endif
            </div>
            
            <div>
                @if (count($errors) > 0)
                        <!-- Form Error List -->
                <div class="alert alert-{!! json_decode($errors->first(), true)['status'] ? 'success' : 'danger' !!}">
                    {{ json_decode($errors->first(), true)['message'] }}
                </div>
                @endif
                <form role="form" action="topics/{!! $topic->id !!}" method="POST">
                    <div class="form-group">
                        <label for="email">Add Comment:</label>
                        <textarea class="form-control" name="comment"></textarea>
                        {!! csrf_field() !!}
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Post Comment" class="form-control btn btn-success" style=""/>
                    </div>
                </form>
            </div>
        </div>
       </div>
    </div>
    
   </div>
</div>
    </div>
@include('includes.modal')
@include('includes.footer')