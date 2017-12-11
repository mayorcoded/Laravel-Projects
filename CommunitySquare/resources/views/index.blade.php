<?php
$allTopicC = new \App\Http\Controllers\ForumController();

if($allTopicC->getAllTopics()->count() < 5)
    $count = $allTopicC->getAllTopics()->count();
else if($allTopicC->getAllTopics()->count() > 0)
    $count=5;
else
    $count = 0;
if($count > 0)
    $trending = \App\Forum::get()->random($count);
$commentC = new \App\Http\Controllers\ForumCommentController();

$geo = new \App\Http\Controllers\GeoController();
$recent = \App\Forum::orderBy('id', 'desc')->get()->take($count);
$user = new \App\Http\Controllers\AccountController();
?>
@include('includes.top')
@include('includes.header')
<div class="body ">
    <div class="row">
        <div class="virral col-lg-10 col-md-12 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-" style=" min-height: 400px;">
           <div class="top-box col-lg-12 col-md-12">
               <div class="tray col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <div class="side-wiki">
                       <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <h2>Welcome to the Steam Discussions</h2>
                            <div class="steam_discussions_intro">
                                <p><span style="color: #ffffff;"><b>Everyone is invited!</b> The Steam discussions are for everyone, new and advanced user alike!</span></p>
                                <p><span style="color: #ffffff;"><b>Searching is key!</b> Before you post a question, use the forum search feature to determine whether your topic has already been covered.</span></p>
                                <p><span style="color: #ffffff;"><b>Do not start flame wars!</b> If someone has engaged in behavior that is a detriment to the message board — spamming, flaming people, etc — contact one of the forum moderators or report the post. Flaming the offensive user will only increase the problem. Harassment is not tolerated.</span></p>
                                <p><span style="color: #ffffff;"><b>Looking for the old forums?</b> They’re still available at</span></p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="min-height: 30px;">
                            <div class="fusion-one-third fusion-layout-column fusion-column-last fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;">
                                <div class="fusion-column-wrapper" style=" padding: 30px; background-color: rgb(12, 18, 25);">
                                    <h4>
                                        <span style="color: #999999;">LINKS & RESOURCES</span>
                                    </h4>
                                    <div class="fusion-sep-clear">
                                    </div>
                                    <div class="fusion-separator fusion-full-width-sep sep-single" style=""></div>
                                    <p>
                                        <span style="color: #999999;"><a style="color: #999999;" href="⋕"> Moderators</a></span>
                                    </p>
                                    <p>
                                        <span style="color: #999999;">
                                        Disclaimer: Administrators/Moderators reserve the right to move, change, or delete any content at any time if they feel it is inappropriate or unsuitable
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                     </div>
                   <a data-toggle="tab" href="#aboutus" target="#aboutus" data-toggle="tooltip" title="Getting started">
                    <div style="width: 100%; padding: auto auto; position: relative;margin-top: 0px; z-inedx: 10;" align="center">
                        <div id="about-button" class="img-circle" style="cursor:pointer;background-color: #fff;box-shadow: 0px 4px 3px #a2a2a2;width: 73px;height: 73px;margin:auto auto; z-index: 10;">
                                <span  class="fa fa-info" style="margin: auto auto;font-size: 60px;color:#999999;"></span>
            <!--                    <p class="about" style="visibility: hidden;">About Us</p>-->
                        </div>
                    </div>
                  </a>
                   </div>
                </div>
           </div>
            <div class="row" style="padding: 10px;">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px;">
                            <ul class="nav nav-tabs">
                              <li class="active"><a data-toggle="tab" href="#topic1">Trending Topics</a></li>
                              <li><a data-toggle="tab" href="#topic2">Recent Topics</a></li>
                              <li><a data-toggle="tab" href="#community">Communities</a></li>
                              <li><a data-toggle="tab" href="#aboutus">About us</a></li>
                            </ul>
                        </div>

                        <div class="tab-content">
                          <div id="topic1" class="tab-pane fade in active" align="left" style="padding: 10px 10px 10px 10px;">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                @if($count > 0)
                                    @for($i=0; $i < $trending->count(); $i++)
                                        <?php
                                        $topic = $trending[$i];
                                                ?>
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
                                                                <li><i class="fa fa-clock-o"></i> {!! $geo->convertToAgo($topic->created_at) !!}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                @endif
                            </div>
                          </div>
                          <div id="topic2" class="tab-pane fade" align="left" style="padding: 10px 10px 10px 10px;">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                @foreach($recent as $topic)
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
                                                            <li><i class="fa fa-clock-o"></i> {{ $geo->convertToAgo($topic->created_at) }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                          </div>
                          <div id="aboutus" class="tab-pane fade col-lg-10 col-md-10 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-1" style="padding: 12px;">
                            <h3>About Us</h3>
                            <p>Everyone is invited! The Steam discussions are for everyone, new and advanced user alike!

                            Searching is key! Before you post a question, use the forum search feature to determine whether your topic has already been covered.

                            Do not start flame wars! If someone has engaged in behavior that is a detriment to the message board â€” spamming, flaming people, etc â€” contact one of the forum moderators or report the post. Flaming the offensive user will only increase the problem. Harassment is not tolerated.

                            Looking for the old forums? Theyâ€™re still available at</p>
                          </div>

                          <div id="community" class="tab-pane fade" style="padding: 10px;">
                            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" style="margin-bottom:10px;">
                                <h3>We have 774 communities registered in community square</h3>
                                <h4 class="text text-success">with interesting topics</h4>
                                <form action="community">
                                    <button href="/community" class="btn btn-warning text text-warning">Get Started</button>
                                </form>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="min-height: 50px; padding: auto 20px;">
                        <div class="col-lg-12" style="margin-top: 20px; color: #3d4a5a;
                         font-family: sans-serif; background-color: #E4B9FC;
                        height: 300px; border-radius: 5px;
                        padding: 20px 10px;
                        ">
                            <span class="h3">Stats</span>
                            <hr style="margin-top: 10px;">
                            <div class="col-lg-12" style="background-color: #E497DA; border-radius: 5px; height: 50px; padding-top: 10px;
                            font-size: 22px; margin-bottom: 10px;">
                                <span class="icon-stat"><i class="fa fa-user"></i> Users({!! $user->getAllUsers() !!})</span>
                            </div>
                            <div class="col-lg-12" style="background-color: #E497DA; border-radius: 5px; height: 50px; padding-top: 10px;
                            font-size: 22px;  margin-bottom: 10px;">
                                <span class="icon-stat"><i class="fa fa-user"></i> Topics({!! $allTopicC->getTotalTopics() !!})</span>
                            </div>
                            <div class="col-lg-12" style="background-color: #E497DA; border-radius: 5px; height: 50px; padding-top: 10px;
                            font-size: 22px;   margin-bottom: 10px;">
                                <span class="icon-stat"><i class="fa fa-user"></i> Comments({!! $commentC->getAllComments_num() !!})</span>
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