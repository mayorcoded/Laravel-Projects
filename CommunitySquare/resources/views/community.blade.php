<?php
    $fetchAllState = new \App\Http\Controllers\GeoController();
    $states = $fetchAllState->getAllStates();
    $no_of_states = $states->count();
?>
@include('includes.top')
@include('includes.header')
<div class="body ">
    <div class="row">
    <div class="virral col-lg-10 col-md-12 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-" style=" min-height: 400px;">
       <div class="top-box col-lg-12 col-md-12 col-sm-12  col-xs-12">
         <div class="forum-header" style="">
             <a href="/index.php">
                 <div class="forum-ls">Home</div>
             </a>
             <a href="/community">
                <div class="forum-ls">Communities</div>
             </a>
             
             
         </div>
         
         <div id="community" style="padding: 10px;">
            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-1">
                <h3>We have 774 communities in 36 states present in nigeria registered in community square</h3>
                <h4 class="text text-success">with interesting topics</h4>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <ul>
                        @for($i=0; $i < $no_of_states/2; $i++)
                            <li  data-toggle="collapse" data-target="#state{!! $i !!}"><a>{!! $states[$i]->state !!}</a></li>
                            <ul id="state{!! $i !!}" class="collapse">
                                <?php
                                   $getLg = $fetchAllState->getStateLg($states[$i]->id);
                                ?>
                                @foreach($getLg as $lg)
                                    <li><a href="community/topics/{!! $lg->id !!}">{!! $lg->lg !!} ({!! \App\Forum::where('local_government',$lg->lg)->count() !!})</a></li>
                                @endforeach
                            </ul>
                        @endfor
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <ul>
                        @for($i=$i; $i < $no_of_states; $i++)
                        <li  data-toggle="collapse" data-target="#state{!! $i !!}"><a>{!! $states[$i]->state !!}</a></li>
                        <ul id="state{!! $i !!}" class="collapse">
                            <?php
                            $getLg = $fetchAllState->getStateLg($states[$i]->id);
                            ?>
                            @foreach($getLg as $lg)
                                <li><a href="community/topics/{!! $lg->id !!}">{!! $lg->lg !!} ({!! \App\Forum::where('local_government',$lg->lg)->count() !!})</a></li>
                            @endforeach
                        </ul>
                         @endfor
                    </ul>
                </div>
            </div>
        </div>
       </div>
    </div>
    
   </div>
</div>
@include('includes.modal')
@include('includes.footer')