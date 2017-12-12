<!DOCTYPE html>
<html lang="en">
<head>
    <base href="{{env('APP_URL')}}">

    <meta charset="UTF-8">
    <title>Queue System</title>
    <link type="text/css" rel="stylesheet" href="styles/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="styles/home.css">
</head>
<body>

<div class="body-wrapper">
    <div class="inner-content-wrapper">
        <div class="container">
            <div style="color: black; font-weight: 700;">
                Hello, {{Auth::user()->name}}
            </div>
            <div class="jumbotron dashboard">
                <div class="menu-bar">
                    <div class="list-group" style="">
                        <a href="#home" class="list-group-item active" data-toggle="tab"><i class="fa fa-user"></i> Home</a>
                        <a href="#profile" data-toggle="tab" class="list-group-item"><i class="fa fa-user"></i> Profile</a>
                        <a href="#meetings" data-toggle="tab" class="list-group-item"><i class="fa fa-anchor"></i> Recent meetings</a>
                        <a href="account/logout" class="list-group-item"><i class="fa fa-power-off"></i>Logout</a>
                    </div>
                </div>
                <div class="info-bar">
                    <div id="home" class="tab-pane fade in active">
                        {{--<div class="bg-1 row" style="text-align: center;margin-top: 40px;">--}}
                            {{--<div class="btn btn-2" data-toggle="modal" data-target="#register">--}}
                                {{--<button data-toggle="modal" data-target="#queue">Queue</button></a>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        @if($meetings->count() == 0)
                            <h3 style="text-align: center;margin-top: 40px;">You have no upcomming meeting</h3>
                        @else
                            <h3 style="text-align: center;margin-top: 40px;">You have an upcoming meeting with :</h3>
                            @foreach($meetings as $key => $meeting)
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}">
                                                    {{$meeting->getAdmin($meeting->added_by)->name}} on {{strftime('%Y-%m-%d %H:%M:%S',$meeting->attend_to)}}</a>
                                            </h4>
                                        </div>
                                        <div id="collapse{{$key}}" class="panel-collapse collapse {{ $key == 0 ? 'in' : '' }}">
                                            <div class="panel-body"><strong>Message: </strong>{{$meeting->complaint}}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div id="profile" class="tab-pane fade">
                        <div class="bg-1 row" style="text-align: center;margin-top: 40px;">
                            <div class="btn btn-2" data-toggle="modal" data-target="#register">
                                <button>Profile</button></a>
                            </div>
                        </div>
                        <table class="table">
                            <tr>
                                <td>Name</td>
                                <td>{!! Auth::user()->name !!}</td>
                            </tr>
                            <tr>
                                <td>Login : </td>
                                <td>{!! Auth::user()->email !!}</td>
                            </tr>
                            <tr>
                                <td>Meetings</td>
                                <td>{!! \App\Complaint::where('admin_id',Auth::user()->user_id)->get()->count() !!}</td>
                            </tr>
                        </table>
                    </div>
                    <div id="meetings" class="tab-pane fade">

                        @if($omeetings->count() == 0)
                            <h3 style="text-align: center;margin-top: 40px;">You have had no meeting</h3>
                        @else
                            <h3 style="text-align: center;margin-top: 40px;">You have had meeting with :</h3>
                            @foreach($omeetings as $key => $omeeting)
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}">
                                                    {{$omeeting->getAdmin($omeeting->added_by)->name}} on {{strftime('%Y-%m-%d %H:%M:%S',$omeeting->attend_to)}}</a>
                                            </h4>
                                        </div>
                                        <div id="collapse{{$key}}" class="panel-collapse collapse {{ $key == 0 ? 'in' : '' }}">
                                            <div class="panel-body"><strong>Message: </strong>{{$omeeting->complaint}}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="queue" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-plus"></i> Book Meeting</h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-10 col-lg-offset-1" style="margin-top: 30px;">
                    <form role="form" class="queue">
                        <div class="error"></div>

                        <div class="form-group">
                            <textarea style="min-height: 200px;" class="form-control complaint" id="email" autocomplete="off" placeholder="Your complaint summarized in less that 220characterd"></textarea>
                            <span class="text text-danger email-err"></span>
                        </div>
                        <div class="form-group">
                            <select style="" class="form-control admin_id" id="email" autocomplete="off" placeholder="Your complaint summarized in less that 220characterd">
                                @foreach($admins as $admin)
                                    <option value="{{$admin->user_id}}">{{$admin->name}}</option>
                                @endforeach
                            </select>
                            <span class="text text-danger email-err"></span>
                        </div>

                        <div class="form-group">
                            <div class="bg-1 row" style="text-align: center;margin-top: 0px;">
                                <div class="btn btn-2">
                                    <button type="submit">Queue</button></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
{!! csrf_field() !!}
<script src="js/jquery.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    $('form.queue').submit(function(e){
        console.log(" wik ");
        e.preventDefault();
        var content = $('.queue .complaint').val();

        var admin_id = $('.queue select.admin_id option:selected').val();
        var token = $('input[name="_token"]').val();

        var data = 'message='+content+'&admin_id='+admin_id+'&_token='+token;

        $.ajax({
            type :   'POST',
            url: 'account/queue/create',
            data: data,
            success : function(data) {
                var d = JSON.parse(data);
                if (d['status']) {
                    $('form.queue').html('' +
                            '<div class="alert alert-success">' + d.message + '</div>');
                } else {
                    var error = $('.queue .error');
                    error.addClass('alert alert-danger');
                    error.text( d.message);
                }
            },
            error : function(){
                alert('Could not connect to the server');
            }
        });
    });
</script>
</body>
</html>