@extends('website.layouts.app')


@section('main-content')
    <!-- start page-title -->
    <section class="page-title">
        <div class="page-title-bg"
             style="background: url({{asset($setting->about_background_image)}}) center center/cover no-repeat local;"></div>
        <div class="container">
            <div class="title-box">
                <h1><span class="title-custom-color">OUR</span> VOLUNTEERS</h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Volunteers</li>
                </ol>
                <a href="{{ route('volunteers.create') }}" class="btn theme-btn">Sing Up</a>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->


    <!-- start volunteers -->
    <section class="volunteers section-padding">
        <div class="container">
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>{{ session()->get('message') }}</strong>
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row volunteers-grid">
                @foreach($volunteers as $volunteer)
                    <div class="col col-md-3 col-xs-6">
                        <div class="box">
                            <div class="img-holder">
                                @if(!empty($volunteer->block_image))
                                    <img src="{{asset($volunteer->block_image)}}" alt="{{$volunteer->name}}"
                                         class="img img-responsive">
                                @else
                                    <img src="{{asset('uploads/default/volunteers/block_image.png')}}"
                                         alt="{{$volunteer->name}}" class="img img-responsive">
                                @endif
                            </div>
                            <div class="hover-text">
                                <div>
                                    <a href="{{url('volunteers/'.$volunteer->id)}}">
                                        <h4>{{$volunteer->name}}</h4>
                                        <span>{{$volunteer->contact_no}}</span>
                                    </a>
                                    {{--<span>CEO, Hooli</span>--}}
                                    <ul class="social-links">
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div> <!-- end row -->

            {{--<div class="pagination-wrapper">
                <ul class="">
                    <li>
                        <a href="#" aria-label="Previous">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li>
                        <a href="#" aria-label="Next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </div>--}} <!-- end pagination-wrapper -->
        </div> <!-- end container -->
    </section>
    <!-- end volunteers -->


    <!-- start cta-2 -->
    <section class="cta-2">
        <div class="sing-up-border"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col col-md-5 col-sm-4 join-us">
                    <span>Join us</span>
                </div>

                <div class="col col-md-7 col-sm-8 sing-up wow fadeInRightSlow">
                    <h3><span><img src="{{asset('site-assets/images/sing-up-icon.png')}}" alt></span> Sign up for volunteer program</h3>
                    <span>Serve the humanity</span>
                    <p>Iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa
                        quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                    <a href="{{ route('volunteers.create') }}" class="btn theme-btn">Sing up</a>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end cta-2 -->
@endsection

@push('style')
<link href="{{asset('site-assets/css/jquery.fancybox.css')}}" rel="stylesheet">
@endpush