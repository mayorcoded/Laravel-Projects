<?php
$geo = new \App\Http\Controllers\GeoController();
$commentC = new \App\Http\Controllers\ForumCommentController();
$account = new \App\Http\Controllers\AccountController();
$user = new \App\Http\Controllers\AccountController();
?>
@include('includes.top')
@include('includes.header')
<div class="body ">
    <div class="row">
    <div class="virral col-lg-10 col-md-12 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-" style=" min-height: 400px;">
       <div class="top-box col-lg-12 col-md-12 col-sm-12  col-xs-12">
         <div class="forum-header" style="">
             <a href="/community">
                 <div class="forum-ls">{!! $geo->getState($data->state_id)->state !!}</div>
             </a>
             <a href="/community/topics/{!! $geo->getLgId($data->lg)[0]->id !!}">
                <div class="forum-ls">{!! $data->lg !!}</div>
             </a>

             @if(Auth::user() && $data->lg == Auth::user()->local_government)
                 <a href=""  data-toggle="modal" data-target="#addTopic">
                     <div class="forum-ls float-right">Create Topic</div>
                 </a>
             @elseif(!Auth::user())

                 <div class="forum-ls float-right"  data-toggle="modal" data-target="#info" style="min-width: 50px !important; border-radius: 100%;
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

         <div class="table-responsive">
             <h2>Topics: In {!! $data->lg !!} community</h2>
             @if($topics->count() == 0)
                <h3 class="text-warning"><span class="text-danger">Opps...</span> No topic has been created in this community. Be the first to create a topic</h3>
             @endif
             @foreach($topics as $topic)
                 <div class="each-topic row" align="left">
                     <div class="col-lg-12" style="padding-bottom: 4px;">
                         <div class="col-lg-1" style="padding-left: 0;">
                             <img class="img-circle topic-img" style=";" src="{{ $user->getUserByUname($topic->created_by)[0]->profile_pic ? $user->getUserByUname($topic->created_by)[0]->profile_pic : 'images/user.jpg'}}">
                         </div>

                         <div class="col-lg-10">
                             <div class="" style="">
                                 <div class="each-topic-clear">
                                     <div class="forum-topic">
                                         <a href="topics/{{$topic->id}}" class="topics-a">
                                             <span class="h3">{{$topic->title}}</span>
                                         </a>
                                     </div>
                                     <div class="forum-details">
                                         <span class="added-lg">{!! $geo->getState(\App\User::where('username',$topic->created_by)->get()[0]->state)->state !!}, {{\App\User::where('username',$topic->created_by)->get()[0]->local_government}}</span>
                                     </div>
                                 </div>

                                 <div class="fixed-bottom" style="">
                                     <ul class="topic-det">
                                         <li><i class="fa fa-user"></i> <a href="profile/{{$topic->created_by}}">{{$topic->created_by}}</a></li>
                                         <li><i class="fa fa-comment"></i> {{ $commentC->getTopicComments($topic->id)->count()}} comments</li>
                                         <li><i class="fa fa-clock-o"></i> {{$topic->created_at}} ago</li>
                                     </ul>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
            @endforeach
            {!! $topics !!}
         </div>
       </div>
    </div>

   </div>
</div>
@include('includes.modal')
@include('includes.footer')