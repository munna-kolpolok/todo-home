@extends('website.layouts.app')

@section('main-content')
    <!-- start page-title -->
    <section class="page-title">
        <div class="page-title-bg"
             style="background: url({{asset($setting->video_banner_image)}}) center center/cover no-repeat local;"></div>
        <div class="container">
            <div class="title-box">
                <h1>@lang('messages.Video Gallery')</h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}">@lang('messages.Home')</a></li>
                    <li><a href="{{ url('/video') }}">@lang('messages.Video')</a></li>
                    <li class="active">{{$category_name or null}}</li>
                </ol>
                <a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">@lang('messages.Donate')</a>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- start gallery-3col-content -->
    <section class="gallery-3col-content sortable-gallery gallery section-padding">
        <div class="container">
            <div class="row">
                <div id="video-gallery">
                    <div class="cont">
                        <div class="demo-gallery">
                            <ul id="lightgallery">
                                @foreach($videos as $video)
                                    @if(!empty($video->image))
                                        <li class="video" data-src="{{$video->video_link or null}}">
                                            <a href="">
                                                <img class="img-responsive"
                                                     src="{{asset($video->image)}}">
                                                <div class="demo-gallery-poster">
                                                    <img src="https://sachinchoolur.github.io/lightGallery/static/img/play-button.png">
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </div>
    </section>
    <!-- end gallery-3col-content -->

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