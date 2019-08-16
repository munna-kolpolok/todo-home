@extends('website.layouts.app')

@section('main-content')
<!-- start page-title -->    
<section class="page-title">
    <div class="page-title-bg" style="background: url({{asset($setting->faq_background_image)}}) center center/cover no-repeat local;"></div>
    <div class="container">
        <div class="title-box">
			<h1><span class="title-custom-color">Frequently </span> Asked Questions</h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">FAQ</li>
            </ol>
            <a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">Donate</a>
        </div>
    </div> <!-- end container -->
</section>
<!-- end page-title -->


<!-- start about-details -->
<section class="about-us-st section-padding">
    <div class="container">
        <!-- <h2><span>About</span> us</h2> -->
        <div class="row">
            <div class="col col-md-12">
                <div class="left-col">

                    <div class="panel-group" id="accordion">

                    	@foreach($faqs as $key=>$faq)
	                    	@if($key==0)
	                        <div class="panel panel-default current">
	                            <div class="panel-heading" id="headingOne">
	                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true">{{ $faq->question or null}} <i class="fa fa-angle-down"></i></a>
	                            </div>
	                            <div id="collapseOne" class="panel-collapse collapse in">
	                                <div class="panel-body">
	                                    <div class="img-holder">
	                                        Answer :
	                                    </div>
	                                    <div class="details">
	                                        <p>{{ $faq->answer or null}}</p>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                        @else
	                        	<div class="panel panel-default">
		                            <div class="panel-heading" id="heading-{{$key}}">
		                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$key}}">{{ $faq->question or null}} <i class="fa fa-angle-down"></i></a>
		                            </div>
		                            <div id="collapse-{{$key}}" class="panel-collapse collapse">
		                                <div class="panel-body">
		                                    <div class="img-holder">
		                                        Answer :
		                                    </div>
		                                    <div class="details">
		                                        <p>{{ $faq->answer or null}}</p>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
	                        @endif
                        @endforeach

                        

                    </div>
                </div> <!-- end left-col -->
            </div> <!-- end col -->

            <!-- <div class="col col-md-6 wow fadeInRightSlow">
                <div class="right-col">
                    <div class="video">
                        <img src="{{asset('site-assets/images/about/video-poster.jpg')}}" alt="" class="img img-responsive">
                        <a href="{{ $setting->about_video or null}}"  class="video-btn" data-type="iframe"><i class="fa fa-play"></i></a>
                    </div>
                </div>
            </div> -->
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end about-details -->
@endsection