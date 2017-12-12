<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Queue System</title>
    <link type="text/css" rel="stylesheet" href="styles/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="styles/home.css">
</head>
<body>
<div class="body-wrapper">
    <div class="inner-content-wrapper">
        <div class="container">
            <div class="jumbotron">
                <h1>Queue System</h1>
                <p align="center">
                    This is a queue system
                </p>
                <div class="bg-1 row" style="text-align: center;margin-top: 40px;">
                    <div class="btn btn-2" data-toggle="modal" data-target="#register">
                        <button>Register</button></a>
                    </div>
                    <div class="btn btn-3" data-toggle="modal" data-target="#login">
                        <button>Login</button></a>
                    </div>
                    <div class="btn btn-2" data-toggle="modal" data-target="#getting-started">
                        <button>Getting Started!</button></a>
                    </div>
                    <!--<div class="btn btn-1 col-xs-12 col-lg-3 col-md-3 col-xs-3">-->
                        <!--<button>Login!</button></a>-->
                    <!--</div>-->
                    <!--<div class="btn btn-1 col-xs-12 col-lg-3 col-md-3 col-xs-3">-->
                        <!--<button>Login!</button></a>-->
                    <!--</div>-->
                </div>
            </div>
        </div>
    </div>
</div>

<div id="getting-started" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Getting started</h4>
            </div>
            <div class="modal-body">
                <p>About this app.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
{!! csrf_field() !!}
<div id="login" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-log-in"></i> Login</h4>
            </div>
            <div class="modal-body row">
                <div class="col-lg-10 col-lg-offset-1" style="margin-top: 30px;">
                    <form role="form" class="login">
                        <div class="error"></div>

                        <div class="form-group">
                            <input type="text" class="form-control email" id="email" autocomplete="off" placeholder="Your registration number">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control password" id="pwd" autocomplete="off" placeholder="Your Password" aria-autocomplete="none">
                        </div>
                        <div class="form-group">
                            <div class="bg-1 row" style="text-align: center;margin-top: 0px;">
                                <div class="btn btn-2">
                                    <button type="submit">Login</button></a>
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

<div id="register" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-plus"></i> Register</h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-10 col-lg-offset-1" style="margin-top: 30px;">
                    <div class="error"></div>
                    <form role="form" class="register">
                        <div class="form-group">
                            <input type="text" class="form-control email" id="email" autocomplete="off" placeholder="Your Registration number">
                            <span class="text text-danger email-err"></span>
                        </div>
                        <div class="form-group">
                            <input type="name" class="form-control name" id="name" autocomplete="off" placeholder="Your Fullname">
                            <span class="text text-danger name-err"></span>

                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control password" id="pwd" autocomplete="off" placeholder="Your Password" aria-autocomplete="none">
                            <span class="text text-danger password-err"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control password2" id="pwd" autocomplete="off" placeholder="Your Password again" aria-autocomplete="none">

                        </div>

                        <div class="form-group">
                            <div class="bg-1 row" style="text-align: center;margin-top: 0px;">
                                <div class="btn btn-2">
                                    <button type="submit">Register</button></a>
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

<script src="js/jquery.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    $('form.register').submit(function(e){
        e.preventDefault();
        var name = $('.register .name').val();
        var password = $('.register .password').val();
        var password2 = $('.register .password2').val();
        var email = $('.register .email').val();
        var token = $('input[name="_token"]').val();
        if(name == undefined||password == undefined||password2==undefined||email==undefined){
            alert('You cannot leave any field blank');
            return false;
        }
        var data = 'name='+name+'&password='+password+'&password_confirmation='+password2+'&email='+email+'&_token='+token;

        $.ajax({
           type :   'POST',
            url: 'register',
            data: data,
            success : function(data){
                var d = JSON.parse(data);
                if(d['status']){
                    $('form.register').html('' +
                            '<div class="alert alert-success">'+d.message+'</div>');
                }else{
                    var error = $('.register .error');
                    error.addClass('alert alert-danger');
                    error.text('Please check the following error');
                    if(d.errors.name != null)
                        $('.register .name-err').text(d.errors.name);
                    if(d.errors.password != null)
                        $('.register .password-err').text(d.errors.password);
                    if(d.errors.email != null)
                        $('.register .email-err').text(d.errors.email);

                }
            },
            error: function(){
             alert('Error in connecting to server');
            }
        });
        return false;
    });
    $('form.login').submit(function(e){
        e.preventDefault();

        var password = $('.login .password').val();

        var email = $('.login .email').val();
        var token = $('input[name="_token"]').val();
        if(password == undefined||email==undefined){
            alert('You cannot leave any field blank');
            return false;
        }
        var data = '&password='+password+'&email='+email+'&_token='+token;
        $.ajax({
           type :   'POST',
            url: 'login',
            data: data,
            success : function(data){
                var d = JSON.parse(data);
                if(d['status']){
                    $('form.login').html('' +
                            '<div class="alert alert-success">'+d.message+'</div>');
                    setTimeout(function(){
                        window.location = 'account/';
                    },1400);
                }else{
                    var error = $('.login .error');
                    error.addClass('alert alert-danger');
                    error.text(d.message);


                }
            },
            error: function(){
             alert('Error in connecting to server');
            }
        });
        return false;
    });
</script>
</body>
</html>