@extends('website.layouts.app')

@section('main-content')
<!-- start page-title -->    
<section class="page-title">
    <div class="page-title-bg" style="background: url({{asset($setting->gallery_background_image)}}) center center/cover no-repeat local;"></div>
    <div class="container">
        <div class="title-box">
            <h1>@lang('messages.Gallery')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">@lang('messages.Home')</a></li>
                <li class="active">@lang('messages.Gallery')</li>
            </ol>
            <a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">@lang('messages.Donate')</a>
        </div>
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- start gallery-3col-content -->
<section class="gallery-3col-content sortable-gallery gallery section-padding">
    <h2 class="hidden">@lang('messages.Gallery')</h2>
    <div class="container">
        <div class="row">
            <div class="col col-lg-10 col-lg-offset-1">
                <div class="gallery-filters">
                    @if(request()->cookie('locale')=='bn')
                        <ul>
                        <li><a data-filter="*" href="#" class="current">@lang('messages.All')</a></li>
                        @foreach($gallery_categories as $gallery_category)
                        <li><a data-filter=".gallery_dynamic_c_{{ $gallery_category->id }}" href="#">{{ $gallery_category->bn_name or null }}</a></li>
                        @endforeach
                    </ul>
                    @else
                        <ul>
                            <li><a data-filter="*" href="#" class="current">@lang('messages.All')</a></li>
                            @foreach($gallery_categories as $gallery_category)
                                <li><a data-filter=".gallery_dynamic_c_{{ $gallery_category->id }}" href="#">{{ $gallery_category->name or null }}</a></li>
                            @endforeach
                        </ul>
                    @endif

                </div>

                <div class="gallery-container popup-gallery">
                	@foreach($galleries as $gallery)
                    <div class="box gallery_dynamic_c_{{ $gallery->gallery_category_id }}">
                        <a href="{{ url($gallery->gallery_big_image) }}">
                            <img src="{{ asset($gallery->gallery_image) }}" alt class="img img-responsive">
                        </a>
                    </div>
                    @endforeach
                    
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end gallery-3col-content -->

@endsection

@push('style')
<link href="{{asset('site-assets/css/magnific-popup.css')}}" rel="stylesheet">
@endpush