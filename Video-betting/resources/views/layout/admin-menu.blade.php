<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 equalcol graysidebar">
    <!-- Categories Widget start -->
    <div class="widget">
        <h2 class="heading">Shortcodes</h2>
        <div class="categorieslist">
            <ul>
                <li class="{{(Request::route()->getName() == 'setup')?'active':''}}">
                    <a href="{{route('setup')}}">MVB Setup</a>
                </li>
                {{--<li class="{{(Request::route()->getName() == 'admin.channel.add')?'active':''}}">--}}
                    {{--<a href="{{route('admin.channel.add')}}">Add Channels</a>--}}
                {{--</li>--}}
                <li class="{{(Request::route()->getName() == 'moderation')?'active':''}}">
                    <a href="{{route('moderation')}}">Video Moderation</a>
                </li>
                <li class="{{((Request::route()->getName() == 'settings') || (Request::route()->getName() == 'settings.update'))?'active':''}}">
                    <a href="{{route('settings')}}">Settings</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- Categories Widget End -->
</div>