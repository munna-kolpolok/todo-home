@extends('website.layouts.app')


@section('main-content')
    <!-- start page-wrapper -->
    <div class="page-wrapper volunteer-single">
        <!-- start volunteer-single-section -->
        <section class="volunteer-single-section about-us-st" id="volunteer-customize-padding">
            @if(request()->cookie('locale')=='bn')
            <div class="container">
                <div class="row">
                    <div class="col col-md-4 event-content event-grid-wrapper">
                        <div class="event-grid">
                            <div class="event-box">
                                <div class="img-holder sponsor-image">
                                    <img src="{{asset($student->student_image)}}" alt class="img img-responsive">
                                    <a href="{{$student->student_video}}" target="_blank"><i
                                                class="fa fa-play"></i></a>
                                </div>
                                <div class="event-details">
                                    <?php
                                    $now = Carbon\Carbon::now();
                                    $age_days = $now->diffInDays($student->dob);
                                    $age = $age_days / 365;
                                    ?>
                                    <span class="date">{{\App\Helpers\CommonHelper::en2bnNumber(floor($age))}} @lang('messages.years')</span>
                                    <h3>{{$student->bn_name}}</h3>
                                    <p class="price-bd">৳{{\App\Helpers\CommonHelper::en2bnNumber(intval($student->scholarship_amount))}}</p>
                                    {{--<p class="donate-status">${{ceil($student->scholarship_amount * $settings->tk_to_usd)}}</p>--}}
                                    <p class="donate-status">@lang('messages.Yearly')</p>
                                    <span class="location"><i class="fa fa-heart" aria-hidden="true"></i> @lang('messages.Please sponsor me')</span>
                                    <!--student smile source image-->
                                    <input type="hidden" id="smile-img-{{$student->id}}"
                                           value="{{$student->student_smile_image}}">
                                    <input type="hidden" id="base_url" value="{{url('/')}}">
                                    <input type="hidden" id="student-id" value="{{$student->id}}">
                                    <a class="btn theme-btn donate" data-toggle="modal" data-target="#donate-modal">@lang('messages.Sponsor')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-8 wow fadeInRightSlow volunteer-content">

                            <div class="bio">
                                <div class="box-title">
                                    <h3><i class="fa fa-pencil"></i> @lang('messages.Biography')</h3>
                                </div>
                                <p style="text-align: justify;">{{$student->bn_biography or null}}</p>
                            </div>

                            <div class="similar-profile">
                                <div class="box-title">
                                    <h3><i class="fa fa-pencil"></i> @lang('messages.Similar profiles')</h3>
                                </div>
                                <ul>
                                    @foreach($students as $student)
                                        <li>
                                            <a href="{{url('sponsor/details/'.$student->id)}}">
                                                <img src="{{asset($student->student_image)}}"
                                                     alt="{{$student->name}}" width="70px" height="70px">
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                        </div>
                </div>
            </div> <!-- end container -->
            @else
            <div class="container">
                    <div class="row">
                        <div class="col col-md-4 event-content event-grid-wrapper">
                            <div class="event-grid">
                                <div class="event-box">
                                    <div class="img-holder sponsor-image">
                                        <img src="{{asset($student->student_image)}}" alt class="img img-responsive">
                                        <a href="{{$student->student_video}}" target="_blank"><i
                                                    class="fa fa-play"></i></a>
                                    </div>
                                    <div class="event-details">
                                        <?php
                                        $now = Carbon\Carbon::now();
                                        $age_days = $now->diffInDays($student->dob);
                                        $age = $age_days / 365;
                                        ?>
                                        <span class="date">{{ floor($age) }} @lang('messages.years')</span>
                                        <h3>{{$student->name}}</h3>
                                        <p class="price-bd">৳{{intval($student->scholarship_amount)}}</p>
                                        {{--<p class="donate-status">${{ceil($student->scholarship_amount * $settings->tk_to_usd)}}</p>--}}
                                        <p class="donate-status">@lang('messages.Yearly')</p>
                                        <span class="location"><i class="fa fa-heart" aria-hidden="true"></i> @lang('messages.Please sponsor me')</span>
                                        <!--student smile source image-->
                                        <input type="hidden" id="smile-img-{{$student->id}}"
                                               value="{{$student->student_smile_image}}">
                                        <input type="hidden" id="base_url" value="{{url('/')}}">
                                        <input type="hidden" id="student-id" value="{{$student->id}}">
                                        <a class="btn theme-btn donate" data-toggle="modal" data-target="#donate-modal">@lang('messages.Sponsor')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-8 wow fadeInRightSlow volunteer-content">

                            <div class="bio">
                                <div class="box-title">
                                    <h3><i class="fa fa-pencil"></i> @lang('messages.Biography')</h3>
                                </div>
                                <p style="text-align: justify;">{{$student->biography or null}}</p>
                            </div>

                            <div class="similar-profile">
                                <div class="box-title">
                                    <h3><i class="fa fa-pencil"></i> @lang('messages.Similar profiles')</h3>
                                </div>
                                <ul>
                                    @foreach($students as $student)
                                        <li>
                                            <a href="{{url('sponsor/details/'.$student->id)}}">
                                                <img src="{{asset($student->student_image)}}"
                                                     alt="{{$student->name}}" width="70px" height="70px">
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- 
                            <div class="right-col">
                                <div class="video">
                                    <img src="{{asset($student->student_image)}}" alt="" class="img img-responsive">
                                    <a href="{{$student->student_video}}?autoplay=1" class="video-btn" data-type="iframe"><i
                                                class="fa fa-play"></i></a>
                                </div>
                            </div>
                            --}}
                            
                        </div>
                    </div>

                    {{-- 
                    <div class="row volunteer-content">
                        <div class="col col-md-4">
                            <div class="info">
                                <div class="box-title">
                                    <h3><i class="fa fa-pencil"></i> @lang('messages.Informations')</h3>
                                </div>
                                <ul class="info-details">
                                    <li>
                                        <span>@lang('messages.Father')</span>
                                        @if($student->is_father==1)
                                            <span>{{$student->father_name or null}}</span>
                                        @else
                                            <span>@lang('messages.Died')</span>
                                        @endif
                                    </li>
                                    <li>
                                        <span>@lang('messages.Mother')</span>
                                        @if($student->is_mother==1)
                                            <span>{{$student->mother_name or null}}</span>
                                        @else
                                            <span>@lang('messages.Died')</span>
                                        @endif
                                    </li>
                                    <li>
                                        <span>@lang('messages.Religion')</span>
                                        <span>{{$student->religion->religion_name or null}}</span>
                                    </li>
                                    <li>
                                        <span>@lang('messages.Disability')</span>
                                        <span>{{ $student->disability->name or 'None'}}</span>
                                    </li>
                                    <li>
                                        <span>@lang('messages.Tribe')</span>
                                        <span>{{ $student->tribe_name or 'None'}}</span>
                                    </li>
                                </ul>

                                <!-- <div class="social">
                                    <span>social</span>
                                    <ul>
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                    </ul>
                                </div> -->
                            </div>
                        </div>

                        <div class="col col-md-8">
                            <div class="bio">
                                <div class="box-title">
                                    <h3><i class="fa fa-pencil"></i> @lang('messages.Biography')</h3>
                                </div>
                                <p style="text-align: justify;">{{$student->biography or null}}</p>
                            </div>
                            <div class="similar-profile">
                                <div class="box-title">
                                    <h3><i class="fa fa-pencil"></i> @lang('messages.Similar profiles')</h3>
                                </div>
                                <ul>
                                    @foreach($students as $student)
                                        <li>
                                            <a href="{{url('sponsor/details/'.$student->id)}}">
                                                <img src="{{asset($student->student_image)}}"
                                                     alt="{{$student->name}}" width="70px" height="70px">
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    --}}
                </div> <!-- end container -->
            @endif
        </section>
        <!-- end volunteer-single-section -->
    </div>
    <!-- end of page-wrapper -->

    <!--Donate Modal-->
    @include('website.scholarship.scholarship_donate_modal')
    <!--Donate Modal-->

@endsection

@push('style')
<link href="{{asset('site-assets/css/jquery.fancybox.css')}}" rel="stylesheet">
@endpush