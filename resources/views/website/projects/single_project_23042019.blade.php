@extends('website.layouts.app')


@section('main-content')
    <!-- start about-details -->
    <section style="padding: 125px 0 35px 0; background: none" class="about-us-st" id="donate">
        <div class="container">
            <!-- <h2><span>About</span> us</h2> -->
            <div class="row">
                <div style="padding: 0" class="col col-md-4 col-xs-12 wow fadeInRightSlow">
                    <div class="right-col">
                        <div class="video">
                            <img style="min-height: 412px" src="{{asset($project->project_image)}}" alt=""
                                 class="img img-responsive">
                            <a href="{{$project->video_link}}?autoplay=1" class="video-btn" data-type="iframe"><i
                                        class="fa fa-play"></i></a>
                        </div>
                    </div>
                </div>
                <div style="padding: 0" class="col col-md-8 col-xs-12 wow fadeInLeftSlow">
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
                                <!-- Tab panes -->
                                <div class="tab-content" id="general_payment">
                                    <div id="usd-simple" class="tab-pane fade">
                                        <div style="padding: 20px 35px" class="amount">
                                            <form method="POST"
                                                  role="form" action="{{url('/pay_with_paypal')}}" id="general_g_p_form"
                                                  onsubmit="return validatePaypalProjectForm();" target="_blank">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="project_id" class="project_id"
                                                       value="{{$project->id}}">
                                                <input type="hidden" name="donate_way" value="2">
                                                <input type="hidden" class="user_id" name="user_id" value="">

                                                <div class="row">
                                                    @foreach($donation_amounts as $donation_amount)
                                                        @if($donation_amount->currency == 'USD')
                                                            <div class="col-md-{{$donation_amount->column}}">
                                                                <label class="radio-inline">
                                                                    <input name="amount" checked
                                                                           value="{{$donation_amount->amount}}"
                                                                           type="radio"/><span
                                                                            class="in-currency">$</span>{{$donation_amount->amount}}
                                                                    ({{$donation_amount->description or null}})
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                    <div class="col-md-6">
                                                        <input type="hidden" id="genreral_paypal_min_donate_amount"
                                                               value="{{ $currency_usd->min_donate_amount }}">
                                                        <label class="radio-inline" style="display: block">
                                                            <input name="amount" id="general_in_simple" value=""
                                                                   type="radio"/>
                                                            <input type="number" step="1"
                                                                   id="general_paypal_custom_amount"
                                                                   name="custom_amount"
                                                                   min="{{ $currency_usd->min_donate_amount }}"
                                                                   class="custom_amount"
                                                                   placeholder="Custom Amount In English">
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin: 5px 0 15px 0; padding: 0">
                                                    <textarea type="text" name="comments" id="general_g_p_comments"
                                                              class="form-control comments"
                                                              placeholder="Comments here.."></textarea>
                                                </div>
                                                <div class="payment-button">
                                                    <button type="submit"
                                                            class="btn theme-btn btn-block paypal_btn"
                                                    >
                                                        <i class="fa fa-paypal"></i> Paywith Paypal &#47; Credit Card
                                                    </button>


                                                    <label class="btn theme-btn btn-block paypal_btn_processing"
                                                           id=""><i class="fa fa-paypal" style="color:white"></i>
                                                        Paywith Paypal &#47; Credit Card <i
                                                                class="fa fa-gear fa-spin"></i></label>
                                                </div>

                                                @include('website.layouts.donate_ssl_button')


                                            </form>
                                        </div>
                                    </div>
                                    <div id="bdt-simple" class="tab-pane active">
                                        <div class="buy-wrapper">
                                            <div style="padding: 20px 35px" class="amount">
                                                <form method="POST"
                                                      role="form" action="{{url('/donation_confirmation')}}"
                                                      id="general_g_s_form" onsubmit="return validateSslProjectForm();"
                                                      target="_blank">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="project_id" class="project_id"
                                                           value="{{$project->id}}">
                                                    <input type="hidden" name="donate_way" value="2">
                                                    <input type="hidden" class="user_id" name="user_id" value="">

                                                    <div class="row">
                                                        @foreach($donation_amounts as $donation_amount)
                                                            @if($donation_amount->currency == 'BDT')
                                                                <div class="col-md-6">
                                                                    <label class="radio-inline">
                                                                        <input name="amount" checked
                                                                               value="{{$donation_amount->amount}}"
                                                                               type="radio"/><span
                                                                                class="bd-currency">৳</span>{{$donation_amount->amount}}
                                                                        ({{$donation_amount->description or null}})
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        <div class="col-md-6">
                                                            <input type="hidden" id="general_ssl_min_donate_amount"
                                                                   value="{{ $currency_bdt->min_donate_amount }}">
                                                            <label class="radio-inline" style="display: block">
                                                                <input name="amount" id="general_bd_simple"
                                                                       type="radio"/>
                                                                <input type="number" id="general_ssl_custom_amount"
                                                                       name="custom_amount"
                                                                       min="{{ $currency_bdt->min_donate_amount }}"
                                                                       class="custom_amount"
                                                                       placeholder="Custom Amount In English">
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12" style="margin: 5px 0 15px 0; padding: 0">
                                                        <textarea type="text" name="comments"
                                                                  class="form-control comments"
                                                                  placeholder="Comments here.."
                                                                  id="general_g_s_comments"></textarea>
                                                    </div>


                                                    <div class="payment-button">
                                                        <button type="submit"
                                                                class="btn theme-btn btn-block ssl_btn"
                                                        >
                                                            <i class="fa fa-money"></i> Pay with card/bKash
                                                        </button>

                                                        <label class="btn theme-btn btn-block ssl_btn_processing" id=""><i
                                                                    class="fa fa-money"></i> Paywith card/bKash <i
                                                                    class="fa fa-gear fa-spin"></i></label>

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
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end about-details -->


    <!-- start event-single-main-content -->
    <section class="event-single-main-content" style="padding-bottom: 40px">
        <div class="container">
            <div style="padding: 0" class="row about-event-wrapper">
                <div style="margin-left: 0" class="col col-lg-12">
                    <div class="row">
                        @if(request()->cookie('locale')=='bn')
                            <div class="col col-md-4">
                                <div class="sidebar">
                                    <div style="margin-top: 50px" class="event-info">
                                        <ul>
                                            <li>
                                                <i class="fi flaticon-valentines-day-on-the-calendar"></i> {{ $project->project_type->bn_name or null}}
                                            </li>
                                            @if(!empty($project->bn_location))
                                                <li>
                                                    <i class="fi flaticon-facebook-placeholder-for-locate-places-on-maps"></i> {{ $project->bn_location or null}}
                                                </li>
                                            @endif
                                        <!-- <li><i class="fi flaticon-clock"></i> For Human</li> -->

                                            @if(!empty($project->bn_objective))
                                                <li>
                                                    <i class="fi flaticon-profile"></i> {{ $project->bn_objective or null}}
                                                </li>
                                            @endif

                                            @if(!empty($project->bn_achievement))
                                                <li><i class="fa fa-fax"></i> {{ $project->bn_achievement or null}}</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col col-md-8">
                                <div class="about-event">
                                    <input type="hidden" id="project-id-{{$project->id}}"
                                           value="{{$project->id}}">
                                    <input type="hidden" id="modal-img-{{$project->id}}"
                                           value="{{$project->project_image}}">
                                    <input type="hidden" id="project-name-{{$project->id}}"
                                           value="{{$project->name}}">
                                    <h2>{{ $project->bn_name or null}}</h2>
                                    <a href="#" class="btn theme-btn donate-project" data-toggle="modal"
                                       data-target="#donate-project-modal">@lang('messages.Donate now')</a>
                                    <div class="content">
                                       {{-- <p>{{ $project->bn_description or null}}</p>--}}
                                        <pre class="p-style">{{ $project->bn_description or null}}</pre>
                                    <!-- <div class="para-with-img">
                                    <p>Ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui do lorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius.</p>
                                    <span>
                                        <img src="{{asset('site-assets/images/event-single/img-1.jpg')}}" alt class="img img-responsive">
                                    </span>
                                </div> -->

                                    </div>
                                    <div class="join">
                                        <input type="hidden" id="project-id-{{$project->id}}"
                                               value="{{$project->id}}">
                                        <input type="hidden" id="modal-img-{{$project->id}}"
                                               value="{{$project->project_image}}">
                                        <input type="hidden" id="project-name-{{$project->id}}"
                                               value="{{$project->name}}">
                                    </div>
                                    <div class="sharethis-inline-share-buttons"></div>
                                    {{--<div class="social">
                                        <ul>
                                            <li><a id="fbShare" href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a id="twitterShare" href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a id="gPlusShare" href="#"><i class="fa fa-google-plus"></i></a></li>
                                            <li><a id="linkedInShare" href="#"><i class="fa fa-linkedin"></i></a></li>
                                        </ul>
                                    </div>--}}
                                </div>

                                <!-- <div class="other-events">
                                    <a href="#" class="btn"><i class="fa fa-angle-left"></i> Peve event</a>
                                    <a href="#" class="btn">Next event <i class="fa fa-angle-right"></i></a>
                                </div> -->
                            </div>
                        @else
                            <div class="col col-md-4">
                                <div class="sidebar">
                                    <div style="margin-top: 50px" class="event-info">
                                        <ul>
                                            <li>
                                                <i class="fi flaticon-valentines-day-on-the-calendar"></i> {{ $project->project_type->name or null}}
                                            </li>
                                            @if(!empty($project->location))
                                                <li>
                                                    <i class="fi flaticon-facebook-placeholder-for-locate-places-on-maps"></i> {{ $project->location or null}}
                                                </li>
                                            @endif
                                            @if(!empty($project->supervisor_name))
                                                <li>
                                                    <i class="fi flaticon-profile"></i> {{ $project->supervisor_name or null}}
                                                </li>
                                            @endif

                                            @if(!empty($project->supervisor_contact_no))
                                                <li>
                                                    <i class="fa fa-fax"></i> {{ $project->supervisor_contact_no or null}}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col col-md-8">
                                <div class="about-event">
                                    <input type="hidden" id="project-id-{{$project->id}}"
                                           value="{{$project->id}}">
                                    <input type="hidden" id="modal-img-{{$project->id}}"
                                           value="{{$project->project_image}}">
                                    <input type="hidden" id="project-name-{{$project->id}}"
                                           value="{{$project->name}}">
                                    <h2>{{ $project->name or null}}</h2>
                                    <a href="#" class="btn theme-btn donate-project" data-toggle="modal"
                                       data-target="#donate-project-modal">@lang('messages.Donate now')</a>
                                    <div class="content">
                                        {{--<p>{{ $project->description or null}}</p>--}}
                                        <pre class="p-style">{{ $project->description or null}}</pre>
                                    </div>
                                    <div class="join">
                                        <input type="hidden" id="project-id-{{$project->id}}"
                                               value="{{$project->id}}">
                                        <input type="hidden" id="modal-img-{{$project->id}}"
                                               value="{{$project->project_image}}">
                                        <input type="hidden" id="project-name-{{$project->id}}"
                                               value="{{$project->name}}">
                                    </div>
                                    <div class="sharethis-inline-share-buttons"></div>
                                </div>
                            </div>
                        @endif
                    </div> <!-- end row -->
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->

        <!-- end sopnsor -->
    </section>
    <!-- end event-single-main-content -->

@endsection

@push('style')
<link href="{{asset('site-assets/css/jquery.fancybox.css')}}" rel="stylesheet">
<style>
    #donate .nav-tabs.nav-justified>li>a {
        background-color: #eee;
    }

    #donate .nav-tabs.nav-justified>li.active>a {
        background-color: transparent;
    }



</style>
@endpush

@push('scripts')
<script>

</script>

@endpush