@extends('website.layouts.app')

@section('main-content')
<div class="page-wrapper contact-page">
<!-- start page-title -->    
<section class="page-title">
    <div class="page-title-bg" style="background: url('{{asset($setting->bank_info_banner_image)}}') center center/cover no-repeat local;"></div>
    <div class="container">
        <div class="title-box">
            <h1><span class="title-custom-color">@lang('messages.Banks') </span> @lang('messages.Informations')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">@lang('messages.Home')</a></li>
                <li class="active">@lang('messages.Bank Info')</li>
            </ol>
            {{--<a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">Donate</a>--}}
        </div>
    </div> <!-- end container -->
</section>
<!-- end page-title -->


<!-- start contact-main-content -->
<section style="padding: 85px 0" class="banking-info-page section-padding">

    <div class="container">
        <div class="pay-bank-wrapper">
            <div class="row row-centered">
                <h3 class="payment-heading">@lang('messages.Payment With Bank')</h3>
                <div class="col-md-4 col-sm-6 col-centered wow fadeInLeftSlow">
                    <div class="serviceBox green">
                        <div class="service-icon" style="background-color: white; padding-right: 5px;">
                            <i class="" aria-hidden="true"><img src="{{url(asset('la-assets/img/sibl.png'))}}" style="width: 92px; height:auto;" alt=""></i>
                        </div>
                        <h3 class="title">@lang('messages.Social Islamic Bank Ltd')</h3>
                        <ul class="account-info">
                            <li>
                                <i class="fa fa-money" aria-hidden="true"></i>
                                <span>@lang('messages.A/C Name') : </span>@lang('messages.Bidyanondo Foundation')
                            </li>
                            <li>
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span>@lang('messages.A/C No') : </span><span class="highlight">@lang('messages.0221330016199')</span>
                            </li>
                            <li>
                                <i class="fa fa-codepen" aria-hidden="true"></i>
                                <span>@lang('messages.Swift Code') : </span>SOIVBDDH
                            </li>
                            <li>
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span>@lang('messages.Branch') : </span>@lang('messages.Nawabpur Branch'),<br> @lang('messages.Dhaka')
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-centered wow fadeInLeftSlow" data-wow-delay="0.3s">
                    <div class="serviceBox green">
                        <div class="service-icon" style="background-color: white;">
                            <i class="" aria-hidden="true"><img src="{{url(asset('la-assets/img/dbbl.png'))}}" style="width: 82px; height:auto;" alt=""></i>
                        </div>
                        <h3 class="title">@lang('messages.Dutch-Bangla Bank Ltd')</h3>
                        <ul class="account-info">
                            <li>
                                <i class="fa fa-money" aria-hidden="true"></i>
                                <span>@lang('messages.A/C Name') : </span>@lang('messages.Bidyanondo Foundation')
                            </li>
                            <li>
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span>@lang('messages.A/C No') : </span><span class="highlight">@lang('messages.10612012479')</span>
                            </li>
                            <li>
                                <i class="fa fa-codepen" aria-hidden="true"></i>
                                <span>@lang('messages.Swift Code') : </span>
                            </li>
                            <li>
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span>@lang('messages.Branch') : </span>@lang('messages.Narayangonj Branch'),<br>@lang('messages.Narayangonj')
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="pay-mobile-bank-wrapper">
            <div class="row row-centered">
                <h3 class="payment-heading">@lang('messages.Payment With Mobile Banking')</h3>
                <div class="col-md-3 col-sm-6 col-centered wow fadeInLeftSlow">
                    <div class="serviceBox blue">
                        <div class="service-icon" style="background-color: white;">
                            <i class="" aria-hidden="true"><img src="{{url(asset('la-assets/img/bkash.png'))}}" style="width: 92px; height:auto;" alt=""></i>
                        </div>
                        <h3 class="title">@lang('messages.BKash')</h3>
                        <ul class="account-info">
                            <li>
                                <i class="fa fa-money" aria-hidden="true"></i>
                                <span>@lang('messages.A/C Type') : </span>@lang('messages.Merchant')
                            </li>
                            <li>
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span>@lang('messages.A/C No') : </span><span class="highlight">@lang('messages.01878116230') </span>
                            </li>
                            <li>
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span>@lang('messages.Payment Option PIN') : </span><span class="highlight">@lang('messages.1') </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-centered wow fadeInLeftSlow" data-wow-delay="0.3s">
                    <div class="serviceBox blue">
                        <div class="service-icon" style="background-color: white;">
                            <i class="" aria-hidden="true"><img src="{{url(asset('la-assets/img/bkash.png'))}}" style="width: 92px; height:auto;" alt=""></i>
                        </div>
                        <h3 class="title">@lang('messages.BKash')</h3>
                        <ul class="account-info">
                            <li>
                                <i class="fa fa-money" aria-hidden="true"></i>
                                <span>@lang('messages.A/C Type') : </span>@lang('messages.Personal')
                            </li>
                            <li>
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span>@lang('messages.A/C No') : </span><span class="highlight">@lang('messages.01631554646')</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-centered wow fadeInLeftSlow" data-wow-delay="0.6s">
                    <div class="serviceBox blue">
                        <div class="service-icon" style="background-color: white;">
                            <i class="" aria-hidden="true"><img src="{{url(asset('la-assets/img/bkash.png'))}}" style="width: 92px; height:auto;" alt=""></i>
                        </div>
                        <h3 class="title">@lang('messages.BKash')</h3>
                        <ul class="account-info">
                            <li>
                                <i class="fa fa-money" aria-hidden="true"></i>
                                <span>@lang('messages.A/C Type') : </span>@lang('messages.Personal')
                            </li>
                            <li>
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span>@lang('messages.A/C No') : </span><span class="highlight">@lang('messages.01614174755')</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-centered wow fadeInLeftSlow" data-wow-delay="0.9s">
                    <div class="serviceBox blue">
                        <div class="service-icon" style="background-color: white;">
                            <i class="" aria-hidden="true"><img src="{{url(asset('la-assets/img/bkash.png'))}}" style="width: 92px; height:auto;" alt=""></i>
                        </div>
                        <h3 class="title">@lang('messages.BKash')</h3>
                        <ul class="account-info">
                            <li>
                                <i class="fa fa-money" aria-hidden="true"></i>
                                <span>@lang('messages.A/C Type') : </span>@lang('messages.Personal')
                            </li>
                            <li>
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span>@lang('messages.A/C No') : </span><span class="highlight">@lang('messages.01614174756')</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row row-centered">
                <div class="col-md-3 col-sm-6 col-centered wow fadeInLeftSlow">
                    <div class="serviceBox blue">
                        <div class="service-icon" style="background-color: white;">
                            <i class="" aria-hidden="true"><img src="{{url(asset('la-assets/img/bkash.png'))}}" style="width: 92px; height:auto;" alt=""></i>
                        </div>
                        <h3 class="title">@lang('messages.BKash')</h3>
                        <ul class="account-info">
                            <li>
                                <i class="fa fa-money" aria-hidden="true"></i>
                                <span>@lang('messages.A/C Type') : </span>@lang('messages.Personal')
                            </li>
                            <li>
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span>@lang('messages.A/C No') : </span><span class="highlight">@lang('messages.01614174757') </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-centered wow fadeInLeftSlow" data-wow-delay="0.3s">
                    <div class="serviceBox blue">
                        <div class="service-icon" style="background-color: white;">
                            <i class="" aria-hidden="true"><img src="{{url(asset('la-assets/img/bkash.png'))}}" style="width: 92px; height:auto;" alt=""></i>
                        </div>
                        <h3 class="title">@lang('messages.BKash')</h3>
                        <ul class="account-info">
                            <li>
                                <i class="fa fa-money" aria-hidden="true"></i>
                                <span>@lang('messages.A/C Type') : </span>@lang('messages.Personal')
                            </li>
                            <li>
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span>@lang('messages.A/C No') : </span><span class="highlight">@lang('messages.01614174758') </span>
                            </li>
                        </ul>
                    </div>
                </div>
                {{--<div class="col-md-3 col-sm-6 col-centered wow fadeInLeftSlow" data-wow-delay="0.3s">
                    <div class="serviceBox blue">
                        <div class="service-icon" style="background-color: white;">
                            <i class="" aria-hidden="true"><img src="{{url(asset('la-assets/img/bkash.png'))}}" style="width: 92px; height:auto;" alt=""></i>
                        </div>
                        <h3 class="title">@lang('messages.BKash')</h3>
                        <ul class="account-info">
                            <li>
                                <i class="fa fa-money" aria-hidden="true"></i>
                                <span>@lang('messages.A/C Type') : </span>@lang('messages.Personal')
                            </li>
                            <li>
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span>@lang('messages.A/C No') : </span><span class="highlight">@lang('messages.01614 174 755 -58') </span>
                            </li>
                        </ul>
                    </div>
                </div>--}}
                <div class="col-md-3 col-sm-6 col-centered wow fadeInLeftSlow" data-wow-delay="0.6s">
                    <div class="serviceBox green">
                        <div class="service-icon" style="background-color: white;">
                            <i class="" aria-hidden="true"><img src="{{url(asset('la-assets/img/rocket.png'))}}" style="width: 92px; height:auto;" alt=""></i>
                        </div>
                        <h3 class="title">@lang('messages.Rocket (DBBL)')</h3>
                        <ul class="account-info">
                            <li>
                                <i class="fa fa-money" aria-hidden="true"></i>
                                <span>@lang('messages.A/C Type') : </span>@lang('messages.Personal')
                            </li>
                            <li>
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span>@lang('messages.A/C No') : </span><span class="highlight">@lang('messages.017141180737') </span>
                            </li>
                        </ul>
                    </div>
                </div>
                {{--<div class="col-md-3 col-sm-6 col-centered wow fadeInLeftSlow" data-wow-delay="0.9s">
                    <div class="serviceBox blue">
                        <div class="service-icon">
                            <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                        </div>
                        <h3 class="title">BKash</h3>
                        <ul class="account-info">
                            <li>
                                <i class="fa fa-money" aria-hidden="true"></i>
                                <span>A/C Type : </span>Personal
                            </li>
                            <li>
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span>A/C No : </span><span class="highlight">xxxxxx</span>
                            </li>
                        </ul>
                    </div>
                </div> --}}
            </div>
            <div class="row row-centered">
                <h3 style="color:#00c292; padding: 30px 0" >@lang('messages.Paypal Account')</h3>
                <div class="col-md-3 col-sm-6 col-centered wow fadeInLeftSlow">
                    <div class="serviceBox blue">
                        <div class="service-icon" style="background-color: white;">
                            <i class="" aria-hidden="true"><img src="{{url(asset('la-assets/img/paypal-logo-1.png'))}}" style="width: 92px; height:auto;" alt=""></i>
                        </div>
                        <h3 class="title">@lang('messages.Paypal')</h3>
                        <ul class="account-info">
                            <li>
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span>@lang('messages.Account') : </span><span class="highlight" style="font-size: 14px; text-transform: lowercase;">support@bidyanondo.org </span>
                            </li>
                        </ul>
                    </div>
                </div>



            </div>
        </div>
    </div>
</section>
<!-- end contact-main-content -->

</div>

@endsection


