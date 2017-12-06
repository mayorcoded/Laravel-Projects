
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 graysidebar">
    <!-- Quick Bets Widget start -->
    @include('utils.quick-bets')
            <!-- Quick Bets Widget End -->
    <!-- Calendar Widget start -->
    <div class="widget">
        <br>
        <div class="calendar">
            <div id="datepicker"></div>
        </div>
        <br>
    </div>
    <div class="clearfix"></div>
    <!-- Calendar Widget End -->
    <!-- Advertisement start -->
    <div class="widget">
        <img src="{{asset('images/adv2.gif')}}" class="img-responsive" alt="">
    </div>
    <div class="clearfix"></div>
    <!-- Advertisement End -->
</div>


@section('scripts')
    @parent
    <script>
        $(document).ready(function () {

            $('.ui-datepicker-current-day').on('click', function () {
                console.log('Hello');
            })
            $('.ui-datepicker-today').hover( function () {
                $( this ).fadeOut( 100 );
                $( this ).fadeIn( 500 );
                console.log('Hello');
            })
            $('.ui-state-default').hover( function () {
                console.log('Hello');
                console.log($(this).closest('td').attr('data-month'));
                console.log($(this).closest('td').attr('data-year'));
            })
        });
    </script>

@stop