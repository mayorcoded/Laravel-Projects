@extends('layout.master')

@section('content')
    <div class="contents">
        <div class="custom-container">
            <div class="row">
                <!-- Bread Crumb Start -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{route('index')}}">Home</a></li>
                        <li class="active">Admin - Setup</li>
                    </ol>
                </div>
                <!-- Bread Crumb End -->
                <!-- Content Column Start -->
                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 equalcol conentsection">
                    <!-- Contents Section Started -->
                    <div class="sections">
                        <h2 class="heading">Artists</h2>
                        <div class="clearfix"></div>
                        <div class="panel-group" id="accordion">
                            {{--Add New Channel--}}
                            <div class="panel panel-danger">
                                @if(session('jsonRedirectResponse'))
                                    <?php
                                    $response_ = json_decode(session('jsonRedirectResponse'), true);
                                    ?>
                                    @if(isset($response_['message']))
                                        <div class="alert alert-{{$response_['status'] ? 'success' : 'danger'}}">
                                            {{ $response_['status'] ? $response_['message'] : 'Artist not added, please check form fields for errors'}}
                                        </div>
                                    @endif
                                @endif

                                <form class="form-horizontal" method="post" action="{{route('admin.artist.add')}}" role="form">
                                    {{csrf_field()}}
                                    <div class="panel-heading">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse[[artist-id]]">
                                            <div class="row panel-title">
                                                <div class="col-sm-2 text-right">
                                                    <h4>Artist Name:</h4>
                                                </div>
                                                <div class="col-sm-10">
                                                    <input value="{{isset($name) ? $name : request('name')}}" name="name" class="form-control" id="artist-{{$artists->count()}}" placeholder="Enter Artist Name">
                                                    @if(isset($response_['status']) && !$response_['status'] && isset($response_['message']['name']))
                                                        <div class="text text-danger">{{$response_['message']['name']}}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div id="collapse[[artist-id]]" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="nickname-{{$artists->count()}}" class="col-sm-2 control-label">Nick Name</label>
                                                <div class="col-sm-10">
                                                    <input  value="{{isset($nickname) ? $nickname : request('nickname')}}" class="form-control" name="nickname" id="nickname-{{$artists->count()}}" placeholder="Artist's Nick Name">
                                                    @if(isset($response_['status']) && !$response_['status'] && isset($response_['message']['nickname']))
                                                        <div class="text text-danger">{{$response_['message']['nickname']}}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="description-{{$artists->count()}}" class="col-sm-2 control-label">Description</label>
                                                <div class="col-sm-10">
                                                    <input value="{{isset($description) ? $description : request('name')}}" name="description" class="form-control" id="description-{{$artists->count()}}" placeholder="Description">
                                                    @if(isset($response_['status']) && !$response_['status'] && isset($response_['message']['description']))
                                                        <div class="text text-danger">{{$response_['message']['description']}}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="[[artist-channels]]" class="col-sm-2 control-label">Channels</label>
                                                <div class="col-sm-10">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body channels-list-admin">
                                                            <div class="form-group">
                                                                <label for="channel" class="col-sm-1 control-label">ID: </label>
                                                                <div class="col-sm-11">
                                                                    @if(isset($response_['channels']))
                                                                        @foreach($response_['channels'] as $key => $channel)
                                                                            <input name="channels[]" class="form-control" value="{{$channel}}" id="channel"
                                                                                   placeholder="Enter Youtube Channel ID">
                                                                            @if(isset($response_['errors']))
                                                                                <div class="text text-danger">{{$response_['errors'][$key]}}</div>
                                                                            @endif
                                                                        @endforeach
                                                                    @else

                                                                        <input name="channels[]" class="form-control" id="channel"
                                                                               placeholder="Enter Youtube Channel ID">
                                                                    @endif

                                                                    @if(isset($response_['status']) && !$response_['status'] && isset($response_['message']['channels']))
                                                                        <div class="text text-danger">{{$response_['message']['channels']}}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel-footer">
                                                            &nbsp;&nbsp;
                                                            <button type="button" class="btn btn-sm btn-primary backcolor"  onclick="addMoreChannelDOM()"><span class="fa fa-youtube"></span> Add More</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="featured-{{$artists->count()}}" class="col-sm-2 control-label">Featured:</label>
                                                <div class="col-sm-10">
                                                    <input type="checkbox" class="form-control" name="featured" id="featured-{{$artists->count()}}"
                                                           placeholder="Description">

                                                    @if(isset($response_['status']) && !$response_['status'] && isset($response_['message']['featured']))
                                                        <div class="text text-danger">{{$response_['message']['featured']}}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer text-right">
                                        <button type="submit" class="btn btn-primary backcolor"><span class="fa fa-save"></span> Save</button>
                                    </div>
                                </form>
                            </div>
                            {{--Edit old channels--}}
                            @foreach($artists as $artist)
                                <div class="panel panel-danger">
                                    @if(session('artist_update_'.$artist->artist_id))
                                        <div class="alert alert-success">{{session('artist_update_'.$artist->artist_id)}}</div>
                                    @endif

                                    @if(session('jsonRedirectResponse'))
                                        <?php
                                        $response_ = json_decode(session('jsonRedirectResponse'), true);
                                        ?>
                                        @if(isset($response_['error_'.$artist->artist_id]))
                                            <div class="alert alert-{{$response_['status'] ? 'success' : 'danger'}}">
                                                {{ $response_['error_'.$artist->artist_id] ? $response_['error_'.$artist->artist_id] : 'Artist not updated, please check form fields for errors'}}
                                            </div>
                                        @endif
                                        @if(isset($response_['artist_update_'.$artist->artist_id]))
                                            <div class="alert alert-success">
                                                {{ $response_['artist_update_'.$artist->artist_id] ? $response_['artist_update_'.$artist->artist_id] : 'Artist not updated, please check form fields for errors'}}
                                            </div>
                                        @endif
                                    @endif
                                <form class="form-horizontal" role="form" method="post" action="{{route('admin.artist.update',$artist->artist_id)}}">
                                    {{csrf_field()}}
                                    <div class="panel-heading">
                                        <a  data-toggle="collapse" data-parent="#accordion" href="#collapse{{$artist->artist_id}}">
                                            <div class="row panel-title">
                                                <div class="col-sm-2 text-right">
                                                    <h4>Artist Name:</h4>
                                                </div>
                                                <div class="col-sm-10">
                                                    <input class="form-control"
                                                           name="name" id="artist-{{$artist->artist_id}}"
                                                           placeholder="Enter Artist Name" value="{{$artist->name}}">
                                                    @if(isset($response_['status']) && !$response_['status'] && isset($response_['message']['name_'.$artist->artist_id]))
                                                        <div class="text text-danger">{{$response_['message']['name_'.$artist->artist_id]}}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div id="collapse{{$artist->artist_id}}" class="panel-collapse collapse {{--panel-collapse collapse in--}}">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="nickname-{{$artist->artist_id}}" class="col-sm-2 control-label">Nick Name:</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control"
                                                           name="nickname" id="nickname-{{$artist->artist_id}}"
                                                           placeholder="Artist's Nick Name" value="{{$artist->nickname}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="description-{{$artist->artist_id}}" class="col-sm-2 control-label">Description:</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control"
                                                           name="description" id="description-{{$artist->artist_id}}"
                                                           placeholder="Description" value="{{$artist->description}}">

                                                    @if(isset($response_['status']) && !$response_['status'] && isset($response_['message']['description_'.$artist->artist_id]))
                                                        <div class="text text-danger">{{$response_['message']['description_'.$artist->artist_id]}}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="[[artist-channels]]" class="col-sm-2 control-label">Channels:</label>
                                                <div class="col-sm-10">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body at-{{ $artist->artist_id }}">
                                                            @if(isset($response_['channels_'.$artist->artist_id]))
                                                                @foreach($response_['channels_'.$artist->artist_id] as $key => $channel)
                                                                    <div class="form-group" data-idt="tr-{{$channel.$key}}">
                                                                        <label for="channel-{{$channel.$key}}" class="col-sm-1 control-label">
                                                                            ID: <a href="#bdsbvs" onclick="removeChannelDOM('{{$channel.$key}}')">X</a>
                                                                        </label>
                                                                        <div class="col-sm-11">
                                                                            <input class="form-control"
                                                                                   name="channels[]" id="channel-{{$channel.$key}}"
                                                                                   placeholder="Enter Youtube Channel ID" value="{{$channel}}">

                                                                            @if(isset($response_['errors_'.$artist->artist_id]))
                                                                                <div class="text text-danger">{{$response_['errors_'.$artist->artist_id][$key]}}</div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                @foreach($artist->channels as $key => $channel)
                                                                    <div class="form-group" data-idt="tr-{{$channel->channel->channel_id.$key}}">
                                                                        <label for="channel-{{$channel->channel->channel_id}}" class="col-sm-1 control-label">
                                                                            ID:  <a href="#bdsbvs" onclick="removeChannelDOM('{{$channel->channel->channel_id.$key}}')">X</a>
                                                                        </label>
                                                                        <div class="col-sm-11">
                                                                            <input class="form-control"
                                                                                   name="channels[]"
                                                                                   id="channel-{{$channel->channel->channel_id}}"
                                                                                   placeholder="Enter Youtube Channel ID" value="{{$channel->channel->youtube_id}}">
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="panel-footer">
                                                            &nbsp;&nbsp;
                                                            <button type="button" class="btn btn-sm btn-primary backcolor" onclick="addMoreChannelDOM('.at-{{$artist->artist_id}}')"><span class="fa fa-youtube"></span> Add More</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="featured-{{$artist->artist_id}}" class="col-sm-2 control-label">Featured:</label>
                                                <div class="col-sm-10">
                                                    <input type="checkbox" class="form-control"
                                                           name="featured" id="featured-{{$artist->artist_id}}"
                                                           placeholder="Description" {{(($artist->featured)?'checked':'')}}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer text-right">
                                        <button type="submit" class="btn btn-primary backcolor"><span class="fa fa-save"></span> Save</button>
                                    </div>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <!-- Contents Section End -->
                </div>
                <!-- Content Column End -->
                <!-- Gray Sidebar Start -->
                @include('layout.admin-menu')
                <!-- Gray Sidebar End -->
            </div>
        </div>
    </div>
@endsection