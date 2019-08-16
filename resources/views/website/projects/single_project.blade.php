@extends('website.layouts.app')

@section('main-content')
    <!-- start about-details -->
    <section style="padding: 125px 0 35px 0; background: none" class="about-us-st" id="donate">
        <div class="container">
            <!-- <h2><span>About</span> us</h2> -->
            <div class="row flex-div">
                <div style="padding: 0;   background: url('{{asset($project->project_big_image)}}'); background-repeat: no-repeat; background-position: center; background-size: cover"
                     class="col col-md-4 col-xs-12 wow fadeInRightSlow">
                    <div class="right-col" style=" ">
                        <div class="video">
                            {{-- <img style="min-height: 412px" src="{{asset($project->project_big_image)}}" alt=""
                                  class="img img-responsive">--}}
                            <img style="min-height: 412px" src="{{asset('site-assets/images/blank.png')}}" alt=""
                                 class="img img-responsive">
                            <a href="{{$project->video_link}}?autoplay=1" class="video-btn" data-type="iframe"><i
                                        class="fa fa-play"></i></a>
                        </div>
                    </div>
                </div>
                <div style="padding: 0; " class="col col-md-8 col-xs-12 wow fadeInLeftSlow">
                    <div class="left-col">
                        <div class="donate-client">
                            <div id="account-tab">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active">
                                        <a class="nav-link" data-toggle="tab" href="#bdt-single_project">
                                            ৳ @lang('messages.BDT')
                                        </a>
                                    </li>

                                    <li>
                                        <a data-toggle="tab" href="#usd-single_project">
                                            <i class="fa fa-usd"></i> @lang('messages.USD')
                                        </a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
<div class="tab-content" id="general_payment">
    <div id="usd-single_project" class="tab-pane fade">
        <div style="padding: 20px 35px" class="amount">
            <form method="POST"
                  role="form" action="{{url('/pay_with_paypal')}}"
                  onsubmit="return validatePaypalProjectForm();" target="_blank">
                {{ csrf_field() }}
                <input type="hidden" name="project_id" class="project_id"
                       value="{{$project->id}}">
                <input type="hidden" name="donate_way" value="2">
                <input type="hidden" class="user_id" name="user_id" value="">

                <div class="row option-wrapper-in">
                    @foreach($donation_amounts as $donation_amount)
                        <div class="col-md-{{$donation_amount->column}}">
                            <label class="radio-inline">
                                <input name="amount" checked
                                       value="{{ceil($donation_amount->amount/$currency_usd->tk_convert_amount)}}"
                                       type="radio" class="usd_radio_project_form"  onclick="usd_project_form_load()"/><span
                                        class="in-currency">$</span> {{number_format(ceil($donation_amount->amount/$currency_usd->tk_convert_amount))}}
                                ({{$donation_amount->description or null}})
                            </label>
                        </div>
                    @endforeach

                    <div class="col-md-6">
                        <label class="radio-inline" style="display: block">
                            <input name="amount" id="custom_usd_r_project_form" value="{{$currency_usd->min_donate_amount }}"
                               type="radio" onclick="custom_usd_project_form_load({{$currency_usd->min_donate_amount }})" />
                            <input type="number" step="1" id="custom_usd_project_form"
                               name="custom_amount"
                               min="{{ $currency_usd->min_donate_amount }}"
                               max="{{ $currency_usd->max_donate_amount }}"
                               class="custom_amount" placeholder="@lang('messages.Custom Amount')"onkeyup="custom_amount_check(this)" onchange="custom_amount_check(this)">
                        </label>
                    </div>
                </div>

                <div class="col-md-12" style="margin: 5px 0 15px 0; padding: 0">
                    <textarea type="text" name="comments"
                              class="form-control comments"
                              placeholder="@lang('messages.Comments here')"></textarea>
                </div>
                <div class="payment-button">
                    <button type="submit"
                            class="btn theme-btn btn-block paypal_btn"
                    >
                        <i class="fa fa-paypal"></i> @lang('messages.Paywith Paypal') &#47; @lang('messages.Credit Card')
                    </button>
                </div>

                @include('website.layouts.donate_ssl_button')


            </form>
        </div>
    </div>
    <div id="bdt-single_project" class="tab-pane active">
        <div class="buy-wrapper">
            <div style="padding: 20px 35px" class="amount">
                <form method="POST"
                      role="form" action="{{url('/donation_confirmation')}}" onsubmit="return validateSslProjectForm();"
                      target="_blank">
                    {{ csrf_field() }}
                    <input type="hidden" name="project_id" class="project_id"
                           value="{{$project->id}}">
                    <input type="hidden" name="donate_way" value="2">
                    <input type="hidden" class="user_id" name="user_id" value="">

                    <div class="row option-wrapper-bd">
                        @foreach($donation_amounts as $donation_amount)
                            <div class="col-md-6">
                                <label class="radio-inline">
                                    <input name="amount" checked
                                           value="{{$donation_amount->amount}}"
                                           type="radio" class="bdt_radio_project_form"  onclick="bdt_project_form_load()"/><span
                                            class="bd-currency">৳</span> {{\App\Helpers\CommonHelper::bd_money_format_wod($donation_amount->amount)}}
                                    ({{$donation_amount->description or null}})
                                </label>
                            </div>
                        @endforeach
                        <div class="col-md-6">
                            <label class="radio-inline" style="display: block">
                                <input name="amount" id="custom_bdt_r_project_form" value="{{$currency_bdt->min_donate_amount }}"
                                   type="radio" onclick="custom_bdt_project_form_load({{$currency_bdt->min_donate_amount }})" />
                                <input type="number" step="1" id="custom_bdt_project_form"
                                   name="custom_amount"
                                   min="{{ $currency_bdt->min_donate_amount }}"
                                   max="{{ $currency_bdt->max_donate_amount }}"
                                   class="custom_amount" placeholder="@lang('messages.Custom Amount')" onkeyup="custom_amount_check(this)" onchange="custom_amount_check(this)">
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12" style="margin: 5px 0 15px 0; padding: 0">
                        <textarea type="text" name="comments"
                                  class="form-control comments"
                                  placeholder="@lang('messages.Comments here')"></textarea>
                    </div>


                    <div class="payment-button">
                        <button type="submit"
                                class="btn theme-btn btn-block ssl_btn"
                        >
                            <i class="fa fa-money"></i> @lang('messages.Pay with card/bKash')
                        </button>
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

                        <div class="col col-md-4">
                            <div class="sidebar">
                                <div class="event-info">
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
                    </div> <!-- end row -->
                    {{--Start Image showcase--}}
                    <div class="row gallery">
                        <hr class="gallery-line">
                        <h2 class="gallery-title">@lang('messages.Our Latest')<span> @lang('messages.Activities')</span>
                        </h2>
                        <div class="demo-gallery">
                            <ul id="lightgallery" class="list-unstyled row">
                                @include('website.projects.data')
                            </ul>
                        </div>
                        <div id="last-count">
                            <input type='hidden' id='detectLastPage' value='0'>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="not-found-message"></div>
                        </div>
                    </div>
                    {{--end Image showcase--}}
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
        <!-- end sopnsor -->
        <!-- end event-single-main-content -->
        <div class="ajax-load text-center" style="display:none">
            <p><img src="{{asset('site-assets/images/loading.gif')}}"></p>
        </div>
    </section>
    <!-- start newsletter -->
    <section class="newsletter" id="single-project-footer-donate">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-md-12">
                    <div class="subscribe">
                        <input type="hidden" id="project-id-{{$project->id}}"
                               value="{{$project->id}}">
                        <h4>{{$project->donation_title or null}}</h4>
                        <a href="#" class="btn theme-btn donate-project" data-toggle="modal"
                           data-target="#donate-project-modal">@lang('messages.Donate now')</a>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container-fluid -->
    </section>
    <!-- end newsletter -->

@endsection

@push('style')
<link href="{{asset('site-assets/css/jquery.fancybox.css')}}" rel="stylesheet">
<link href="{{asset('site-assets/css/lightgallery.min.css')}}" rel="stylesheet">
<style>
    #donate .nav-tabs.nav-justified > li > a {
        background-color: #eee;
    }

    #donate .nav-tabs.nav-justified > li.active > a {
        background-color: transparent;
    }


</style>
@endpush

@push('scripts')
<script src='{{asset('site-assets/js/lightgallery-all.min.js')}}'></script>
<script>
    $(document).ready(function () {
        $("#lightgallery").lightGallery();
    });

    /*new way try start*/
    galleryList();
    function galleryList() {
        var page = 1;
        var checkLastPage = $('#detectLastPage').val();
        $(window).scroll(function () {
            var checkLastPage = $('#detectLastPage').val();
            if (checkLastPage !== '1') {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 500) {
                    page++;
                    loadMoreData(page);
                }
            }
        });
    }

    function loadMoreData(page) {
        $.ajax(
            {

                url: '?page=' + page,
                type: "get",
                beforeSend: function () {
                    $('.ajax-load').show();

                }
            })
            .done(function (data) {
                if (data.html == "") {
                    $('#detectLastPage').val('1');
                }
                $('.ajax-load').hide();
                $("#lightgallery").append(data.html);
                loadJs();
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                //alert('server not responding...');
            });
    }

    function loadJs() {
        $("#lightgallery").data('lightGallery').destroy(true);
        $("#lightgallery").lightGallery();
    }


    //...........project donate form donation start...........
    function custom_bdt_project_form_load(min_amount)
    {
        $("#custom_bdt_project_form").attr("placeholder", "<?php echo Lang::get('messages.Minimum donation amount is')?> "+min_amount+ " <?php echo Lang::get('messages.Taka')?>");
        $(".bdt_radio_project_form").removeAttr('checked');
    }
    function bdt_project_form_load()
    {
        $("#custom_bdt_project_form").val('');
        $("#custom_bdt_r_project_form").removeAttr('checked');
    }
    function custom_usd_project_form_load(min_amount)
    {
        $("#custom_usd_project_form").attr("placeholder", "<?php echo Lang::get('messages.Minimum donation amount is')?> "+min_amount+ " <?php echo Lang::get('messages.Dollar')?>");
        $(".usd_radio_project_form").removeAttr('checked');
    }
    function usd_project_form_load()
    {
        $("#custom_usd_project_form").val('');
        $("#custom_usd_r_project_form").removeAttr('checked');
    }
    //...........project donate form donation end...........

    /*new way try end*/
</script>

@endpush