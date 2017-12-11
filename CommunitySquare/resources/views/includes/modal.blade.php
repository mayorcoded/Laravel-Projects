<?php
$getStates = new \App\Http\Controllers\GeoController();
$states = $getStates->getAllStates();
?>
<div id="login" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Login:</h4>
            </div>
            <div class="modal-body">
                <div class="login_error"></div>
                <form role="form" method="post" action="login" onsubmit="login(); return false;">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="checkbox">
                        <label class="text-warning"><span class="text text-danger">*</span> Html tags are not allowed</label>
                    </div>
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div id="register" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Register an Account</h4>
            </div>
            <div class="modal-body register">
                <div class="reg_error"></div>
                <form role="form" method="post" onsubmit="register(); return false;">
                    <div class="form-group">
                        <label for="email">Username:</label>
                        <input type="text" class="form-control" id="email" name="username">
                        <span class="username_er error"></span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" name="email">
                        <span class="email_er error"></span>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Age:</label>
                        <select class="form-control" name="age">
                            <option class="form-control" selected="selected">Select age group</option>
                            <option value="below 18">Below 18</option>
                            <option value="18-24">18 - 24</option>
                            <option value="25-30">25 - 30</option>
                            <option value="31-45">31 - 38</option>
                            <option value="39-45">39 - 45</option>
                            <option value="46-50">46 - 50</option>
                            <option value="51-60p">51 - 60</option>
                            <option value="above 60">Above 60</option>
                        </select>
                        <span class="age_er error"></span>
                    </div>

                    <div class="form-group">
                        <label for="pwd">Country:</label>
                        <select class="form-control" name="country">
                                <option value="Country" class="form-control">Nigeria</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pwd">State/Teritory:</label>
                        <select class="form-control states" onchange="loadLG()" name="state">
                            <option value="Select age group" class="form-control">Select State</option>
                            @foreach($states as $state)
                                <option value="{!! $state->id !!}" class="form-control">{!! $state->state !!}</option>
                            @endforeach
                        </select>
                        <span class="state_er error"></span>
                    </div>

                    <div class="form-group">
                        <label for="pwd">Select Community:</label>
                        <select class="form-control loadlg" name="lg">
                            <option value="Select age group" class="lg" class="form-control">Select a state</option>
                        </select>
                        <span class="lg_er error"></span>
                    </div>

                    <div class="form-group">
                        <label for="pwd">Your Area:</label>
                        <input type="text" class="form-control" name="area">
                        <span class="area_er error"></span>
                    </div>


                    <div class="form-group">
                        <label for="pwd">Address:</label>
                        <textarea class="form-control loadlg" name="address" placeholder="Your address">
                        </textarea>
                        <span class="address_er error"></span>
                    </div>

                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" name="password" class="form-control">
                        <span class="password_er error"></span>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Re-Password:</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <div class="checkbox">
                        <input type="checkbox" name="agree">
                        <label class="text-warning"><span class="text text-danger">*</span> By clicking submit, you have have agreed to our terms/privacy</label>

                        <span class="agree_er error"></span>
                    </div>
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@if(Auth::user())
<div id="addTopic" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Topic</h4>
            </div>
            <div class="modal-body">
                <div class="topic_error"></div>
                <form role="form" onsubmit="addTopic(); return false;">
                    <div class="form-group">
                        <label for="email">Topic:</label>
                        <input type="text" class="form-control" id="email" name="title">
                        <span class="topic_er error"></span>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Content:</label>
                        <textarea class="form-control" name="content"></textarea>
                        <span class="content_er error"></span>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Age group:</label>
                        <select class="form-control" name="age">
                            <option>Select age group</option>
                            <option value="{!! Auth::user()->age !!}">{!! Auth::user()->age !!}</option>
                            <option value="all">All</option>
                        </select>
                        <span class="age_er error"></span>
                    </div>
                    <div class="checkbox">
                        <label class="text-warning"><span class="text text-danger">*</span> Html tags are not allowed</label>
                    </div>
                    <input type="hidden" name="lg" value="{!! Auth::user()->local_government !!}">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@endif