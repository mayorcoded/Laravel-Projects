<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Music Video Betting</title>
    <!--// Responsive //-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!--// Stylesheets //-->
    <link href="{{asset('css/style.css')}}" rel="stylesheet" media="screen" />
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet" media="screen" />
    <link href="{{asset('css/app.css')}}" rel="stylesheet" media="screen" />
    {{-- favicon --}}
    <link href="{{asset('images/favicon.ico')}}" rel="icon" type="image/x-icon" />
    <!--[if lt IE 9]>
    <script src="{{asset('js/html5shiv.js')}}"></script>
    <script src="{{asset('js/respond.min.js')}}"></script>
    <![endif]-->
</head>
<body>
<!-- Wrapper Start -->
<div class="wrapper">
    <!-- Header Start -->
    @include('layout.header')
            <!-- Header End -->

    <!-- Contents Start -->
    @yield('content')
            <!-- Contents End -->

    <!-- Footer Start -->
    @include('layout.footer')
            <!-- Footer End -->
    <a href="#" class="pull-right gotop btn btn-primary backcolor"> <i class="fa fa-arrow-up"></i> </a>
</div>
<!-- Wrapper End -->



<!-- Modal Start -->
@include('utils.login-modal')
@include('bet.bet-modal')
        <!-- Modal End -->

@section('scripts')
        <!--// Javascript //-->
<script type="text/javascript" src="{{asset('js/vendor/jquery-1.11.1.min.js')}}"></script>
        <script type="text/javascript">
            var slipModal = function(header,content, selector1){
                if(selector1 == undefined)
                        var selector1 = '#betslip .modal-dialog';
                var data = '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        '<button type="button" class="close" data-dismiss="modal">&times;</button>' +
                        '<h4 class="modal-title">'+header+'</h4>' +
                        '</div>' +
                        '<div class="modal-body">' +
                        content +
                        '</div>' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
                        '</div>' +
                        '</div>' +
                        '';
                $(selector1).html(data);
            };
            var slipError = function(error, selector1){
                console.log("loading slip error");
                slipModal('Bet Slip', '<div class="alert alert-danger">'+error+'</div>',selector1)
            };
            var loadSlip = function(id){
                console.log("This is wiksiloh ");
                if(id !=  undefined){
                    $.ajax({
                        url : '{{route('bet.get')}}',
                        type: 'GET',
                        data:{bet:id},
                        error: function(){
                            slipError("Could not connect to the server... realoading page might fix")
                        },
                        success: function(d){

                            if(!d.status)
                                return slipError(d.message);
                            return showSlip(d.message);
                        }
                    });
                }
            };

            var showSlip = function(details){
                var slipHTML= '<ul class="bloglist">';
                console.log(details);
                console.log(details.bets);
                $.each(details.bets, function(i,detail) {
                    console.log(detail);
                    slipHTML += '<li>' +
                            '<div class="media">' +
                            '<a href="' + detail.video_url + '" class="pull-left">' +
                            '<img src="' + detail.image + '" class="media-object img-responsive hovereffect" alt="" />' +
                            '</a>' +
                            '<div class="media-body">' +
                            '<h4><a href="' + detail.video_url + '">' + detail.name + '</a></h4>' +
                            '<ul>' +
                            '<li><i class="fa fa-calendar"></i>' + detail.ending_date + '</li>' +
                            '<li> <i class="fa fa-eye"></i> ' + detail.max_views + ' </li>' +
                            '<li> ' + detail.odd + ' </li>' +
                            '</ul>' +
                            '</div>' +
                            '</div>' +
                            '</li>';
                    slipHTML += '</ul>';
                });
                slipHTML += '<h5 class="text text-primary">Bet status : <span class="badge">'+details.bet_status+'</span></h5>';
                slipHTML += '<h5 class="text text-primary">Payment : <span class="badge">'+details.payment_status+'</span></h5>';
                slipHTML += '<h5 class="text text-primary">Bet Date : <span class="badge">'+details.payment_date+'</span></h5>';
                slipHTML += '<h5 class="text text-primary">Total : <span class="badge">'+details.total+'</span></h5>';
                slipModal('Slip', slipHTML);
            };

            $('[data-target="#betslip"]').click(function(){
                $("#betslip .modal-dialog").html(' <div class="loading-anim" style="text-align: center; color: white; padding-top: 30px;">' +
                        '<span class="" style="font-size: 150px; display: block;">' +
                        '<i class="fa fa-circle-o fa-spin"></i>' +
                        '</span>' +
                        '<span class="text text-primary" style="font-size: 30px; display: block; padding: 5px; background-color: #cbc9be; border-radius: 10px;">Loading bet slip...</span> ' +
                        '</div>');
            });


            //add more channels
            var new_id = 1000;

            var addMoreChannelDOM = function(target){

                if(target === undefined)
                        target = ' .channels-list-admin';
                var w = $(target).append('<div data-idt="tr-'+new_id+'" class="form-group"> ' +
                        '<label for="channel" class="col-sm-1 control-label">ID: <a href="#bdsbvs" onclick="removeChannelDOM('+new_id+')">X</a></label> ' +
                        '<div class="col-sm-11">' +
                        '<input name="channels[]" class="form-control" id="channel" placeholder="Enter Youtube Channel ID"> ' +
                        '</div> ' +
                        '</div>');
                console.log($(target));
                new_id++;
                return false;
            };

            var removeChannelDOM = function(dom_id,target){
                if(target === undefined)
                    target = ' ';
              $(target+' [data-idt="tr-'+dom_id+'"]').remove();
                return false;
            };



            var startAddBetToCart = function(id){
                $("#betS232 .modal-dialog").html(' <div class="loading-anim" style="text-align: center; color: white; padding-top: 30px;">' +
                        '<span class="" style="font-size: 150px; display: block;">' +
                        '<i class="fa fa-circle-o fa-spin"></i>' +
                        '</span>' +
                        '<span class="text text-primary" style="font-size: 30px; display: block; padding: 5px; background-color: #cbc9be; border-radius: 10px;">Loading bet slip...</span> ' +
                        '</div>');''
                $("#betS232").modal('show');

                getVideoDetails(id).done(function(data){
                    var video = data.message;
                    if(video == [])
                        return;
                    console.log("loadin");
                    $('#video-img').attr('src',video.video_image);
                    $('#video-name').html(video.video_name);
                    $('#video-views').html(video.number_of_views);
                    $('#video-artist').html(video.artist);
                    $('#video-description').html(video.description);
                    $('#video-id').val(id);
                    $('#betS232').modal('hide');
                    $('#betModal').modal('show');
                });

            };
            var startUpdateCartItem = function(id){
                console.log("THIs is useless");
                $("#betS232 .modal-dialog").html(' <div class="loading-anim" style="text-align: center; color: white; padding-top: 30px;">' +
                        '<span class="" style="font-size: 150px; display: block;">' +
                        '<i class="fa fa-apple"></i>' +
                        '</span>' +
                        '<span class="text text-primary" style="font-size: 30px; display: block; padding: 5px; background-color: #cbc9be; border-radius: 10px;">Loading bet slip...</span> ' +
                        '</div>');''
                $("#betS232").modal('show');

                getVideoDetails(id, true).done(function(data){
                    var video = data.message;
                    if(video == [])
                        return;
                    console.log("loadin");
                    $('#video-img').attr('src',video.video_image);
                    $('#video-name').html(video.video_name);
                    $('#video-views').html(video.number_of_views);
                    $('#video-artist').html(video.artist);
                    $('#video-description').html(video.description);
                    $('.odd-show-111').html(video.odds);
                    $('.amount-show-111').html(video.amount);
                    $('#video-id').val(video.id);
                    $('input[name="maximum_view"]').val(video.maximum_view);
                    $('input[name="expiry"]').val(video.expiry);
                    $('input[name="amount"]').val(video.amount);
                    $('#betS232').modal('hide');
                    $('#betModal').modal('show');
                });

            };

            var getVideoDetails  =function(id, betdetail){
                var url = '{{route('video.get.json')}}';
                if(betdetail)
                        url = '{{route('bet.cart.item')}}';
                $('#form-bet-32 #success-alert').hide();

                return $.ajax({
                  url   : url,
                  data  :   {
                      id    : id
                  },
                  type  :   'get',
                  error :   function(){
                      alert("Oops... we could not get you connected to our server")
                  },
                  success   :   function(data){
                      console.log(data.message);
                      if(data.status){
                          return data.message;
                      }
                        console.log(data.message);
                      slipError(data.message, '#betS232 .modal-dialog');
                      return [];
                  }

              });
            };
            var betError = function(err){

            };

            var submitBet = function(tr){
                $('#form-bet-32 [type="submit"]').attr('disabled','disabled');
                $('#form-bet-32 .error').html('');
                $('#form-bet-32 #success-alert').hide();

                return sendSubmitRequest().done(function(data){

                    $('#form-bet-32 [type="submit"]').removeAttr('disabled');
                    if(!data.status){
                        $.each(data.message, function(i,e){
                            $('#form-bet-32 #'+i+'-error').html(e);
                        });

                        return;
                    }
                    $('#form-bet-32 #success-alert').html(data.message);
                    $('#form-bet-32 #success-alert').show();

                    if(tr){
                        setTimeout(function(){
                            window.location.reload(true);
                        },1500);
                    }

                });
            };

            var sendSubmitRequest = function(){
                var video_id = $('#form-bet-32 [name="video_id"]').val();
                var expiry = $('#form-bet-32 [name="expiry"]').val();
                var maximum_view = $('#form-bet-32 [name="maximum_view"]').val();
                var amount = $('#form-bet-32 [name="amount"]').val();
                console.log({
                    video_id    :   video_id,
                    expiry    :   expiry,
                    expimaximum_viewry    :   maximum_view,
                    amount    :   amount,
                    _token    : '{{csrf_token()}}',
                });
                return $.ajax({
                    url :   '{{route('bet.cart.add')}}',
                    type :  'post',
                    data :  {
                        video_id    :   video_id,
                        expiry    :   expiry,
                        maximum_view    :   maximum_view,
                        amount    :   amount,
                        _token    : '{{csrf_token()}}',
                    },
                    error   :   function(){
                        alert('Oops... we could not send your request to the server at the moment');
                        $('#form-bet-32 [type="submit"]').removeAttr('disabled');

                    },
                    success :   function(data){
                        return data;
                    }
                });
            }

            $(document).on('input', '[name="maximum_view"]', function(){
                generateUpdate();
            });
            $(document).on('input', '[name="expiry"]', function(){
                generateUpdate();
            });
            $(document).on('input', '[name="amount"]', function(){
                generateUpdate();
            });

            var generateUpdate = function(){
                var views = parseInt($('#video-views').text());
                var expiry = $('#form-bet-32 [name="expiry"]').val();
                var maximum_view = $('#form-bet-32 [name="maximum_view"]').val();
                var amount = $('#form-bet-32 [name="amount"]').val();
                amount = parseFloat(amount);
                var odds = compute(expiry, views, maximum_view);

                $('.odd-show-111').html((odds.odds).toFixed(3));
                $dd = (amount + parseFloat(amount * parseFloat(odds.odds)));
                $dd = parseFloat($dd).toFixed(3);
                console.log((amount +parseFloat(amount * parseFloat(odds.odds))));
                $('.amount-show-111').html($dd);
            };

        </script>
        <script>
            function compute(days, views, x){
                console.log({
                    days: days,
                    views: views,
                    x: x
                });

                var rank = 0;

                if(views < 1000000)
                    rank = 3;
                else if(views >= 1000000 && views < 1300000)
                    rank = 2;
                else if(views >= 1300000)
                    rank = 1;

                var average = 0;
                var prob = 0;
                var odds = 0;
                var constant = 0;

                switch(rank){
                    case 1:
                        constant = 10.03;
                        //Top dudes
                        break;
                    case 2:
                        constant = 8.8490;
                        //mid level dudes
                        break;
                    case 3:
                        constant = 8.06;
                        //Low dudes
                        break;
                    default :
                        constant = 1;
                }

                average = (Math.pow(Math.E, constant) * Math.pow(Math.E, (-0.0009 * days)));
                prob = (1 / (Math.sqrt(2 * Math.PI * average))) * Math.pow(Math.E, -1 * ((Math.pow((x - average), 2)) / (2 * average)));
                odds = prob / (1 - prob);

//                console.log({
//                    rank: rank,
//                    constant: constant,
//                    average: average,
//                    prob: prob,
//                    odds: odds
//                });

                return {
                    rank: rank,
                    constant: constant,
                    average: average,
                    prob: prob,
                    odds: odds
                };
            }
        </script>
<script type="text/javascript" src="{{asset('js/vendor/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vendor/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vendor/functions.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vendor/responsiveCarousel.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vendor/slimbox2.js')}}"></script>
 <script type="text/javascript" src="{{asset('js/search.js')}}"></script>
{{--<script type="text/javascript" src="{{asset('js/vendor/responsive-paginate.html')}}"></script>--}}
@show

@section('analytics')
        <!--<script>-->
<!--(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){-->
<!--(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),-->
<!--m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)-->
<!--})(window,document,'script','../../../../www.google-analytics.com/analytics.js','ga');-->

<!--ga('create', 'UA-50738310-1', 'softcircles.net');-->
<!--ga('send', 'pageview');-->

<!--</script>-->
@show
</body>
</html>