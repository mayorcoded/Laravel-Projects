@include('includes.top')
@include('includes.header')
<div class="body " style=" margin-top: 23px; ">
    <div class="row">
        <div class=" virral col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3" align="" style="border:2px solid #EEEEEE;min-height: 300px; margin-top: 10px; -webkit-border-radius: 10px ;-moz-border-radius: 10px ;border-radius: 10px;">
            <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1">
                <fieldset>
                    <legend>
                        <h2 style="color: rgb(51, 122, 183);" align="center">ADD ADMINS</h2>
                    </legend>

                    @if(isset($data) && $data['status'])
                        <div class="alert alert-success">
                            {!! $data['message'] !!}
                        </div>
                    @endif

                    <form class="form" method="POST" action="addadmin">
                        <div class="form-group">
                            <label for="email" class="">Username:</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Input username" value="{!!isset($data['username']) ? $data['username'] : '' !!}" />

                            @if(isset($data) && !$data['status'] && isset($data['message']['username']))
                                <div class="alert alert-danger" style="min-height: 25px; padding-top: 2px; padding-bottom: 0;">
                                    {!! $data['message']['username'] !!}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email" class="">Level:</label>
                            <input type="number" name="level" id="username" class="form-control" placeholder="Input user level" value="{!! isset($data['level']) ? $data['level'] : '' !!}" />

                            @if(isset($data) && !$data['status'] && isset($data['message']['level']))
                                <div class="alert alert-danger" style="min-height: 25px; padding-top: 2px; padding-bottom: 0;">
                                    {!! $data['message']['level'] !!}
                                </div>
                            @endif
                        </div>
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <button class="btn btn-warning form-control">Add...</button>
                        </div>
                    </form>
                </fieldset>
            </div>


        </div>
    </div>
</div>
@include('includes.modal')
@include('includes.footer')