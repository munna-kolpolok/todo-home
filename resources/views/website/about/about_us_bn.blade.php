@extends('website.layouts.app')


@section('main-content')
<!-- start page-title -->    
<section class="page-title">
    <div class="page-title-bg" style="background: url({{asset($setting->about_background_image)}}) center center/cover no-repeat local;"></div>
    <div class="container">
        <div class="title-box">
            <h1><span class="title-custom-color">@lang('messages.about')</span> @lang('messages.uss')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">@lang('messages.Home')</a></li>
                <li class="active">@lang('messages.About us')</li>
            </ol>
            {{--<a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">Donate</a>--}}
        </div>
    </div> <!-- end container -->
</section>
<!-- end page-title -->


<!-- start about-details -->
<section class="about-us-st section-padding">
    <div class="container">
        <!-- <h2><span>About</span> us</h2> -->
        <div class="row">
            <div class="col col-md-6">
                <div class="left-col">
                    <div class="company">
                        <h3>{{ $setting->bn_about_title or null}}</h3>
                        <span>{{ $setting->bn_about_sub_title or null}}</span>
                    </div>
                    <p class="text-justify">{{ $setting->bn_about_short_brief or null}}</p>
                </div> <!-- end left-col -->
            </div> <!-- end col -->

            <div class="col col-md-6 wow fadeInRightSlow">
                <div class="right-col">
                    <div class="video">
                        <img src="{{asset($setting->about_video_poster_image)}}" alt="" class="img img-responsive">
                        <a href="{{ $setting->about_video or null}}"  class="video-btn" data-type="iframe"><i class="fa fa-play"></i></a>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->
        <div style="margin-top: 25px" class="row">
            <div class="col-md-12">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default current">
                        <div class="panel-heading" id="headingOne">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true">@lang('messages.Vision & Mission') <i class="fa fa-angle-down"></i></a>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="img-holder">
                                    <img src="{{asset($setting->about_vision_image)}}" alt>
                                </div>
                                <div class="details">
                                    <p class="text-justify"><strong>@lang('messages.Vision'):</strong> {{ $setting->bn_vission or null}}
                                    </p>
                                    <p class="text-justify"><strong>@lang('messages.Mission'):</strong> {{ $setting->bn_mission or null}}
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" id="headingTwo">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">@lang('messages.Where we work') <i class="fa fa-angle-down"></i></a>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="img-holder">
                                    <img src="{{asset($setting->about_work_image)}}" alt>
                                </div>
                                <div class="details">
                                    <p class="text-justify">{{ $setting->bn_where_we_work or null}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" id="headingThree">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">@lang('messages.Our story') <i class="fa fa-angle-down"></i></a>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="img-holder">
                                    <img src="{{asset($setting->about_story_image)}}" alt>
                                </div>
                                <div class="details">
                                    <p class="text-justify">{{ $setting->bn_our_story or null}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end container -->
</section>
<!-- end about-details -->



<!-- start cta -->
<section class="cta">
    <div class="container">
        <div class="row">
            <div class="col col-md-5 col-sm-5">
                <img src="{{asset($setting->signup_donor_image)}}" alt class="img img-responsive">
            </div>

            <div class="col col-md-6 col-md-offset-1 col-sm-7">
                <div class="cta-details wow fadeInRightSlow">
                    <h2>@lang('messages.Join us')</h2>
                    <p>{{ $setting->bn_sign_up_donor_message or null}}</p>
                    <a href="{{ url('signup') }}" class="btn theme-btn">@lang('messages.Sing up')</a>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end cta -->

{{-- 
<!-- start cta-2 --> 
<section class="cta-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-5 col-sm-4 join-us">
                <span>Join us</span>
            </div>

            <div class="col col-md-7 col-sm-8 sing-up  wow fadeInRightSlow">
                <h3><span><img src="{{asset('site-assets/images/sing-up-icon.png')}}" alt></span> Sign up as Donor</h3>
                <span>Serve the humanity</span>
                <p>{{ $setting->sign_up_donor_message or null}}</p>
                <a href="{{ url('signin') }}" class="btn theme-btn">Sing up</a>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end cta-2 -->
--}}


<!-- start cta-4 --> 
<section class="cta-4 section-padding">
    <h2 class="hidden">CTA 4</h2>
    <div class="container">
        <div class="row">
            <div class="col col-sm-4">
                <div class="wow fadeInLeftSlow">
                    <span class="icon"><i class="fi flaticon-money-1"></i></span>
                    <h3>{{ $setting->bn_cta_title_1 or null}}</h3>
                    <p>{{ $setting->bn_cta_message_1 or null}}</p>
                    <a href="#" class="read-more" data-toggle="modal" data-target="#donate-simple-modal">@lang('messages.Donate now')</a>
                    <!-- <a href="#" class="btn theme-btn">@lang('messages.Donate now')</a> -->
                </div>
            </div>
            <div class="col col-sm-4">
                <div class="wow fadeInLeftSlow" data-wow-delay="0.3s"> 
                    <span class="icon"><i class="fi flaticon-heart"></i></span>
                    <h3>{{ $setting->bn_cta_title_2 or null}}</h3>
                    <p>{{ $setting->bn_cta_message_2 or null}}</p>
                    <a href="{{  url('volunteer/registration') }}" class="read-more">@lang('messages.Registration')</a>
                    <!-- <a href="#" class="btn theme-btn">Sign Up</a> -->
                </div>
            </div>
            <div class="col col-sm-4">
                <div class="wow fadeInLeftSlow" data-wow-delay="0.6s">
                    <span class="icon"><i class="fi flaticon-business-1"></i></span>
                    <h3>{{ $setting->bn_cta_title_3 or null}}</h3>
                    <p>{{ $setting->bn_cta_message_3 or null}}</p>
                    <a href="{{ url('sponsor') }}" class="read-more">@lang('messages.Sponsor')</a>
                    <!-- <a href="#" class="btn theme-btn">Sponsor</a> -->
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end cta-4 -->


{{-- 
<!-- start volunteers -->
<section class="volunteers section-padding">
    <div class="container">
        <div class="row section-title">
            <div class="col col-xs-12">
                <span>Meet us</span>
                <h2>Our Volunteers</h2>
            </div>
        </div> <!-- end section-title -->

        <div class="row volunteers-grid">
            <div class="col col-md-3 col-xs-6">
                <div class="box">
                    <div class="img-holder">
                        <img src="{{asset('site-assets/images/volunteers/img-1.jpg')}}" alt class="img img-responsive">
                    </div>
                    <div class="hover-text">
                        <div>
                            <h4>Hasib sharif</h4>
                            <span>CEO, Hooli</span>
                            <ul class="social-links">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col col-md-3 col-xs-6">
                <div class="box">
                    <div class="img-holder">
                        <img src="{{asset('site-assets/images/volunteers/img-2.jpg')}}" alt class="img img-responsive">
                    </div>
                    <div class="hover-text">
                        <div>
                            <h4>Hasib sharif</h4>
                            <span>CEO, Hooli</span>
                            <ul class="social-links">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col col-md-3 col-xs-6">
                <div class="box">
                    <div class="img-holder">
                        <img src="{{asset('site-assets/images/volunteers/img-3.jpg')}}" alt class="img img-responsive">
                    </div>
                    <div class="hover-text">
                        <div>
                            <h4>Hasib sharif</h4>
                            <span>CEO, Hooli</span>
                            <ul class="social-links">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col col-md-3 col-xs-6">
                <div class="box">
                    <div class="img-holder">
                        <img src="{{asset('site-assets/images/volunteers/img-4.jpg')}}" alt class="img img-responsive">
                    </div>
                    <div class="hover-text">
                        <div>
                            <h4>Hasib sharif</h4>
                            <span>CEO, Hooli</span>
                            <ul class="social-links">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col col-md-3 col-xs-6">
                <div class="box">
                    <div class="img-holder">
                        <img src="{{asset('site-assets/images/volunteers/img-5.jpg')}}" alt class="img img-responsive">
                    </div>
                    <div class="hover-text">
                        <div>
                            <h4>Hasib sharif</h4>
                            <span>CEO, Hooli</span>
                            <ul class="social-links">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col col-md-3 col-xs-6">
                <div class="box">
                    <div class="img-holder">
                        <img src="{{asset('site-assets/images/volunteers/img-6.jpg')}}" alt class="img img-responsive">
                    </div>
                    <div class="hover-text">
                        <div>
                            <h4>Hasib sharif</h4>
                            <span>CEO, Hooli</span>
                            <ul class="social-links">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col col-md-3 col-xs-6">
                <div class="box">
                    <div class="img-holder">
                        <img src="{{asset('site-assets/images/volunteers/img-7.jpg')}}" alt class="img img-responsive">
                    </div>
                    <div class="hover-text">
                        <div>
                            <h4>Hasib sharif</h4>
                            <span>CEO, Hooli</span>
                            <ul class="social-links">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col col-md-3 col-xs-6">
                <div class="box">
                    <div class="img-holder">
                        <img src="{{asset('site-assets/images/volunteers/img-8.jpg')}}" alt class="img img-responsive">
                    </div>
                    <div class="hover-text">
                        <div>
                            <h4>Hasib sharif</h4>
                            <span>CEO, Hooli</span>
                            <ul class="social-links">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end volunteers -->


<!-- start newsletter -->    
<section class="newsletter">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-5 children-holder"></div>
            <div class="col col-md-7 subscribe">
                <h3>Subscribe us</h3>
                <p>For <span>news</span> updates and promotional <span>events</span></p>

                <form action="#">
                    <div>
                        <input class="form-control" type="email" required placeholder="email address">
                        <button type="submit" class="btn theme-btn">Subscribe</button>
                    </div>
                </form>
                <div class="pluses">
                    <i class="fa fa-plus"></i>
                    <i class="fa fa-plus"></i>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container-fluid -->
</section>
<!-- end newsletter -->
--}}

{{--<div class="sponsor">
	<div class="container-fluid">
	    <div class="row">
	        <div class="col col-md-5 left-col">
	            <h2>Proudly sponsored by:</h2>
	        </div>
	        <div class="col col-md-7 right-col">
	            <div class="sponsor-slider">
	                <div class="box">
	                    <img src="{{asset('site-assets/images/event-single/sponsores/img-1.png')}}" alt class="img img-responsive">
	                </div>
	                <div class="box">
	                    <img src="{{asset('site-assets/images/event-single/sponsores/img-2.png')}}" alt class="img img-responsive">
	                </div>
	                <div class="box">
	                    <img src="{{asset('site-assets/images/event-single/sponsores/img-3.png')}}" alt class="img img-responsive">
	                </div>
	                <div class="box">
	                    <img src="{{asset('site-assets/images/event-single/sponsores/img-1.png')}}" alt class="img img-responsive">
	                </div>
	                <div class="box">
	                    <img src="{{asset('site-assets/images/event-single/sponsores/img-2.png')}}" alt class="img img-responsive">
	                </div>
	                <div class="box">
	                    <img src="{{asset('site-assets/images/event-single/sponsores/img-3.png')}}" alt class="img img-responsive">
	                </div>
	            </div>      
	        </div>
	    </div>
	</div>
</div>--}}
@endsection

@push('style')
<link href="{{asset('site-assets/css/jquery.fancybox.css')}}" rel="stylesheet">
<!-- <link href="{{asset('site-assets/css/owl.theme.css')}}" rel="stylesheet">
<link href="{{asset('site-assets/css/owl.transitions.css')}}" rel="stylesheet"> -->
@endpush