@extends('website.layouts.app')


@section('main-content')
    <!-- start page-title -->
    <section class="page-title">
        <div class="page-title-bg"
             style="background: url({{asset($setting->about_background_image)}}) center center/cover no-repeat local;"></div>
        <div class="container">
            <div class="title-box">
                <h1><span class="title-custom-color">VOLUNTEERS</span> Details</h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Volunteer</li>
                </ol>
                <a href="{{ route('volunteers.create') }}" class="btn theme-btn">Sing Up</a>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->


    <!-- start volunteer-single-section -->
    <section class="volunteer-single-section">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="volunteer-profile-title">
                        <div class="img-holder">
                            @if(!empty($volunteer->profile_image))
                                <img src="{{$volunteer->profile_image}}" alt class="img img-responsive">
                            @else
                                <img src="{{asset('uploads/default/volunteers/profile_image.png')}}" alt
                                     class="img img-responsive">
                            @endif
                        </div>
                        <div>
                            <h3>{{$volunteer->name or null}}</h3>
                            <p><span>{{$volunteer->contact_no or null}}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row volunteer-content">
                <div class="col col-md-4">
                    <div class="info">
                        <div class="box-title">
                            <h3><i class="fa fa-pencil"></i> Info</h3>
                        </div>
                        <ul class="info-details">
                            <li>
                                <span>Contact</span>
                                <span>{{$volunteer->contact_no or null}}</span>
                            </li>
                            <li>
                                <span>Email</span>
                                <span>{{$volunteer->email or null}}</span>
                            </li>
                            <li>
                                <span>Interest</span>
                                <span>{{$volunteer->interest or null}}</span>
                            </li>
                            <li>
                                <span>Address</span>
                                <span>{{$volunteer->address or null}}</span>
                            </li>
                        </ul>

                        <div class="social">
                            <span>social</span>
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col col-md-8">
                    <div class="bio">
                        <div class="box-title">
                            <h3><i class="fa fa-pencil"></i> Bio</h3>
                        </div>
                        <pre>{{$volunteer->biography or null}}</pre>
                    </div>
                    <div class="similar-profile">
                        <div class="box-title">
                            <h3><i class="fa fa-pencil"></i> Similar profiles</h3>
                        </div>
                        <ul>
                            @if(count($volunteers) > 0)
                            @foreach($volunteers as $volunteer)
                                <li>
                                    <a href="{{url('volunteers/'.$volunteer->id)}}">
                                        @if(!empty($volunteer->profile_image))
                                            <img src="{{$volunteer->profile_image}}" alt="" width="70px" height="70px">
                                        @else
                                            <img src="{{asset('uploads/default/volunteers/profile_image.png')}}" alt=""
                                                 width="70px" height="70px">

                                        @endif
                                    </a>
                                </li>
                            @endforeach
                                @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end volunteer-single-section -->
@endsection

@push('style')
<link href="{{asset('site-assets/css/jquery.fancybox.css')}}" rel="stylesheet">
@endpush