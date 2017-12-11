<?php
    $geo = new \App\Http\Controllers\GeoController();
    $states = $geo->getState($data->state);
    $state  = $states->state;
    $commentCon = new \App\Http\Controllers\ForumCommentController();
    $no_of_comments = $commentCon->getAllCommentsFromUser($data->username)->count();
    $topicCont = new \App\Http\Controllers\ForumController();
    $no_of_topics = $topicCont->getAllTopicsByUser($data->username)->count();
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
             <a href="/profile/{!! Auth::user() ? Auth::user()->username : '' !!}">
                <div class="forum-ls">Profile</div>
             </a>
             
             
         </div>
         
         <div id="community" style="padding: 10px;">
            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-1">
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="detail-user">
                        <h1>{!! $data->username !!}'s profile</h1>
                        <div class="profile-pic-wrapper">
                            <img class="profile-pic" src="{!! isset($data->profile_pic) && strlen($data->profile_pic) > 0 ? $data->profile_pic : 'images/user.jpg' !!}" style="max-height: 400px; max-width: 340px;">
                        </div>
                        <div class="no-of-top">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="min-height: 30px;">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 orange det">Topics: {!! $no_of_topics !!}</div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 orange det">Comments: {!! $no_of_comments !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                    <div class="each-det-wrapper">
                        <div class="each-det"><span class="text bold">Username:</span> {!! $data->username !!}</div>
                        <div class="each-det"><span class="text bold">Email:</span> {!! $data->email !!}</div>
                        <div class="each-det"><span class="text bold">Age:</span> {!! $data->age !!}</div>
                        <div class="each-det"><span class="text bold">Area:</span> {!! $data->area !!}</div>
                        <div class="each-det"><span class="text bold">Community:</span> {!! $data->local_government !!}</div>
                        <div class="each-det"><span class="text bold">State:</span> {!! $state !!}</div>
                        <div class="each-det"><span class="text bold">Nationality:</span> Nigeria</div>
                        <div class="each-det"><span class="text bold">Address:</span> {!! $data->address !!}</div>
                        <div class="each-det"><span class="text bold">Level:</span> {!! $data->user_level > 0 ? 'Moderator' : '' !!}</div>
                        @if(Auth::user() && $data->username == Auth::user()->username)
                            <div class="each-det"><a href="profile/update/true"><span class="text bold">Update Profile:</span></a></div>
                        @endif
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