@extends('website.layouts.app')

@section('main-content')
    <div class="page-wrapper event-3col">
        <!-- start page-title -->
        <section class="page-title">
            <div class="page-title-bg"
                 style="background: url({{asset($setting->video_banner_image)}}) center center/cover no-repeat local;"></div>
            <div class="container">
                <div class="title-box">
                    <h1>@lang('messages.Video Album')</h1>
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}">@lang('messages.Home')</a></li>
                        <li class="active">@lang('messages.Video Album')</li>
                    </ol>
                    <a href="#" class="btn theme-btn" data-toggle="modal"
                       data-target="#donate-simple-modal">@lang('messages.Donate')</a>
                </div>
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <!-- start event-2col-section -->
        <section class="event-3col-section section-padding" id="video-section">
            <div class="container">
                <div class="row">
                        <div class="col col-xs-12 event-content event-grid-wrapper">
                            @foreach($videos_lists as $key => $video)
                                <?php
                                $name = request()->cookie('locale')=='bn' ? $video->bn_name: $video->name;
                                ?>
                                <div class="event-grid">
                                    <div class="event-box">
                                        <div class="img-holder">
                                            <div class="image-text-wrapper">
                                                <a href="{{url('video/category/'.$video->id)}}">
                                                    @if(!empty($video->videos()->first()->image))
                                                        <img src="{{asset($video->videos()->first()->image)}}" alt
                                                             class="img img-responsive">
                                                        {{--<i class="fa fa-video-camera" aria-hidden="true"></i>--}}
                                                        <div class="video-count">
                                                            <div class="video-count-text">
                                                                <i class="fa fa-video-camera" aria-hidden="true"></i>
                                                                @if($video->videos->count() > 5)
                                                                    <p>5+ </p>
                                                                @else
                                                                    <p>{{$video->videos->count()}}</p>
                                                                @endif
                                                                <p style="font-size: 16px">{{$name or null}}</p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </a>
                                            </div>
                                            {{--<div class="play-all">
                                                <i class="fa fa-video-camera" aria-hidden="true"></i>
                                                Play all
                                            </div>--}}

                                        </div>
                                        {{-- <div class="event-details">
                                             <span class="date">@lang('messages.Video Album')</span>
                                             <h3><a href="{{url('video/category/'.$video->id)}}">{{$video->name or null}}</a>
                                             </h3>
                                         </div>--}}
                                    </div>
                                </div>
                            @endforeach
                        </div> <!-- end event-content -->
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end event-2col-section -->
    </div>

@endsection

@push('style')
<link href="{{asset('site-assets/css/lightgallery.min.css')}}" rel="stylesheet">
@endpush

@push('scripts')
<script src='{{asset('site-assets/js/lightgallery-all.min.js')}}'></script>
<script>

    $(document).ready(function () {
        $('#lightgallery').lightGallery();
    });


</script>

@endpush