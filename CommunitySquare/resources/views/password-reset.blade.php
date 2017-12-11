<?php

?>
@include('includes.top')
@include('includes.header')
<div class="body " style=" margin-top: 23px; ">
    <div class="row">
        <div class=" virral col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3" align="" style="border:2px solid #EEEEEE;min-height: 300px; margin-top: 10px; -webkit-border-radius: 10px ;-moz-border-radius: 10px ;border-radius: 10px;">
            <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1">
                <fieldset>
                    <legend>
                        <h2 style="color: rgb(51, 122, 183);" align="center">PASSWORD RESET</h2>
                    </legend>
                    @if(count($errors) > 0)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-{{ json_decode($error, true)['status'] ? 'success' : 'danger' }}">
                                {!! $error !!}
                            </div>
                        @endforeach
                    @endif
                    <form class="form" method="POST" action="password/reset">
                        <div class="form-group">
                            <label for="email" class="">Account Email:</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Input your email" />
                        </div>
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <button class="btn btn-warning form-control">Reset...</button>
                        </div>
                    </form>
                </fieldset>
            </div>


        </div>
    </div>
</div>
@include('includes.modal')
@include('includes.footer')