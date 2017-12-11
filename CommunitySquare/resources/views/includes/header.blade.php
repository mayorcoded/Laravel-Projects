<header>
        <section class="navbar navbar-default navbar-fixed-top header" role="navigation" style="">
            <div class="row" style="">
                <div class="col-lg-10 col-md-12 col-lg-offset-1 col-md-offset-1 topper" style="height: 40px; padding:auto 10px;background-color: rgb(12, 18, 25);">
                    <ul class="header-ul left">
                        <li><i class="fa fa-envelope"></i> contact us</li>
                        <li><i class="fa fa-envelope"></i> contact us</li>
                        <li><i class="fa fa-envelope"></i> contact us</li>
                    </ul>
                    <ul class="header-ul right">
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    </ul>

                    <div style=" float: right;min-width: 200px;position: relative; background-color:transparent;">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search" style="    background-color: transparent;
    margin-top: 8px;">
                                <button type="submit" class="form-control"><span class="fa fa-search"></span></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-10 col-md-12 col-lg-offset-1 col-md-offset-1" style="padding: 0;">
                <div class="header-div">
                    <div class="logo-left">
                        <a href=""><img src="images/community.png" class="logo-img"></a>
                    </div>
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#toggle" style="border-color:#335C7D;color:#335C7D;background-color:#335C7D;">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="toggle" style="background-color: #f8f8f8;">
                        <ul class="nav navbar-nav navbar-right head-nav">
                            <li class=""><a href="./index.php">Home</a></li>
                            @if(!Auth::user())
                                <li class=""><a href="#login"   data-toggle="modal" data-target="#login">Login</a></li>
                                <li class=""><a href="#register"  data-toggle="modal" data-target="#register">Register</a></li>
                            @else
                                <li class=""><a href="profile/{!! Auth::user()->username !!}" >Profile</a></li>
                                <li class=""><a href="logout">Logout</a></li>
                            @endif
                            <li class=""><a href="./community">Community</a></li>
                        </ul>
                    </div>
                        <!--    <a href=""><div class="top-register text-center"-->
                        <!--                    style=""><p>Register</p></div></a>-->
                </div>
            </div>
        </div>
    </section>
</header>