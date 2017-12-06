@extends('layout.master')

@section('content')
    <div class="contents">
        <div class="custom-container">
            <div class="row">
                <!-- Bread Crumb Start -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Contact Us</li>
                    </ol>
                </div>
                <!-- Bread Crumb End -->
                <!-- Content Column Start -->
                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 equalcol conentsection">
                    <!-- Contents Section Started -->
                    <div class="sections">
                        <h2 class="heading">Contact Us</h2>
                        <div class="clearfix"></div>
                        <div class="contactus">
                            <!-- Map Section Started -->
                            <div class="mapsec">
                                <iframe src="https://maps.google.com/?ie=UTF8&amp;ll=51.496027,-0.125141&amp;spn=0.08026,0.209255&amp;t=m&amp;z=13&amp;output=embed"></iframe>
                                <div class="clearfix"></div>
                            </div>
                            <!-- Map Section End -->
                        </div>
                    </div>
                    <!-- Contents Section End -->
                    <div class="clearfix"></div>
                    <!-- Contents Section Started -->
                    <div class="sections">
                        <div class="clearfix"></div>
                        <div id="leavereply">
                            <form action="http://www.softcircles.net/demos/html/videomagazine/send.php">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Your Name</label>
                                            <input type="text" class="form-control" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input type="email" class="form-control" placeholder="Email Address">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Subject</label>
                                            <input type="text" class="form-control" placeholder="Subject">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Your Comments</label>
                                            <textarea class="form-control" rows="3" placeholder="Your Comments"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button type="submit" class="btn btn-primary backcolor">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Contents Section End -->
                    <div class="clearfix"></div>
                </div>
                <!-- Content Column End -->
                <!-- Gray Sidebar Start -->
                @include('utils.gray-sidebar')
                <!-- Gray Sidebar End -->
            </div>
        </div>
    </div>
@endsection