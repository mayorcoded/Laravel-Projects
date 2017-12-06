<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="loginModalLabel">Login / Register</h4>
            </div>
            <div class="modal-body">
                <div class="row text-center">
                    <div class="col-sm-6">
                        <a href="{{route('login_facebook', "google")}}" class="btn btn-block btn-danger bg-danger upper">
                            <span class="fa fa-google-plus-square"></span>
                            <b>Login</b>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{route('login_facebook', "facebook")}}" class="btn btn-block btn-primary bg-primary">
                            <span class="fa fa-facebook-square"></span>
                            Login
                        </a>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-primary backcolor">Save changes</button>-->
            </div>
        </div>
    </div>
</div>
