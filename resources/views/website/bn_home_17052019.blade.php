@extends('website.layouts.app')


@section('main-content')
    
    @if(count($latestNewses)>0)
    <section id="news">
        <div class="ln_wrapper">
            <div class="ln_left">
                <p>@lang('messages.Latest News')</p>
            </div>
            <div class="ln_left_arrow"></div>
            <div class="ln_right marquee" data-duration='15000'>
                <ul>
                    @foreach($latestNewses as $latestNews)
                        <li>{{$latestNews->bn_news}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    @endif
    <!-- start of hero -->
    <section class="hero hero-style-two hero-slider-wrapper">
        <div class="hero-slider">
            @foreach($sliders as $slider)
            <div class="slide">
                <img src="{{asset($slider->image)}}" alt>
                <div class="container">
                    <div class="col col-md-7 col-sm-8 slider-title">
                        <h1>{{ $slider->bn_up_title or null }}</h1>
                        <span>{{ $slider->bn_down_title or null }}</span>
                        <p style="text-align: justify;">{{ $slider->bn_message or null }}</p>
                        @if($slider->type==2)
                        <a href="{{url('sponsor')}}" class="btn theme-btn">@lang('messages.Sponsor')</a>
                        @elseif($slider->type==3)
                        <a href="{{ url('/signin') }}" class="btn theme-btn">@lang('messages.Sign in')</a>
                        @elseif($slider->type==4)
                        <a href="{{ url('/volunteer/registration') }}" class="btn theme-btn">@lang('messages.Registration')</a>
                        @else
                        <a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">@lang('messages.Donate')</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </section>
    <!-- end of hero slider -->


    <!-- start urgent-donation -->
    <section class="urgent-donation-s2">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-md-7 donation-details-wrapper"  style="background: url({{asset($setting->scholarship_thumbnail_image)}}) center center/cover no-repeat local;">
                    <div class="donation-details">
                        <h2>{{ $setting->bn_scholarship_title or null}}</h2>
                        <span>{{ $setting->bn_scholarship_sub_title or null}}</span>
                        <p class="text-justify">{{ $setting->bn_scholarship_message or null}}</p>
                        <a href="{{url('sponsor')}}" class="btn theme-btn-s2">@lang('messages.Sponsor')</a>
                        <!-- <a href="#" class="btn theme-btn-s2">Details</a> -->
                    </div>
                </div>

                <div class="col col-md-5 donation-meter-wrapper">
                    <!-- <input type="text" value="75" class="dial"> -->
                    <?php
                    $total_student=App\Models\Student::count();
                    $total_scholarship_given=App\Models\Student::where('is_scholarship',1)
                    ->count();
                    if($total_student>0)
                    {
                        $v_percent=$total_scholarship_given/$total_student;
                    }
                    else
                    {
                        $v_percent=0;
                    }
                    
                    $v_percentage=round($v_percent, 2);
                    ?>
                    <div class="donation-meter-details">
                        <div class="raised">
                            <span>@lang('messages.Raised')</span>
                            <h3>{{ $total_scholarship_given }}</h3>
                        </div>
                        <div class="meter2" data-value="{{ $v_percentage }}">
                            <span></span>
                            <p>@lang('messages.Complete')</p>
                        </div>
                        <div class="goal">
                            <span>@lang('messages.Goal')</span>
                            <h3>{{ $total_student }}</h3>
                        </div>
                    </div>
                    <div class="donation-form">
                        <form class="form">
                            <div>
                                <!-- <input type="text" class="form-control" placeholder=" - ENTER AMOUNT - "> -->
                                <a href="{{ url('signup') }}" class="btn theme-btn-s2">@lang('messages.Sign Up')</a>
                            </div>
                            <?php /*
                            $not_scholarship_given = App\Models\Student::where(['is_scholarship' => 2])
                                ->orderby('id', 'asc')
                                ->first();
                                */
                            ?>
                            <div>
                                <!-- <button type="submit" class="btn theme-btn-s2">Donate now</button> -->
                                <a href="{{ url('sponsor') }}" class="btn theme-btn-s2">@lang('messages.Sponsor')</a>

                                <!-- <a href="#" class="btn theme-btn-s2" data-toggle="modal" data-target="#donate-simple-modal">Donate</a> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container fluid -->
    </section>
    <!-- end urgent-donation -->

    {{-- 
    <!-- start cta-4 -->
    <section class="cta-4 section-padding">
        <h2 class="hidden">CTA 4</h2>
        <div class="container">
            <div class="row">
                <div class="col col-sm-4">
                    <div class="wow fadeInLeftSlow">
                        <span class="icon"><i class="fi flaticon-money-1"></i></span>
                        <h3>Donate money</h3>
                        <p>Perspiciatis unde omnis iste natus error sit vo luptatem</p>
                        <a href="#" class="read-more">Read more</a>
                    </div>
                </div>
                <div class="col col-sm-4">
                    <div class="wow fadeInLeftSlow" data-wow-delay="0.5s">
                        <span class="icon"><i class="fi flaticon-heart"></i></span>
                        <h3>Become volunteer</h3>
                        <p>Perspiciatis unde omnis iste natus error sit vo luptatem</p>
                        <a href="#" class="read-more">Read more</a>
                    </div>
                </div>
                <div class="col col-sm-4">
                    <div class="wow fadeInLeftSlow" data-wow-delay="1s">
                        <span class="icon"><i class="fi flaticon-business-1"></i></span>
                        <h3>Sponsorship</h3>
                        <p>Perspiciatis unde omnis iste natus error sit vo luptatem</p>
                        <a href="#" class="read-more">Read more</a>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end cta-4 -->


    <!-- start popular-campaign -->
    <section class="popular-campaign section-padding">
        <div class="container">
            <div class="row section-title-s2">
                <div class="col col-xs-12">
                    <h2><span>Featured</span> causes</h2>
                </div>
            </div> <!-- end section-title -->

            <div class="row content">
                <div class="col col-sm-4">
                    <div class="box">
                        <div class="img-holder-donation">
                            <div class="img-holder">
                                <img src="{{asset('site-assets/images/popular-campaign/img-1.jpg')}}" alt class="img img-responsive">
                            </div>
                            <div class="donation-box">
                                <div>
                                    <p class="dollar"><span>$</span> 2,018</p>
                                    <p> pledged</p>
                                </div>
                                <div class="meter" data-value="0.9">
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="details">
                            <h3><a href="#">Food for syrian children</a></h3>
                            <span>by Hasib Sharif</span>
                            <p><i class="fa fa-clock-o"></i> 2 days left</p>
                        </div>
                    </div>
                </div>

                <div class="col col-sm-4">
                    <div class="box">
                        <div class="img-holder-donation">
                            <div class="img-holder">
                                <img src="{{asset('site-assets/images/popular-campaign/img-2.jpg')}}" alt class="img img-responsive">
                            </div>
                            <div class="donation-box">
                                <div>
                                    <p class="dollar"><span>$</span> 2,018</p>
                                    <p> pledged</p>
                                </div>
                                <div class="meter" data-value="0.5">
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="details">
                            <h3><a href="#">Uganda education program</a></h3>
                            <span>by Hasib Sharif</span>
                            <p><i class="fa fa-clock-o"></i> 4 days left</p>
                        </div>
                    </div>
                </div>

                <div class="col col-sm-4">
                    <div class="box">
                        <div class="img-holder-donation">
                            <div class="img-holder">
                                <img src="{{asset('site-assets/images/popular-campaign/img-3.jpg')}}" alt class="img img-responsive">
                            </div>
                            <div class="donation-box">
                                <div>
                                    <p class="dollar"><span>$</span> 2,018</p>
                                    <p> pledged</p>
                                </div>
                                <div class="meter" data-value="0.14">
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="details">
                            <h3><a href="#">Capetown orphanage opening</a></h3>
                            <span>by Hasib Sharif</span>
                            <p><i class="fa fa-clock-o"></i> 5 days left</p>
                        </div>
                    </div>
                </div>

                <div class="view-all">
                    <a href="#" class="btn theme-btn-s2">View all campaigns <i class="fa fa-long-arrow-right"></i></a>
                </div>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end popular-campaign -->


    <!-- start cta -->
    <section class="cta">
        <div class="container">
            <div class="row">
                <div class="col col-md-5 col-sm-5">
                    <img src="{{asset('site-assets/images/cta-t-shirt.png')}}" alt class="img img-responsive">
                </div>

                <div class="col col-md-6 col-md-offset-1 col-sm-7">
                    <div class="cta-details wow fadeInRightSlow">
                        <h2>Buy and Sell campaign items.</h2>
                        <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam volupta tem quia voluptas sit aspernatur aut odit.</p>
                        <a href="#" class="btn theme-btn">Donate shop</a>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end cta -->
    --}}


    

   

    <!-- start events-nearby -->
    <section class="events-nearby section-padding" id="latest-project">
        <div class="container">
            <div class="row section-title-s2">
                <div class="col col-md-8 col-md-offset-2">
                    <h2><span>@lang('messages.Latest')</span> @lang('messages.Projects') </h2>
{{--
                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
--}}
                </div>
            </div> <!-- end section-title -->

            <div class="row">
                <div class="col col-xs-12">
                    <div class="events-nearby-slider event-grid-wrapper">
                        @foreach($projects as $project)
                        <div class="event-grid">
                            <div class="event-box">
                                <div class="img-holder">
                                    <a href="{{ url('projects/'.$project->id) }}">
                                    <img src="{{asset($project->project_image)}}" alt="" class="img img-responsive">
                                    </a>
                                </div>
                                <div class="event-details">
                                    <input type="hidden" id="project-id-{{$project->id}}"
                                               value="{{$project->id}}">
                                    <input type="hidden" id="modal-img-{{$project->id}}"
                                                       value="{{$project->project_image}}">
                                    <input type="hidden" id="project-name-{{$project->id}}"
                                                       value="{{$project->name}}">

                                    <!-- <span class="date">27,oct</span> -->
                                    <h3 style="margin-top: 0; margin-bottom: 10px"><a href="{{ url('projects/'.$project->id) }}">{{ $project->bn_name or null }}</a></h3>
                                    {{--<span class="location"><i class="fa fa-map-marker"></i> {{ $project->location or null }}</span>--}}
                                    <p id="text-with-link"
                                       style="text-align: justify;  text-justify: inter-word; padding: 0 10px">

                                        {{ str_limit($project->bn_description, 100) }}
                                        <span><a style="color: #ed323799"
                                                 href="{{url('projects/'.$project->id)}}">@lang('messages.Read more')</a></span>

                                    </p>
                                    <a href="#" class="btn theme-btn donate-project" data-toggle="modal"
                                       data-target="#donate-project-modal">@lang('messages.Donate now')</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                    </div> <!-- end events-nearby-slider -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end events-nearby -->


    <!-- start cta-2 -->
    <section class="cta-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-md-5 col-sm-4 join-us" style="background: url({{asset($setting->cover_project_image)}}) center center/cover no-repeat local;"></div>

                <div class="col col-md-7 col-sm-8 sing-up  wow fadeInRightSlow">
                    <h3>{{--<i class="fa fa-money fa-lg" aria-hidden="true" style="color: #ED3237;"></i>--}} {{ $setting->bn_cover_project_name or null }}</h3>
                    <span style="color: #A9B0BE;">{{ $setting->bn_cover_project_title or null }}</span>
                    <p style="color: #828791;">{{ $setting->bn_cover_project_desc or null }}</p>
                    <a href="#" class="btn theme-btn"  data-toggle="modal" data-target="#donate-simple-modal">@lang('messages.Donate')</a>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end cta-2 -->

    {{-- 
    <!-- start events-nearby -->
    <section class="events-nearby section-padding">
        <div class="container">
            <div class="row section-title-s2">
                <div class="col col-md-8 col-md-offset-2">
                    <h2><span>Events</span> nearby</h2>
                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                </div>
            </div> <!-- end section-title -->

            <div class="row">
                <div class="col col-xs-12">
                    <div class="events-nearby-slider event-grid-wrapper">
                        <div class="event-grid">
                            <div class="event-box">
                                <div class="img-holder">
                                    <img src="{{asset('site-assets/images/event/img-1.jpg')}}" alt="" class="img img-responsive">
                                </div>
                                <div class="event-details">
                                    <span class="date">27,oct</span>
                                    <h3><a href="#">Water pump setting</a></h3>
                                    <span class="location"><i class="fa fa-map-marker"></i> Ambriz, africa</span>
                                    <a href="#" class="btn">Join event</a>
                                </div>
                            </div>
                        </div>
                        <div class="event-grid">
                            <div class="event-box">
                                <div class="img-holder">
                                    <img src="{{asset('site-assets/images/event/img-2.jpg')}}" alt="" class="img img-responsive">
                                </div>
                                <div class="event-details">
                                    <span class="date">27,oct</span>
                                    <h3><a href="#">Water pump setting</a></h3>
                                    <span class="location"><i class="fa fa-map-marker"></i> Ambriz, africa</span>
                                    <a href="#" class="btn">Join event</a>
                                </div>
                            </div>
                        </div>
                        <div class="event-grid">
                            <div class="event-box">
                                <div class="img-holder">
                                    <img src="{{asset('site-assets/images/event/img-3.jpg')}}" alt="" class="img img-responsive">
                                </div>
                                <div class="event-details">
                                    <span class="date">27,oct</span>
                                    <h3><a href="#">Water pump setting</a></h3>
                                    <span class="location"><i class="fa fa-map-marker"></i> Ambriz, africa</span>
                                    <a href="#" class="btn">Join event</a>
                                </div>
                            </div>
                        </div>
                        <div class="event-grid">
                            <div class="event-box">
                                <div class="img-holder">
                                    <img src="{{asset('site-assets/images/event/img-4.jpg')}}" alt="" class="img img-responsive">
                                </div>
                                <div class="event-details">
                                    <span class="date">27,oct</span>
                                    <h3><a href="#">Water pump setting</a></h3>
                                    <span class="location"><i class="fa fa-map-marker"></i> Ambriz, africa</span>
                                    <a href="#" class="btn">Join event</a>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end events-nearby-slider -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end events-nearby -->
    --}}


    {{-- 
    <!-- start cta-3 -->
    <section class="cta-3">
        <div class="container">
            <div class="row">
                <div class="col col-md-7 col-md-offset-5 details-text">
                    <div class="wow fadeInRightSlow">
                        <h2>Some people really need your help</h2>
                        <p>Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime pla ceat facere possimus.</p>
                        <a href="#" class="btn theme-btn">Sing up</a>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end cta-3 -->
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
                    <a href="{{ url('volunteer/registration') }}" class="read-more">@lang('messages.Registration')</a>
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
    <!-- start latest-news -->
    <section class="latest-news section-padding">
        <div class="container">
            <div class="row section-title">
                <div class="col col-xs-12">
                    <span>What's up</span>
                    <h2>Latest news</h2>
                </div>
            </div> <!-- end section-title -->

            <div class="latest-news-slider blog-grid">
                <div class="post">
                    <div class="entry-media">
                        <img src="{{asset('site-assets/images/latest-news/img-1.jpg')}}" alt class="img img-responsive">
                    </div>
                    <div class="entry-body">
                        <div class="entry-title">
                            <h3><a href="#">Founder of migrant children's charity arrested. </a></h3>
                        </div>
                        <div class="entry-date-author">
                            <ul>
                                <li><a href="#">Noverber 26</a></li>
                                <li><a href="#">by <span>Hasib sharif</span></a></li>
                            </ul>
                        </div>
                        <div class="read-more">
                            <a href="#">Continue reading..</a>
                        </div>
                    </div>
                </div>

                <div class="post">
                    <div class="entry-media">
                        <img src="{{asset('site-assets/images/latest-news/img-2.jpg')}}" alt class="img img-responsive">
                    </div>
                    <div class="entry-body">
                        <div class="entry-title">
                            <h3><a href="#">Founder of migrant children's charity arrested. </a></h3>
                        </div>
                        <div class="entry-date-author">
                            <ul>
                                <li><a href="#">Noverber 26</a></li>
                                <li><a href="#">by <span>Hasib sharif</span></a></li>
                            </ul>
                        </div>
                        <div class="read-more">
                            <a href="#">Continue reading..</a>
                        </div>
                    </div>
                </div>

                <div class="post">
                    <div class="entry-media">
                        <img src="{{asset('site-assets/images/latest-news/img-3.jpg')}}" alt class="img img-responsive">
                    </div>
                    <div class="entry-body">
                        <div class="entry-title">
                            <h3><a href="#">Founder of migrant children's charity arrested. </a></h3>
                        </div>
                        <div class="entry-date-author">
                            <ul>
                                <li><a href="#">Noverber 26</a></li>
                                <li><a href="#">by <span>Hasib sharif</span></a></li>
                            </ul>
                        </div>
                        <div class="read-more">
                            <a href="#">Continue reading..</a>
                        </div>
                    </div>
                </div>

                <div class="post">
                    <div class="entry-media">
                        <img src="{{asset('site-assets/images/latest-news/img-4.jpg')}}" alt class="img img-responsive">
                    </div>
                    <div class="entry-body">
                        <div class="entry-title">
                            <h3><a href="#">Founder of migrant children's charity arrested. </a></h3>
                        </div>
                        <div class="entry-date-author">
                            <ul>
                                <li><a href="#">Noverber 26</a></li>
                                <li><a href="#">by <span>Hasib sharif</span></a></li>
                            </ul>
                        </div>
                        <div class="read-more">
                            <a href="#">Continue reading..</a>
                        </div>
                    </div>
                </div>

                <div class="post">
                    <div class="entry-media">
                        <img src="{{asset('site-assets/images/latest-news/img-1.jpg')}}" alt class="img img-responsive">
                    </div>
                    <div class="entry-body">
                        <div class="entry-title">
                            <h3><a href="#">Founder of migrant children's charity arrested. </a></h3>
                        </div>
                        <div class="entry-date-author">
                            <ul>
                                <li><a href="#">Noverber 26</a></li>
                                <li><a href="#">by <span>Hasib sharif</span></a></li>
                            </ul>
                        </div>
                        <div class="read-more">
                            <a href="#">Continue reading..</a>
                        </div>
                    </div>
                </div>

                <div class="post">
                    <div class="entry-media">
                        <img src="{{asset('site-assets/images/latest-news/img-2.jpg')}}" alt class="img img-responsive">
                    </div>
                    <div class="entry-body">
                        <div class="entry-title">
                            <h3><a href="#">Founder of migrant children's charity arrested. </a></h3>
                        </div>
                        <div class="entry-date-author">
                            <ul>
                                <li><a href="#">Noverber 26</a></li>
                                <li><a href="#">by <span>Hasib sharif</span></a></li>
                            </ul>
                        </div>
                        <div class="read-more">
                            <a href="#">Continue reading..</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end latest-news -->


    
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
@endsection

@push('style')

<link href="{{asset('site-assets/css/owl.carousel.css')}}" rel="stylesheet">
<link href="{{asset('site-assets/css/owl.theme.css')}}" rel="stylesheet">
<!-- <link href="{{asset('site-assets/css/owl.transitions.css')}}" rel="stylesheet"> -->
@endpush

@push('scripts')
<script src="{{asset('site-assets/js/jquery.marquee.min.js')}}"></script>
<script>
    $('.marquee').marquee({
        pauseOnHover: true
    });

    $(document).scroll(function () {
        var y = $(this).scrollTop();
        if (y <= 20) {
            $('#news').fadeIn();
        } else {
            $('#news').fadeOut();
        }
    });
</script>

@endpush