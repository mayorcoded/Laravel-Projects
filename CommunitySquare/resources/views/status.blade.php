<?php
$data = json_decode($data, true);
?>
@include('includes.top')
@include('includes.header')
{!! print_r($data) !!}
<div class="body " style=" margin-top: 23px; ">
    <div class="row">
        <div class=" virral col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2" align="center" style="border:2px solid #EEEEEE;min-height: 300px; margin-top: 10px; -webkit-border-radius: 10px ;-moz-border-radius: 10px ;border-radius: 10px;">
            <h1 class="text text-{!! $data['status'] ? 'success' : 'danger' !!}">{!! $data['title'] !!}</h1>
            <img src="images/{!! $data['status'] ? 'right.jpg' : 'wrong.png' !!}" style="height: 200px; width: 200px;">
            <p class="text text-warning">{!! $data['message'] !!}</p>
        </div>
    </div>
</div>
@include('includes.modal')
@include('includes.footer')