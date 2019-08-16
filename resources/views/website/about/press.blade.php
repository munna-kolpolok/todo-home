<?php
$requestSegment1 = \Request::segment(1);
$requestSegment2 = \Request::segment(2);

if ($requestSegment1 == 'press' && $requestSegment2 == null) {
    $allSelected = 'current';
} else {
    $allSelected = '';
}




?>

@extends('website.layouts.app')

@section('main-content')
    <div class="page-wrapper" id="press-section">
        <!-- start page-title -->
        <section class="page-title">
            <div class="page-title-bg"
                 style="background: url({{asset($setting->press_banner_image)}}) center center/cover no-repeat local;"></div>
            <div class="container">
                <div class="title-box">
                    <h1>@lang('messages.press')</h1>
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}">@lang('messages.Home')</a></li>
                        @if(empty($press_category_title))
                            <li class="active">@lang('messages.press')</li>
                        @else
                            <li><a href="{{ url('/press') }}">@lang('messages.press')</a></li>
                            <li class="active">{{$press_category_title}}</li>
                        @endif
                    </ol>
                    <a href="#" class="btn theme-btn" data-toggle="modal"
                       data-target="#donate-simple-modal">@lang('messages.Donate')</a>
                </div>
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <!-- start evnets -->
        <section class="events section-padding" id="press-section-inner">
            @if(request()->cookie('locale')=='bn')
                {{--..........Bangla language start....--}}
                <div class="row section-title">
                    <div class="col col-xs-12">
                        {{--<h2 style="margin-bottom: 10px">Featured Press</h2>--}}
                        <ul class="breadcrumb">
                            <li><a class="{{$allSelected}}" href="{{url('/press')}}">@lang('messages.All')</a></li>
                            @foreach($press_categories as $category)
                                @if($category->id == $requestSegment2)
                                    <?php $current = 'current';?>
                                @else
                                    <?php $current = '';?>
                                @endif
                                <li><a class="{{$current}}"
                                       href="{{url('press/'.$category->id)}}">{{$category->bn_name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div> <!-- end section-title -->

                <div class="row">
                    <div class="events-slider">
                        @foreach($presses as $press)
                            <div class="item">
                                <div class="img-holder">
                                    @if($press->is_video == 1)
                                        <div class="video">
                                            <img src="{{asset($press->image)}}" alt="" class="img img-responsive">
                                            <a href="{{$press->press_link}}?autoplay=1" class="video-btn"
                                               data-type="iframe"><i
                                                        class="fa fa-play"></i></a>
                                        </div>
                                    @elseif($press->is_video == 0)
                                        <img src="{{asset($press->image)}}" alt class="img img-responsive">
                                    @endif
                                </div>
                                <div class="details">
                                    <ul>
                                        <li>
                                            <i class="fa fa-calendar"></i> {{\App\Helpers\CommonHelper::en2bnNumber(date("j F, Y", strtotime($press->published_date)))}}
                                        </li>
                                    </ul>
                                    <div id="text-with-link" style="color: #fff;">
                                        <a style="color: #fff" target="_blank" href="{{$press->press_link}}">
                                            {{str_limit($press->bn_description, 65)}}
                                            <div class="read-more-button">
                                                @lang('messages.Read more') &rarr;
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                {{--..........//Bangla language start....--}}
                {{--..........English language start....--}}
                <div class="row section-title">
                    <div class="col col-xs-12">
                        {{--<h2 style="margin-bottom: 10px">Featured Press</h2>--}}
                        <ul class="breadcrumb">
                            <li><a class="{{$allSelected}}" href="{{url('/press')}}">@lang('messages.All')</a></li>
                            @foreach($press_categories as $category)
                                @if($category->id == $requestSegment2)
                                    <?php $current = 'current';?>
                                @else
                                    <?php $current = '';?>
                                @endif
                                <li><a class="{{$current}}"
                                       href="{{url('press/'.$category->id)}}">{{$category->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div> <!-- end section-title -->

                <div class="row">
                    <div class="events-slider">
                        @foreach($presses as $press)
                            <div class="item">
                                <div class="img-holder">
                                    @if($press->is_video == 1)
                                        <div class="video">
                                            <img src="{{asset($press->image)}}" alt="" class="img img-responsive">
                                            <a href="{{$press->press_link}}?autoplay=1" class="video-btn"
                                               data-type="iframe"><i
                                                        class="fa fa-play"></i></a>
                                        </div>
                                    @elseif($press->is_video == 0)
                                        <img src="{{asset($press->image)}}" alt class="img img-responsive">
                                    @endif
                                </div>
                                <div class="details">
                                    <ul>
                                        <li>
                                            <i class="fa fa-calendar"></i> {{date("F jS, Y", strtotime($press->published_date))}}
                                        </li>
                                    </ul>
                                    <div id="text-with-link" style="color: #fff;">
                                        <a style="color: #fff" target="_blank" href="{{$press->press_link}}">
                                            {{str_limit($press->description, 65)}}
                                            <div class="read-more-button">
                                                @lang('messages.Read more') &rarr;
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{--..........//English language start....--}}
            @endif
        </section>
        <!-- end events -->


    </div>
@endsection

@push('style')
<link href="{{asset('site-assets/css/jquery.fancybox.css')}}" rel="stylesheet">
@endpush


@push('style')

<link href="{{asset('site-assets/css/owl.carousel.css')}}" rel="stylesheet">
<!-- <link href="{{asset('site-assets/css/owl.theme.css')}}" rel="stylesheet">
<link href="{{asset('site-assets/css/owl.transitions.css')}}" rel="stylesheet"> -->
@endpush