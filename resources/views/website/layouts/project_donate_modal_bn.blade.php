<!-- Project Modal start-->
<div class="modal fade donate-modal" id="donate-project-modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content scholarship-modal">
            <!--Common modal header-->
            @include('website.layouts.common_modal_header')

            <div class="modal-body">
                <div class="modal-padding-md">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="donate-client">
                                    <div id="project-account-tab">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-justified">
                                            <li class="active">
                                                <a class="project nav-link" data-toggle="tab" href="#project-bdt">
                                                    <span>৳</span>
                                                    @lang('messages.BDT')
                                                </a>
                                            </li>

                                            <li>
                                                <a class="project nav-link" data-toggle="tab" href="#project-usd">
                                                    <i class="fa fa-usd"></i>
                                                    @lang('messages.USD')
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div id="project-usd" class="tab-pane fade">
                                                <div class="amount">
                                                    <form method="POST"
                                                          role="form" action="{{url('/pay_with_paypal')}}"
                                                          onsubmit="return validatePaypalProjectForm();" id="p_p_form"
                                                          target="_blank">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="project_id" class="project_id">
                                                        <input type="hidden" name="donate_way" value="2">
                                                        <input type="hidden" class="user_id" name="user_id" value="">

                                                        <div class="row option-wrapper-in">
                                                            <div id="project-payment-option-in"></div>
                                                            <div class="loading">
                                                                <label><i class="fa fa-spinner fa-5x fa-spin" aria-hidden="true"></i></label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12" style="margin: 5px 0 15px 0; padding: 0">
                        <textarea type="text" name="comments"
                                  class="form-control comments"
                                  placeholder="@lang('messages.Comments here')"
                                  id="p_p_comments"></textarea>
                                                        </div>
                                                        <div class="payment-button">
                                                            <button type="submit"
                                                                    class="btn theme-btn btn-block paypal_btn">
                                                                <i class="fa fa-paypal" style="color: #fff"
                                                                   aria-hidden="true"></i>
                                                                @lang('messages.Paywith Paypal')
                                                            </button>
                                                        </div>

                                                        @include('website.layouts.donate_ssl_button')
                                                    </form>
                                                </div>
                                            </div>
                                            <div id="project-bdt" class="tab-pane active">
                                                <div class="buy-wrapper">
                                                    <div class="amount">
                                                        <form method="POST"
                                                              role="form" action="{{url('/donation_confirmation')}}"
                                                              onsubmit="return validateSslProjectForm();" id="p_s_form"
                                                              target="_blank">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="project_id" class="project_id">
                                                            <input type="hidden" name="donate_way" value="2">
                                                            <input type="hidden" class="user_id" name="user_id"
                                                                   value="">

                                                            <div class="row option-wrapper-bd">
                                                                <div id="project-payment-option-bd"></div>
                                                            </div>
                                                            <div class="loading">
                                                                <label><i class="fa fa-spinner fa-5x fa-spin" aria-hidden="true"></i></label>
                                                            </div>

                                                            <div class="col-md-12"
                                                                 style="margin: 5px 0 15px 0; padding: 0">
                            <textarea type="text" name="comments"
                                      class="form-control comments"
                                      placeholder="@lang('messages.Comments here')"
                                      id="p_s_comments"></textarea>
                                                            </div>


                                                            <div class="payment-button">
                                                                <button type="submit"
                                                                        class="btn theme-btn btn-block ssl_btn">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Project Modal end-->

<!-- donate-simple Modal start-->
<div class="modal fade donate-modal" id="donate-simple-modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content scholarship-modal">
            <!--Common modal-->
            @include('website.layouts.common_modal_header')

            {{--Modal body start--}}
            <div class="modal-body">
                <div class="modal-padding-md">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="donate-client">
                                    <div id="account-tab">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-justified">
                                            <li class="active">
                                                <a class="nav-link" data-toggle="tab" href="#bdt-simple">
                                                    <span>৳</span>
                                                    @lang('messages.BDT')
                                                </a>
                                            </li>

                                            <li>
                                                <a data-toggle="tab" href="#usd-simple">
                                                    <i class="fa fa-usd"></i>
                                                    @lang('messages.USD')
                                                </a>
                                            </li>
                                        </ul>
                                    <?php $donation_amounts = \App\Models\Donation_Amount::where('general_donation', 1)
                                        ->get(['amount', 'currency', 'description', 'column', 'bn_description']);?>
                                    <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div id="usd-simple" class="tab-pane fade">
                                                <div class="amount">
                                                    <form method="POST"
                                                          role="form" action="{{url('/pay_with_paypal')}}" id="g_p_form"
                                                          onsubmit="return validatePaypalGeneralForm();"
                                                          target="_blank">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="donate_way" value="1">
                                                        <input type="hidden" class="user_id" name="user_id" value="">

                                                        <div class="row option-wrapper-in">
                                                            @foreach($donation_amounts as $donation_amount)
                <div class="col-md-{{$donation_amount->column}}">
                    <label class="radio-inline">
                        <input name="amount" checked
                               value="{{ceil($donation_amount->amount/$currency_usd->tk_convert_amount)}}"
                               type="radio" class="usd_radio_general"  onclick="usd_general_load()"/><span
                                class="in-currency">USD</span> {{\App\Helpers\CommonHelper::en2bnNumber(number_format(ceil($donation_amount->amount/$currency_usd->tk_convert_amount)))}} {{$donation_amount->bn_description or null}}

                    </label>
                </div>
                                                            @endforeach


                <div class="col-md-6">
                    <label class="radio-inline" style="display: block">
                        <input name="amount" id="custom_usd_r_general" value="{{$currency_usd->min_donate_amount }}"
                               type="radio" onclick="custom_usd_general_load({{$currency_usd->min_donate_amount }})" />
                        <input type="number" step="1" id="custom_usd_general"
                               name="custom_amount"
                               min="{{ $currency_usd->min_donate_amount }}"
                               max="{{ $currency_usd->max_donate_amount }}"
                               class="custom_amount" placeholder="@lang('messages.Custom Amount')"onkeyup="custom_amount_check(this)" onchange="custom_amount_check(this)">
                    </label>
                </div>


                                                        </div>

                                                        <div class="col-md-12" style="margin: 5px 0 15px 0; padding: 0">
                                                            <textarea type="text" name="comments" id="g_p_comments"
                                                                      class="form-control comments"
                                                                      placeholder="@lang('messages.Comments here')"></textarea>
                                                        </div>
                                                        <div class="payment-button">
                                                            <button type="submit"
                                                                    class="btn theme-btn btn-block paypal_btn">
                                                                <i class="fa fa-paypal"> </i> @lang('messages.Paywith Paypal')
                                                            </button>
                                                        </div>

                                                        @include('website.layouts.donate_ssl_button')


                                                    </form>
                                                </div>
                                            </div>
                                            <div id="bdt-simple" class="tab-pane active">
                                                <div class="buy-wrapper">
                                                    <div class="amount">
                                                        <form method="POST"
                                                              role="form" action="{{url('/donation_confirmation')}}"
                                                              id="g_s_form" onsubmit="return validateSslGeneralForm();"
                                                              target="_blank">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="donate_way" value="1">
                                                            <input type="hidden" class="user_id" name="user_id"
                                                                   value="">

                                                            <div class="row option-wrapper-bd">
                                                                {{--For english--}}
                                                                @foreach($donation_amounts as $donation_amount)
                        <div class="col-md-6">
                            <label class="radio-inline">
                                <input name="amount" checked
                                       value="{{$donation_amount->amount}}"
                                       type="radio"  class="bdt_radio_general"  onclick="bdt_general_load()"/><span
                                        class="bd-currency">৳</span> {{\App\Helpers\CommonHelper::en2bnNumber(\App\Helpers\CommonHelper::bd_money_format_wod($donation_amount->amount))}} {{$donation_amount->bn_description or null}}
                            </label>
                        </div>
                                                                @endforeach

                        <div class="col-md-6">
                            <label class="radio-inline" style="display: block">
                                <input name="amount" id="custom_bdt_r_general" value="{{ $currency_bdt->min_donate_amount }}" type="radio" onclick="custom_bdt_general_load({{ $currency_bdt->min_donate_amount }})" />
                                <input type="number" id="custom_bdt_general"
                                       name="custom_amount"
                                       min="{{ $currency_bdt->min_donate_amount }}"
                                       max="{{ $currency_bdt->max_donate_amount }}"
                                       class="custom_amount"
                                       placeholder="@lang('messages.Custom Amount')" onkeyup="custom_amount_check(this)" onchange="custom_amount_check(this)">
                            </label>
                        </div>

                                                            </div>

                                                            <div class="col-md-12"
                                                                 style="margin: 5px 0 15px 0; padding: 0">
                                                                <textarea type="text" name="comments"
                                                                          class="form-control comments"
                                                                          placeholder="@lang('messages.Comments here')"
                                                                          id="g_s_comments"></textarea>
                                                            </div>


                                                            <div class="payment-button">
                                                                <button type="submit"
                                                                        class="btn theme-btn btn-block ssl_btn"
                                                                >
                                                                    <i class="fa fa-money"></i>@lang('messages.Pay with card/bKash')
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--Modal body end--}}


        </div>
    </div>
</div>
<!-- Project Modal end-->

@push('scripts')
<script>
    $(document).ready(function () {
        /*Donate button onclick*/
        $('.donate-project').on('click', function (e) {
            var currency = $('#project-account-tab .active>.nav-link').attr('href');
            var project_id = $('.project_id').val();
            if (currency === '#project-bdt') {
                $('#project-payment-option-bd').empty();
                $.ajax({
                    url: "{{url('get-project-amount')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: project_id,
                        currency: 'BDT'
                    },
                    beforeSend: function(){
                        $(".loading").show();
                    },
                    complete: function(){
                        $(".loading").hide();
                    },
                    success: function (response) {
                        $('#p_s_comments').val('');
                        //$('#project-payment-option-bd').empty();
                        $('#project-payment-option-bd').html(response);
                    }
                });
            } else {
                $('#project-payment-option-in').empty();
                $.ajax({
                    url: "{{url('get-project-amount')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: project_id,
                        currency: 'USD'
                    },
                    beforeSend: function(){
                        $(".loading").show();
                    },
                    complete: function(){
                        $(".loading").hide();
                    },
                    success: function (response) {
                        $('#p_p_comments').val('');
                        //$('#project-payment-option-in').empty();
                        $('#project-payment-option-in').html(response);
                    }
                });
            }
        });
        /*Donation amount load using ajax*/
        $('.project.nav-link').on('click', function (e) {
            var currency = $(this).attr('href');
            var project_id = $('.project_id').val();
            if (currency === '#project-bdt') {
                $('#project-payment-option-bd').empty();
                $.ajax({
                    url: "{{url('get-project-amount')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: project_id,
                        currency: 'BDT'
                    },
                    beforeSend: function(){
                        $(".loading").show();
                    },
                    complete: function(){
                        $(".loading").hide();
                    },
                    success: function (response) {
                        $('#p_s_comments').val('');
                        //$('#project-payment-option-bd').empty();
                        $('#project-payment-option-bd').html(response);
                    }
                });
            } else {
                $('#project-payment-option-in').empty();
                $.ajax({
                    url: "{{url('get-project-amount')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: project_id,
                        currency: 'USD'
                    },
                    beforeSend: function(){
                        $(".loading").show();
                    },
                    complete: function(){
                        $(".loading").hide();
                    },
                    success: function (response) {
                        $('#p_p_comments').val('');
                        //$('#project-payment-option-in').empty();
                        $('#project-payment-option-in').html(response);
                    }
                });
            }

        });
    });

    //...........general donate pop up start...........
    function custom_amount_check(a)
    {
        var rid = a.previousElementSibling.id;
        $('#' + rid).prop("checked", true);
    }
    function custom_bdt_general_load(min_amount)
    {
        $("#custom_bdt_general").attr("placeholder", "<?php echo Lang::get('messages.Minimum donation amount is').' '. \App\Helpers\CommonHelper::en2bnNumber($currency_bdt->min_donate_amount).' '. Lang::get('messages.Taka')?>");
        $(".bdt_radio_general").removeAttr('checked');
    }
    function bdt_general_load()
    {
        $("#custom_bdt_general").val('');
        $("#custom_bdt_r_general").removeAttr('checked');
    }
    function custom_usd_general_load(min_amount)
    {
        $("#custom_usd_general").attr("placeholder", "<?php echo Lang::get('messages.Minimum donation amount is').' '. \App\Helpers\CommonHelper::en2bnNumber($currency_usd->min_donate_amount).' '. Lang::get('messages.Dollar')?>");
        $(".usd_radio_general").removeAttr('checked');
    }
    function usd_general_load()
    {
        $("#custom_usd_general").val('');
        $("#custom_usd_r_general").removeAttr('checked');
    }
    //...........general donate pop up end...........


    //...........project donate pop up start...........
    function custom_bdt_project_load(min_amount)
    {
        $("#custom_bdt_project").attr("placeholder", "<?php echo Lang::get('messages.Minimum donation amount is').' '. \App\Helpers\CommonHelper::en2bnNumber($currency_bdt->min_donate_amount).' '. Lang::get('messages.Taka')?>");
        $(".bdt_radio_project").removeAttr('checked');
    }
    function bdt_project_load()
    {
        $("#custom_bdt_project").val('');
        $("#custom_bdt_r_project").removeAttr('checked');
    }
    function custom_usd_project_load(min_amount)
    {
        $("#custom_usd_project").attr("placeholder", "<?php echo Lang::get('messages.Minimum donation amount is').' '. \App\Helpers\CommonHelper::en2bnNumber($currency_usd->min_donate_amount).' '. Lang::get('messages.Dollar')?>");
        $(".usd_radio_project").removeAttr('checked');
    }
    function usd_project_load()
    {
        $("#custom_usd_project").val('');
        $("#custom_usd_r_project").removeAttr('checked');
    }
    //...........project donate pop up end...........

</script>

@endpush