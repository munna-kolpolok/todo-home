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
                            <li>{{$latestNews->news}}</li>
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
                            <h1>{{ $slider->up_title or null }}</h1>
                            <span>{{ $slider->down_title or null }}</span>

                            <p style="text-align: justify;">{{ $slider->message or null }}</p>
                            @if($slider->type==2)
                                <a href="{{url('sponsor')}}" class="btn theme-btn">@lang('messages.Sponsor')</a>
                            @elseif($slider->type==3)
                                <a href="{{ url('/signin') }}" class="btn theme-btn">@lang('messages.Sign in')</a>
                            @elseif($slider->type==4)
                                <a href="{{ url('/volunteer/registration') }}"
                                   class="btn theme-btn">@lang('messages.Registration')</a>
                            @else
                                <a href="#" class="btn theme-btn" data-toggle="modal"
                                   data-target="#donate-simple-modal">@lang('messages.Donate')</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </section>
    <!-- end of hero slider -->


    <!-- scholarship start -->
    <section class="urgent-donation-s2">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-md-7 donation-details-wrapper"
                     style="background: url({{asset($setting->scholarship_thumbnail_image)}}) center center/cover no-repeat local;">
                    <div class="donation-details">
                        <h2>{{ $setting->scholarship_title or null}}</h2>
                        <span>{{ $setting->scholarship_sub_title or null}}</span>

                        <p class="text-justify">{{ $setting->scholarship_message or null}}</p>
                        <a href="{{url('sponsor')}}" class="btn theme-btn-s2">@lang('messages.Sponsor')</a>
                        <!-- <a href="#" class="btn theme-btn-s2">Details</a> -->
                    </div>
                </div>

                <div class="col col-md-5 donation-meter-wrapper">
                    <!-- <input type="text" value="75" class="dial"> -->
                    <?php
                    $total_student = App\Models\Student::count();
                    $total_scholarship_given = App\Models\Student::where('is_scholarship', 1)
                        ->count();
                    if ($total_student > 0) {
                        $v_percent = $total_scholarship_given / $total_student;
                    } else {
                        $v_percent = 0;
                    }

                    $v_percentage = round($v_percent, 2);
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
            </div>
            <!-- end row -->
        </div>
        <!-- end container fluid -->
    </section>
    <!-- scholarship end  -->

    <!-- start help -->
    <section class="help section-padding">
        <div class="container">
            <div class="row section-title">
                <div class="col col-xs-12">
                    <span>@lang('messages.Join our mission')</span>
                    <h2>@lang('messages.How can you help')</h2>
                </div>
            </div> <!-- end section-title -->

            <div class="row">
                <div class="col col-md-6">
                    <div class="help-item wow slideInUpSlow">
                        <span class="icon"><i class="fi flaticon-money-1"></i></span>
                        <div class="details">
                            <a href="#" data-toggle="modal"
                               data-target="#donate-simple-modal"><h3>{{ $setting->cta_title_1 or null}}</h3></a>

                            <p>{{ $setting->cta_message_1 or null}}</p>
                        </div>
                    </div>
                    <div class="help-item wow slideInUpSlow" data-wow-delay="0.3s">
                        <span class="icon"><i class="fi flaticon-heart"></i></span>
                        <div class="details">
                            <a href="{{ url('volunteer/registration') }}"><h3>{{ $setting->cta_title_2 or null}}</h3>
                            </a>
                            <p>{{ $setting->cta_message_2 or null}}</p>
                        </div>
                    </div>
                    <div class="help-item wow slideInUpSlow" data-wow-delay="0.6s">
                        <span class="icon"><i class="fi flaticon-business-1"></i></span>
                        <div class="details">
                            <a href="{{ url('sponsor') }}"><h3>{{ $setting->cta_title_3 or null}}</h3>
                            </a>

                            <p>{{ $setting->cta_message_3 or null}}</p>
                        </div>
                    </div>
                </div>

                <div class="col col-md-5 col-md-offset-1">
                    <div class="box">
                        <div class="video">
                            <img src="{{asset($setting->help_us_image)}}" alt class="img img-responsive">
                            <a href="{{ $setting->help_us_video }}" class="video-btn" data-type="iframe"><i
                                        class="fa fa-play"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end help -->

    <!-- projects-start -->
    <section class="events-nearby section-padding" id="latest-project">
        <div class="container">
            <div class="row section-title-s2">
                <div class="col col-md-8 col-md-offset-2">
                    <h2><span>@lang('messages.Latest')</span> @lang('messages.Projects') </h2>
                </div>
            </div>
            <!-- end section-title -->

            <div class="row">
                <div class="col col-xs-12" id="home-project">
                    <div class="events-nearby-slider event-grid-wrapper">
                        @foreach($projects as $project)
                            <div class="event-grid">
                                <div class="event-box">
                                    <div class="img-holder">
                                        <a href="{{ url('projects/'.$project->id) }}">
                                            <img src="{{asset($project->project_image)}}" alt=""
                                                 class="img img-responsive">
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
                                        <h3 style="margin-top: 0; margin-bottom: 10px"><a
                                                    href="{{ url('projects/'.$project->id) }}">{{ $project->name or null }}</a>
                                        </h3>
                                        {{--<span class="location"><i class="fa fa-map-marker"></i> {{ $project->location or null }}</span>--}}
                                        <p id="text-with-link"
                                           style="text-align: justify;  text-justify: inter-word; padding: 0 10px">

                                            {{ str_limit($project->description, 100) }}
                                            <span><a style="color: #ed323799"
                                                     href="{{url('projects/'.$project->id)}}">@lang('messages.Read more')</a></span>

                                        </p>
                                        <a href="#" class="btn theme-btn donate-project" data-toggle="modal"
                                           data-target="#donate-project-modal">@lang('messages.Donate now')</a>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- end events-nearby-slider -->
                    <div class="view-all">
                        <a href="{{url('/projects')}}" class="btn theme-btn-s2">@lang('messages.View all Projects') <i
                                    class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- projects-end -->



    <!-- general donation start -->
    <section class="cta">
        <div class="container">
            <div class="row">
                <div class="col col-md-5 col-sm-5">
                    <img src="{{asset($setting->cover_project_image)}}" alt class="img img-responsive">
                </div>

                <div class="col col-md-6 col-md-offset-1 col-sm-7">
                    <div class="cta-details wow fadeInRightSlow">
                        <h2>{{ $setting->cover_project_name or null }}</h2>
                        <p>{{ $setting->cover_project_desc or null }}</p>
                        <a href="#" class="btn theme-btn" data-toggle="modal"
                           data-target="#donate-simple-modal">@lang('messages.Donate')</a>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- general donation end -->


    <!-- start popular-campaign -->
    <section class="popular-campaign section-padding" id="popular-campaign">
        <div class="container">
            <div class="row section-title-s2">
                <div class="col col-xs-12">
                    <h2><span>@lang('messages.Our')</span> @lang('messages.Campaigns')</h2>
                </div>
            </div> <!-- end section-title -->

            <div class="row content">
                @foreach($campaigns as $campaign)
                    <div class="col col-sm-4">
                        <div class="box">
                            <div class="img-holder-donation">
                                <div class="img-holder">
                                    <a href="{{url('/campaign/details/'.$campaign->id)}}">
                                        <img src="{{asset($campaign->cover_image)}}" alt class="img img-responsive">
                                    </a>
                                </div>
                                <div class="donation-box">
                                    <div>
                                        <p class="dollar">{{$campaign->images_count or null}}</p>
                                        <p>@lang('messages.Photos')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="details">
                                <h3>
                                    <a href="{{url('/campaign/details/'.$campaign->id)}}">{{$campaign->title or null}}</a>
                                </h3>
                                <p>
                                    <i class="fa fa-clock-o"> {{\App\Helpers\CommonHelper::humanRedableDate($campaign->date)}}</i>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="view-all">
                    <a href="{{url('/campaigns')}}" class="btn theme-btn-s2">@lang('messages.View all campaigns')<i
                                class="fa fa-long-arrow-right"></i></a>
                </div>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end popular-campaign -->


    <!-- Volunteers Registration start -->
    <section class="cta-2" id="jon-us-cta">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-md-5 col-sm-4 join-us" id="join-us"
                     style="background: url({{asset($setting->home_volunteer_image)}}) center center/cover no-repeat local;">
                    <span>@lang('messages.Join us')</span>
                    <div class="dark-overlay"></div>
                </div>

                <div class="col col-md-7 col-sm-8 sing-up  wow fadeInRightSlow">
                    <h3>
                        @lang('messages.Registration for volunteer program')
                    </h3>
                    <span>@lang('messages.Serve the humanity')</span>
                    <p>{{ $setting->home_volunteer_desc or null}}</p>
                    <a href="{{ url('volunteer/registration') }}"
                       class="btn theme-btn">@lang('messages.Registration')</a>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- Volunteers Registration start -->


    <!-- Our mission Start -->
    <section class="cta-5 section-padding" style="background: white">
        <h2 class="hidden">CTA 5</h2>
        <div class="container">
            <div class="row section-title-s2">
                <div class="col col-md-8 col-md-offset-2">
                    <h2 style="margin-bottom: 12px"><span>@lang('messages.Our')</span> @lang('messages.Mission') </h2>
                    <p>{{ $setting->home_mission_desc or null }}</p>
                </div>
            </div> <!-- end section-title -->

            <div class="row content">
                <div class="col col-md-4">
                    <div class="wow fadeInLeftSlow" style="background:#ed3237">
                        <!-- <span class="icon"><i class="fa fa-apple fa-5x"></i></span> -->
                        <span class="icon"><i class="fa fa-cutlery fa-5x"></i></span>
                        <h3>@lang('messages.Food')</h3>
                        <p>{{ $setting->home_mission_food or null }}</p>
                    </div>
                </div>
                <div class="col col-md-4">
                    <div class="wow fadeInLeftSlow" style="background:#ed3237" data-wow-delay="0.5s">
                        <span class="icon"><i class="fa fa-graduation-cap fa-5x"></i></span>
                        <h3>@lang('messages.Education')</h3>
                        <p>{{ $setting->home_mission_education or null }}</p>
                    </div>
                </div>
                <div class="col col-md-4">
                    <div class="wow fadeInLeftSlow" style="background:#ed3237" data-wow-delay="1s">
                        <span class="icon"><i class="fa fa-medkit fa-5x"></i></span>
                        <h3>@lang('messages.Treatment')</h3>
                        <p>{{ $setting->home_mission_treatment or null }}</p>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- Our mission end -->


    <!--subscriber start -->
    <section class="newsletter">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-md-5 children-holder"
                     style="background: url({{asset($setting->subscribe_image)}}) center center/cover no-repeat local;"></div>
                <div class="col col-md-7 subscribe" id="subscribe">
                    <div class="subscribe-wrapper">
                        <h3>@lang('messages.Subscribe us')</h3>
                        <p><span>@lang('messages.For News, updates and promotional events')</span></p>

                        <form method="POST" action="" id="subscriber_form">
                            <div>
                                <input class="form-control" type="email" name="email" required
                                       placeholder="@lang('messages.email address')">
                                <button type="submit" class="btn theme-btn">@lang('messages.Subscribe')</button>
                                <div class="alert alert-danger" id="form-errors" style="margin-top:6px;display: none">
                                    <ul>
                                    </ul>
                                </div>
                                <div class="alert alert-success" id="form-success" style="margin-top:6px;display: none">
                                </div>

                            </div>
                        </form>
                        <div class="pluses">
                            <i class="fa fa-plus"></i>
                            <i class="fa fa-plus"></i>
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container-fluid -->
    </section>
    <!--subscriber end -->

@endsection

@push('style')

<link href="{{asset('site-assets/css/owl.carousel.css')}}" rel="stylesheet">
<link href="{{asset('site-assets/css/owl.theme.css')}}" rel="stylesheet">
<link href="{{asset('site-assets/css/jquery.fancybox.css')}}" rel="stylesheet">
<link href="{{asset('site-assets/css/owl.theme.css')}}" rel="stylesheet">
<link href="{{asset('site-assets/css/owl.transitions.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('jquery-confirm-v3.2.0/css/jquery-confirm.min.css') }}">
@endpush

@push('scripts')
<script src="{{asset('site-assets/js/jquery.marquee.min.js')}}"></script>
<script src="{{ asset('jquery-confirm-v3.2.0/js/jquery-confirm.min.js') }}" type="text/javascript"></script>
<script>
    @if(session()->has('subscribed'))
        $(window).on('load', function () {
            $.alert({
                title: '<?php echo Lang::get('messages.Thank You') ?>',
                content: '<?php echo Lang::get('messages.Your email is verified and your subscription is completed') ?>',
            });
        });
    @endif

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

    $("#subscriber_form").validate({
        submitHandler: function (form) {
            var form_btn = $(form).find('button[type="submit"]');

            $('#form-success').hide();
            $("#form-errors ul").empty();
            $('#form-errors').hide();


            var form_btn_old_msg = form_btn.html();
            form_btn.prop('disabled', true);
            form_btn.html("<?php echo Lang::get('messages.Processing');?> <i class='fa fa-spinner fa-spin'></i>");

            $.ajax({
                type: "POST",
                url: "{{ url('subscriber_store') }}",
                data: $(form).serialize(),
                success: function (data) {
                    if (data.status == '1') {
                        $(form).find('.form-control').val('');
                        $('#form-success').html(data.message).fadeIn('slow');
                        if (data.url) {
                            $.confirm({
                                title: '<?php echo Lang::get('messages.Email Verifiction') ?>',
                                content: '<?php echo Lang::get('messages.subscriber_confirm_content') ?>',
                                buttons: {
                                    yes: function () {
                                        var url = data.url;
                                        window.open(url, '_blank');
                                    },
                                    cancel: function () {
                                    }
                                }
                            });
                        }


                    }
                    else {
                        $("#form-errors ul").append('<li>' + data.message + '</li>');
                    }
                    form_btn.prop('disabled', false).html(form_btn_old_msg);

                },
                error: function (data) {
                    var errors = data.responseJSON;
                    $.each(errors, function (key, value) {
                        $("#form-errors ul").append('<li>' + value + '</li>');
                    });

                    form_btn.prop('disabled', false).html(form_btn_old_msg);

                    $('#form-errors').fadeIn('slow');
                }
            });

        }
    });

</script>

@endpush