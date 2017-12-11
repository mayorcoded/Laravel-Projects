<?php
$geo = new \App\Http\Controllers\GeoController();
$states = $geo->getState($data->state);
$state  = $states->state;
$commentCon = new \App\Http\Controllers\ForumCommentController();
$no_of_comments = $commentCon->getAllCommentsFromUser($data->user_id)->count();
$topicCont = new \App\Http\Controllers\ForumController();
$no_of_topics = $topicCont->getAllTopicsByUser($data->id)->count();
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
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                <div class="detail-user">
                                    <h1>Profile Update</h1>
                                    <div class="profile-pic-wrapper">
                                        <img class="profile-pic" src="{!! isset($data->profile_pic) && strlen($data->profile_pic) > 0 ? $data->profile_pic : 'images/user.jpg' !!}" style="height:80px; width: 80px;">
                                    </div>

                                    <form action="profile/update/profile_pic" method="POST" enctype="multipart/form-data">
                                        <input type="file" name="profile_pic" class="form-control">
                                        <button type="submit" class="btn btn-success form-control">Update Profile Pic</button>
                                        {!! csrf_field() !!}
                                    </form>
                                    @if (count($errors) > 0)
                                            <!-- Form Error List -->
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-{{ json_decode($error, true)['status'] ? 'success' : 'danger' }}">
                                                <ul>
                                                        {!! count(json_decode($error, true)[0]['message']) > 0 ? json_decode($error, true)[0]['message'] : $error !!}
                                                </ul>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                <div class="each-det-wrapper">
                                    <div class="each-det"><span class="text bold">Username:</span>
                                        <form action="profile/update/true" method="post">
                                            <input type="text" class="form-control" name="username" value="{!! $data->username !!}">
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn btn-success">+Update</button>
                                        </form>
                                    </div>
                                    <div class="each-det"><span class="text bold">Email:</span>
                                        <form action="profile/update/true" method="post">
                                            <input type="text" class="form-control" name="email" value="{!! $data->email !!}">
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn btn-success">+Update</button>
                                        </form>
                                       </div>
                                    <div class="each-det"><span class="text bold">Age:</span>
                                        <form action="profile/update/true" method="post">
                                            <select class="form-control" name="age">
                                                <option class="form-control" selected="selected">Select age group</option>
                                                <option value="below 18" {!! ($data->age == 'below 18') ? 'selected="selected"':'' !!}>Below 18</option>
                                                <option value="18-24" {!! ($data->age == '18-24') ? 'selected="selected"':'' !!}>18 - 24</option>
                                                <option value="25-30" {!! ($data->age == '25-30') ? 'selected="selected"':'' !!}>25 - 30</option>
                                                <option value="31-45" {!! ($data->age == '31-45') ? 'selected="selected"':'' !!}>31 - 38</option>
                                                <option value="39-45" {!! ($data->age == '39-45') ? 'selected="selected"':'' !!}>39 - 45</option>
                                                <option value="46-50" {!! ($data->age == '46-50') ? 'selected="selected"':'' !!}>46 - 50</option>
                                                <option value="51-60" {!! ($data->age == '51-60') ? 'selected="selected"':'' !!}>51 - 60</option>
                                                <option value="above 60" {!! ($data->age == 'above 60') ? 'selected="selected"':'' !!}>Above 60</option>
                                            </select>
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn btn-success">+Update</button>
                                        </form>
                                    </div>
                                    <div class="each-det"><span class="text bold">Area:</span>
                                        <form action="profile/update/true" method="post">
                                            <input type="text" class="form-control" name="area" value="{!! $data->area !!}">
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn btn-success">+Update</button>
                                        </form>
                                    </div>
                                    <div class="each-det"><span class="text bold">Community:</span> {!! $data->local_government !!}</div>
                                    <div class="each-det"><span class="text bold">State:</span> {!! $state !!}</div>
                                    <div class="each-det"><span class="text bold">Nationality:</span> Nigeria</div>
                                    <div class="each-det"><span class="text bold">Address:</span>
                                        <form action="profile/update/true" method="post">
                                            <textarea type="text" class="form-control" name="address" value="{!! $data->address !!}">{!! $data->address !!}</textarea>
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn btn-success">+Update</button>
                                        </form>
                                    </div>
                                    <div class="each-det"><span class="text bold">Update password:</span>
                                        <form action="profile/update/true" method="post">
                                            <label class="text-info">New Password</label>
                                            <input type="password" name="password" class="form-control">

                                            <label class="text-info">Re:New Password</label>
                                            <input type="password" name="password_confirmation" class="form-control">
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn btn-success">+Update</button>
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