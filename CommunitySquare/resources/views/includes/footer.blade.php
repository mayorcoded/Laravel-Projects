<?php
    $geo = new \App\Http\Controllers\GeoController();
    $states_ = $geo->getAllStates();
?>
<div class="error"></div>
<footer data-ng-model-options="">
    <div class="col-lg-12" align="center" style="    padding-top: 20px;">
            <ul class="ft_ul">
                <li><a href="password/reset"> Password Recorvery</a></li>
                <li><a href="password/recover"> Reset Password</a></li>
                <li><a href="community"> Communities</a></li>
            </ul>
        <span><i class="fa fa-copyright"></i>2016 communitysquare</span>
    </div>
</footer>
@include('includes.scripts')
</body>
</html>