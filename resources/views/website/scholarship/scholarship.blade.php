@extends('website.layouts.app')


@section('main-content')

<!-- start page-title -->    
{{--<section class="page-title">
    <div class="page-title-bg" style="background: url({{asset($settings->scholarship_background_image)}}) center center/cover no-repeat local;"></div>
    <div class="container">
        <div class="title-box">
            <h1><span class="title-custom-color">Sponsor</span> Us</h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Scholarships</li>
            </ol>
            <a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">Donate</a>
        </div>
    </div> <!-- end container -->
</section>--}}
<!-- end page-title -->
    <!-- start shop-main-content -->
    <section class="shop-main-content section-padding">
        <div class="container">
            <div class="row">
                <div class="col col-md-12">
                    @if(request()->cookie('locale')=='bn')
                    <div class="shop-content">
                        @forelse($students as $key => $student)
                            <?php
                            $key = $key + 5;
                            $time = "0.{$key}s";
                            ?>
                            <div class="grid wow fadeInLeftSlow" data-wow-delay="{{$time}}">
                                <div class="box">
                                    <div class="img-holder">
                                        <a href="{{url('sponsor/details/'.$student->id)}}">
                                            <img src="{{asset($student->student_image)}}" alt
                                                 class="img img-responsive">
                                        </a>
                                    </div>
                                    <div class="details text-center">
                                        <h3>
                                            <a href="{{url('sponsor/details/'.$student->id)}}">{{$student->bn_name}}</a>
                                        </h3>
                                        <p class="price-bd">৳{{\App\Helpers\CommonHelper::en2bnNumber(intval($student->scholarship_amount))}}</p>
                                        <p class="donate-status">@lang('messages.Yearly')</p>
                                        <p id="text-with-link" style="text-align: justify;  text-justify: inter-word;">
                                            <a href="{{url('sponsor/details/'.$student->id)}}">
                                                {{ str_limit($student->bn_biography, 100) }}
                                                <span style="color: #ed323799">@lang('messages.Read more')</span>
                                            </a>
                                        </p>
                                        <!--student smile source image-->
                                        <input type="hidden" id="smile-img-{{$student->id}}"
                                               value="{{$student->student_smile_image}}">
                                        <input type="hidden" id="base_url" value="{{url('/')}}">
                                        <input type="hidden" id="student-id" value="{{$student->id}}">

                                        <a class="btn theme-btn donate" data-toggle="modal" data-target="#donate-modal">@lang('messages.Sponsor')</a>
                                        {{--<div class="price">
                                            <span class="current-price">${{ceil($student->scholarship_amount * $settings->tk_to_usd)}}</span>
                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="wow slideInDown" id="empty-data-message">@lang('messages.Empty Student List')</p>
                        @endforelse
                    </div> <!-- end shop-content -->
                    @else
                    <div class="shop-content">
                        @forelse($students as $key => $student)
                            <?php
                            $key = $key + 5;
                            $time = "0.{$key}s";
                            ?>
                            <div class="grid wow fadeInLeftSlow" data-wow-delay="{{$time}}">
                                <div class="box">
                                    <div class="img-holder">
                                        <a href="{{url('sponsor/details/'.$student->id)}}">
                                            <img src="{{asset($student->student_image)}}" alt="No image"
                                                 class="img img-responsive">
                                        </a>
                                    </div>
                                    <div class="details text-center">
                                        <h3>
                                            <a href="{{url('sponsor/details/'.$student->id)}}">{{$student->name}}</a>
                                        </h3>
                                        <p class="price-bd">৳{{intval($student->scholarship_amount)}}</p>
                                        <p class="donate-status">@lang('messages.Yearly')</p>
                                        <p id="text-with-link" style="text-align: justify;  text-justify: inter-word;">
                                            <a href="{{url('sponsor/details/'.$student->id)}}">
                                                {{ str_limit($student->biography, 100) }}
                                                <span style="color: #ed323799">@lang('messages.Read more')</span>
                                            </a>
                                        </p>
                                        <!--student smile source image-->
                                        <input type="hidden" id="smile-img-{{$student->id}}"
                                               value="{{$student->student_smile_image}}">
                                        <input type="hidden" id="base_url" value="{{url('/')}}">
                                        <input type="hidden" id="student-id" value="{{$student->id}}">

                                        <a class="btn theme-btn donate" data-toggle="modal" data-target="#donate-modal">@lang('messages.Sponsor')</a>
                                        {{--<div class="price">
                                            <span class="current-price">${{ceil($student->scholarship_amount * $settings->tk_to_usd)}}</span>
                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="wow slideInDown" id="empty-data-message">@lang('messages.Empty Student List')</p>
                        @endforelse
                    </div> <!-- end shop-content -->
                    @endif
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end shop-main-content -->

    <!--Donate Modal-->
    @include('website.scholarship.scholarship_donate_modal')
    <!--Donate Modal-->
@endsection
