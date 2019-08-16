@extends('website.layouts.app')


@section('main-content')
<!-- start page-title -->
<section class="page-title">
    <div class="page-title-bg" style="background: url({{asset($setting->about_background_image)}}) center center/cover no-repeat local;"></div>
    <div class="container">
        <div class="title-box">
            <h1><span class="title-custom-color"></span>Donate</h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">donate</li>
            </ol>
            <a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">Donate</a>
        </div>
    </div> <!-- end container -->
</section>
<!-- end page-title -->


<!-- start about-details -->
<section class="about-us-st section-padding" id="donate">
    <div class="container">
        <!-- <h2><span>About</span> us</h2> -->
        <div class="row">
            <div style="padding: 0" class="col col-md-8 wow fadeInLeftSlow">
                <div class="left-col">
                    <div class="donate-client">
                        <div id="account-tab">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active">
                                    <a class="nav-link" data-toggle="tab" href="#bdt-simple">
                                        ৳ BDT
                                    </a>
                                </li>

                                <li>
                                    <a data-toggle="tab" href="#usd-simple">
                                        <i class="fa fa-usd"></i> USD
                                    </a>
                                </li>
                            </ul>
                        <?php $donation_amounts = \App\Models\Donation_Amount::where('general_donation',1)
                            ->get(['amount','currency','description','column']);?>
                        <!-- Tab panes -->
                            <div class="tab-content" id="general_payment">
                                <div id="usd-simple" class="tab-pane fade">
                                    <div class="amount">
                                        <form method="POST"
                                              role="form" action="{{url('/pay_with_paypal')}}" id="general_g_p_form" onsubmit="return validatePaypalGeneralForm();">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="donate_way" value="1">
                                            <input type="hidden" class="user_id" name="user_id" value="">

                                            <div class="row">
                                                @foreach($donation_amounts as $donation_amount)
                                                    @if($donation_amount->currency == 'USD')
                                                        <div class="col-md-{{$donation_amount->column}}">
                                                            <label class="radio-inline">
                                                                <input name="amount" checked  value="{{$donation_amount->amount}}" type="radio" /><span class="in-currency">$</span>{{$donation_amount->amount}} {{$donation_amount->description or null}}
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach

                                                <div class="col-md-6">
                                                    <input type="hidden" id="genreral_paypal_min_donate_amount" value="{{ $currency_usd->min_donate_amount }}">
                                                    <label class="radio-inline" style="display: block">
                                                        <input name="amount" id="general_in_simple" value="" type="radio" />
                                                        <input type="number" step="1" id="general_paypal_custom_amount" name="custom_amount" min="{{ $currency_usd->min_donate_amount }}" class="custom_amount" placeholder="Custom Amount In English">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-12" style="margin: 5px 0 15px 0; padding: 0">
                                                <textarea type="text" name="comments" id="general_g_p_comments" class="form-control comments" placeholder="Comments here.."></textarea>
                                            </div>
                                            <div class="payment-button">
                                                <button type="submit"
                                                        class="btn theme-btn btn-block paypal_btn"
                                                >
                                                    <i class="fa fa-paypal"></i>  Paywith Paypal &#47; Credit Card
                                                </button>


                                                <label class="btn theme-btn btn-block paypal_btn_processing" id=""><i class="fa fa-paypal" style="color:white"></i> Paywith Paypal &#47; Credit Card <i class="fa fa-gear fa-spin"></i></label>
                                            </div>

                                            @include('website.layouts.donate_ssl_button')


                                        </form>
                                    </div>
                                </div>
                                <div id="bdt-simple" class="tab-pane active">
                                    <div class="buy-wrapper">
                                        <div class="amount">
                                            <form method="POST"
                                                  role="form" action="{{url('/donation_confirmation')}}" id="general_g_s_form" onsubmit="return validateSslGeneralForm();">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="donate_way" value="1">
                                                <input type="hidden" class="user_id" name="user_id" value="">

                                                <div class="row">
                                                    @foreach($donation_amounts as $donation_amount)
                                                        @if($donation_amount->currency == 'BDT')
                                                            <div class="col-md-6">
                                                                <label class="radio-inline">
                                                                    <input name="amount" checked  value="{{$donation_amount->amount}}" type="radio" /><span class="bd-currency">৳</span>{{$donation_amount->amount}} {{$donation_amount->description or null}}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    <div class="col-md-6">
                                                        <input type="hidden" id="general_ssl_min_donate_amount" value="{{ $currency_bdt->min_donate_amount }}">
                                                        <label class="radio-inline" style="display: block">
                                                            <input name="amount" id="general_bd_simple" type="radio" />
                                                            <input type="number" id="general_ssl_custom_amount"  name="custom_amount" min="{{ $currency_bdt->min_donate_amount }}" class="custom_amount" placeholder="Custom Amount In English">
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin: 5px 0 15px 0; padding: 0">
                                                    <textarea type="text"  name="comments" class="form-control comments" placeholder="Comments here.." id="general_g_s_comments"></textarea>
                                                </div>



                                                <div class="payment-button">
                                                    <button type="submit"
                                                            class="btn theme-btn btn-block ssl_btn"
                                                    >
                                                        <i class="fa fa-money"></i> Pay with card/bKash
                                                    </button>

                                                    <label class="btn theme-btn btn-block ssl_btn_processing" id=""><i class="fa fa-money"></i> Paywith card/bKash <i class="fa fa-gear fa-spin"></i></label>

                                                </div>

                                                @include('website.layouts.donate_ssl_button')

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end left-col -->
            </div> <!-- end col -->

            <div class="col col-md-4 wow fadeInRightSlow">
                <div class="right-col">
                    <div class="video">
                        <img src="{{asset($setting->donate_poster_image)}}" alt="" class="img img-responsive">
                        <a href="{{ $setting->donate_video_link or null}}"  class="video-btn" data-type="iframe"><i class="fa fa-play"></i></a>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end about-details -->



<!-- start cta -->
<section class="cta">
    <div class="container">
        <div class="row">
            <div class="col col-md-5 col-sm-5">
                <img src="{{asset($setting->signup_donor_image)}}" alt class="img img-responsive">
            </div>

            <div class="col col-md-6 col-md-offset-1 col-sm-7">
                <div class="cta-details wow fadeInRightSlow">
                    <h2>Join us</h2>
                    <p>{{ $setting->sign_up_donor_message or null}}</p>
                    <a href="{{ url('signup') }}" class="btn theme-btn">Sing up</a>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end cta -->


<!-- start cta-4 -->
<section class="cta-4 section-padding">
    <h2 class="hidden">CTA 4</h2>
    <div class="container">
        <div class="row">
            <div class="col col-sm-4">
                <div class="wow fadeInLeftSlow">
                    <span class="icon"><i class="fi flaticon-money-1"></i></span>
                    <h3>{{ $setting->cta_title_1 or null}}</h3>
                    <p>{{ $setting->cta_message_1 or null}}</p>
                    <a href="#" class="read-more" data-toggle="modal" data-target="#donate-simple-modal">@lang('messages.Donate now')</a>
                    <!-- <a href="#" class="btn theme-btn">@lang('messages.Donate now')</a> -->
                </div>
            </div>
            <div class="col col-sm-4">
                <div class="wow fadeInLeftSlow" data-wow-delay="0.3s">
                    <span class="icon"><i class="fi flaticon-heart"></i></span>
                    <h3>{{ $setting->cta_title_2 or null}}</h3>
                    <p>{{ $setting->cta_message_2 or null}}</p>
                    <a href="{{ url('volunteer/registration') }}" class="read-more">Registration</a>
                    <!-- <a href="#" class="btn theme-btn">Sign Up</a> -->
                </div>
            </div>
            <div class="col col-sm-4">
                <div class="wow fadeInLeftSlow" data-wow-delay="0.6s">
                    <span class="icon"><i class="fi flaticon-business-1"></i></span>
                    <h3>{{ $setting->cta_title_3 or null}}</h3>
                    <p>{{ $setting->cta_message_3 or null}}</p>
                    <a href="{{ url('sponsor') }}" class="read-more">Sponsor</a>
                    <!-- <a href="#" class="btn theme-btn">Sponsor</a> -->
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end cta-4 -->

@endsection

@push('style')
<link href="{{asset('site-assets/css/jquery.fancybox.css')}}" rel="stylesheet">
@endpush

@push('scripts')
<script type="text/javascript">
    
    $(function () {
        //............Donate button submit start............
        $('#general_g_s_form').submit(function() {
           $(".ssl_btn").hide();
           $(".ssl_btn_processing").show();
           return true;
        });
        $('#general_g_p_form').submit(function() {
            //alert('munna');
           $(".paypal_btn").hide();
           $(".paypal_btn_processing").show();
           return true;
        });
        //............Donate button submit end............
    });
</script>
@endpush