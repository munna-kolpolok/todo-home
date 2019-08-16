@extends('website.layouts.app')

@section('main-content')
    <div class="page-wrapper contact-page">
        <!-- start page-title -->
        <section class="page-title">
            <div class="page-title-bg"
                 style="background: url('{{asset($setting->branch_info_banner_image)}}') center center/cover no-repeat local;"></div>
            <div class="container">
                <div class="title-box">
                    <h1>
                        <span class="title-custom-color">@lang('messages.Branches') </span> @lang('messages.Information')
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}">@lang('messages.Home')</a></li>
                        <li class="active">@lang('messages.Branches Information')</li>
                    </ol>
                    {{--<a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">Donate</a>--}}
                </div>
            </div>
            <!-- end container -->
        </section>
        <!-- end page-title -->


        <!-- start contact-main-content -->
        <section style="padding: 85px 0" class="banking-info-page section-padding">
            <div class="container">
                <div class="pay-bank-wrapper">
                    @if(request()->cookie('locale')=='bn')
                        {{--Bangla lang Start--}}
                        <div class="row row-centered">
                            @forelse($branches as $key => $branch)
                                <?php
                                $key = $key + 5;
                                $time = "0.{$key}s";
                                ?>
                                <div class="col-md-4 col-sm-6 col-centered wow fadeInDown" data-wow-delay="{{$time}}">
                                    <div class="serviceBox green">
                                        <div class="service-icon" style="background-color: white; padding-right: 5px;">
                                            <i class="" aria-hidden="true"><img
                                                        src="{{url(asset($setting->logo))}}"
                                                        style="width: 92px; height:auto;" alt=""></i>
                                        </div>
                                        <h3 class="title">{{$branch->bn_name or null}}</h3>
                                        <ul class="account-info">
                                            <li>
                                                <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                                <span class="highlight">{{\App\Helpers\CommonHelper::en2bnNumber(intval($branch->contact_no))}}
                                                   {{-- {{$branch->bn_contact_no or null}}--}}</span>
                                            </li>
                                            <li>
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                {{$branch->bn_address or null}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                <p>@lang('messages.No Data Available.')</p>
                            @endforelse
                        </div>
                    @else
                        {{--English lang start--}}
                        <div class="row row-centered">
                            @forelse($branches as $key => $branch)
                                <?php
                                $key = $key + 5;
                                $time = "0.{$key}s";
                                ?>
                                <div class="col-md-4 col-sm-6 col-centered wow fadeInDown" data-wow-delay="{{$time}}">
                                    <div class="serviceBox green">
                                        <div class="service-icon" style="background-color: white; padding-right: 5px;">
                                            <i class="" aria-hidden="true"><img
                                                        src="{{url(asset($setting->logo))}}"
                                                        style="width: 92px; height:auto;" alt=""></i>
                                        </div>
                                        <h3 class="title">{{$branch->name or null}}</h3>
                                        <ul class="account-info">
                                            <li>
                                                <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                                <span class="highlight">{{$branch->contact_no or null}}</span>
                                            </li>
                                            <li>
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                {{$branch->address or null}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                <p>No Data Available.</p>
                            @endforelse
                        </div>
                    @endif

                </div>
            </div>
        </section>
        <!-- end contact-main-content -->

    </div>

@endsection


