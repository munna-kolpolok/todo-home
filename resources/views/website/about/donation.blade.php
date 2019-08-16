@extends('website.layouts.app')


@section('main-content')
    <?php
    $bkash_options='';
    $rocket_options='';
    $paypal_options='';
    $bank_options='';
    ?>
    <div class="page-wrapper contact-page" id="donation-page"
         style="background-image:  url('{{asset($setting->donation_form_bg_image)}}')!important; background-repeat: no-repeat; background-position: center center;background-size: cover; background-attachment: fixed;">
        <!-- start contact-main-content -->
        <section class="contact-main-content section-padding">

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
                <div class="row wow fadeInppSlow row-centered">
                    <div class="col-md-8 py-5 col-centered">
                        <div id="donation-form">
                            <h4 class="pb-4">@lang('messages.Donation Clarification Form')</h4>
                            <hr style=" border: 1px solid lightgray; margin:0 15px 15px;">
                            {!! Form::open(['url' => 'donation/store','files'=>true,'id'=>'verification_form']) !!}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <p class="lable" style="">@lang("messages.amount")
                                        <span>*</span></p>
                                    <input type="number" required min="1"
                                           class="form-control add-amount" name="amount" id="amount"
                                           placeholder="@lang("messages.Enter Amount In English")"
                                           value="{{ old('amount') }}" max="10000000">
                                </div>
                                <div class="form-group col-md-6">
                                     <p class="lable" style="">@lang("messages.currency")
                                        <span>*</span></p>
                                    <select class="form-control select2" name="currency_id"
                                            id="currency_id" required>
                                        @foreach($currency_lists as $currency_list)
                                            <option value="{{ $currency_list->id }}"
                                                    @if(old('currency_id')==$currency_list->id) selected @elseif($currency_list->id=='2') selected @endif>{{ $currency_list->currency_name }}
                                                ({{ $currency_list->currency_code }})
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <p class="lable" style="">@lang("messages.Email")
                                        <span>*</span></p>
                                    <input type="email" class="form-control" name="donor_email"
                                           placeholder="@lang('messages.Enter Your Email')" required
                                           value="{{ old('donor_email') }}">

                                </div>
                                <div class="form-group col-md-6">
                                    <p class="lable" style="">@lang("messages.Date")
                                        <span>*</span></p>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='text' class="form-control" name="date" id="date"
                                               placeholder="@lang('messages.Enter Date')" required="1"
                                               value="{{ App\Helpers\CommonHelper::showDateFormat(date('Y-m-d')) }}"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                    </div>
                                </div>
                            </div>

                            @if(request()->cookie('locale')=='bn')
                                <?php
                                foreach($accounts as $account){ 
                                    if($account->type=='Paypal')
                                    {
                                        $paypal_options.='<option value="'.$account->name.'">'.$account->bn_name.'</option>';
                                    }
                                    elseif($account->type=='Bank')
                                    {
                                        $bank_options.='<option value="'.$account->name.'">'.$account->bn_name.'</option>';
                                    }
                                    elseif($account->type=='Bkash')
                                    {
                                        $bkash_options.='<option value="'.$account->name.'">'.$account->bn_name.'</option>';
                                    }
                                    elseif($account->type=='Rocket')
                                    {
                                        $rocket_options.='<option value="'.$account->name.'">'.$account->bn_name.'</option>';
                                    }
                                        
                                }
                                ?>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                         <p class="lable" style="">@lang("messages.Donation Reason")
                                        <span>*</span></p>
                                        <select class="form-control select2" name="sector_id"
                                                id="sector_id" required>
                                            @foreach($sectors as $sector)
                                                <option value="{{ $sector->id }}"
                                                        @if(old('sector_id')==$sector->id) selected @endif>{{ $sector->bn_name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="form-group col-md-6">
                                         <p class="lable" style="">@lang("messages.Payment Channel")
                                        <span>*</span></p>
                                        <select class="form-control select2" name="payment_method_id"
                                                id="payment_method_id" required
                                                onchange="account_hide(this.value)">
                                            @foreach($payment_methods as $payment_method)
                                                <option value="{{ $payment_method->id }}" @if($payment_method->id=='5') selected @endif>{{ $payment_method->bn_name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            @else
                                <?php
                                foreach($accounts as $account){ 
                                    if($account->type=='Paypal')
                                    {
                                        $paypal_options.='<option value="'.$account->name.'">'.$account->name.'</option>';
                                    }
                                    elseif($account->type=='Bank')
                                    {
                                        $bank_options.='<option value="'.$account->name.'">'.$account->name.'</option>';
                                    }
                                    elseif($account->type=='Bkash')
                                    {
                                        $bkash_options.='<option value="'.$account->name.'">'.$account->name.'</option>';
                                    }
                                    elseif($account->type=='Rocket')
                                    {
                                        $rocket_options.='<option value="'.$account->name.'">'.$account->name.'</option>';
                                    }
                                        
                                }
                                ?>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                         <p class="lable" style="">@lang("messages.Donation Reason")
                                        <span>*</span></p>
                                        <select class="form-control select2" name="sector_id"
                                                id="sector_id" required>
                                            @foreach($sectors as $sector)
                                                <option value="{{ $sector->id }}"
                                                        @if(old('sector_id')==$sector->id) selected @endif>{{ $sector->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="form-group col-md-6">
                                         <p class="lable" style="">@lang("messages.Payment Channel")
                                        <span>*</span></p>
                                        <select class="form-control select2" name="payment_method_id"
                                                id="payment_method_id" required
                                                onchange="account_hide(this.value)">
                                            @foreach($payment_methods as $payment_method)
                                                <option value="{{ $payment_method->id }}" @if($payment_method->id=='5') selected @endif>{{ $payment_method->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            @endif

                            <div class="form-row account_div">
                                <div class="form-group col-md-6">
                                     <p class="lable"  id="l_payee_account_no">@lang("messages.Recipient Bkash No")
                                        <span>*</span></p>
                                    <select class="form-control select2" name="payee_account_no" id="payee_account_no_r">
                                        {!! $bkash_options !!}
                                    </select>

                                </div>

                                <div class="form-group col-md-6" id="payer_account_no_div">
                                     <p class="lable" id="l_payer_account_no">@lang("messages.Donor Bkash No")
                                        <span>*</span></p>
                                    <input type="text" class="form-control" name="payer_account_no" id="payer_account_no" 
                                           placeholder="@lang('messages.Enter Your Bkash No')"
                                           required value="{{ old('payer_account_no') }}">

                                </div>
                                
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                     <p class="lable" style="">@lang("messages.Name")
                                        </p>
                                    <input type="text" class="form-control" name="donor_name"
                                           id="donor_name" placeholder="@lang('messages.Enter Your Name')"
                                           value="{{ old('donor_name') }}">
                                </div>
                                <div class="form-group col-md-6">
                                     <p class="lable" style="">@lang("messages.Attachment")
                                        
                                    </p>
                                    <input type="file" id="attachment" class="form-control"
                                           name="attachment">
                                           <!-- <span class="suggestion_text" style="">
                                                <i class="fa fa-hand-o-right" aria-hidden="true">
                                                 </i> Max file size: 1 MB
                                        </span> -->

                                    <span  style="color:#ceea74; font-size: 13px; width: auto; float: left; " ><i class="fa fa-hand-o-right" aria-hidden="true">
                                                 </i> @lang("messages.inbox_file_suggestion")
                                        </span>

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                     <p class="lable" style="">@lang("messages.Message")
                                        </p>
                                <textarea class="form-control" name="donor_message" id="donor_message"
                                          placeholder="@lang("messages.Enter Your Message")">{{ old('donor_message') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                @if(env('GOOGLE_RECAPTCHA_KEY'))
                                    <div class="g-recaptcha"
                                         data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                                @endif
                                <div style="margin-top: 10px" class="submit-button">
                                    <a href="#" id="save_button" onclick="add_verifcation()"
                                       class="bnt theme-btn btn-block">@lang('messages.Send')</a>
                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
                    <br><br>
            </div>
            <!-- end container -->

        </section>
        <!-- end contact-main-content -->
    </div>

@endsection

@push('style')
<link href="{{ asset('la-assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ asset('jquery-confirm-v3.2.0/css/jquery-confirm.min.css') }}">

<style>
    .lable {
        color: white;
        text-align: left;
        font-weight: 600;
        margin-bottom: 0;
        line-height: 20px;
    }

    .lable span {
        color: red;
    }
    #donation-form{
        height: auto!important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        text-align: left;
    }

    a {
        color: white;
    }

    .text_lable {
        background-color: rgba(184, 184, 184, 0.64);
        color: white;
        border-color: lightgray;
    }

    .form-tiltle, .tab-title {
        background-color: rgba(0, 0, 0, .5);
    }

    [class^='select2'] {
        border-radius: 0px !important;
    }

    .select2-container .select2-selection--single {
        height: 34px;
    }

    #donation-form .form-row .col-md-6,
    #donation-form .form-row .col-md-4,
    #donation-form .form-row .col-md-12 {
        position: relative;
    }

    #donation-form .form-row .col-md-6 span.required,
    #donation-form .form-row .col-md-4 span.required,
    #donation-form .form-row .col-md-2 span.required,
    #donation-form .form-row .col-md-12 span.required {
        position: absolute;
        top: 9%;
        right: 0px;
        font-size: 30px;
        color: #ed3237;
    }

    #donation-form .form-row .col-md-6 label.error,
    #donation-form .form-row .col-md-4 label.error,
    #donation-form .form-row .col-md-2 label.error,
    #donation-form .form-row .col-md-12 label.error {
        position: absolute;
        bottom: -21px;
        left: 14px;
        font-size: 12px;
    }

</style>
@endpush

@push('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>

<!-- jquery.validate + select2 -->
<script src="{{ asset('la-assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js') }}"
        type="text/javascript"></script>

<script>
    $('.select2').select2();

    $(function () {
        /*Integer amount input*/
        $('.add-amount').keyup(function () {
            $('span.error-keyup-1').hide();
            var inputVal = $(this).val();
            var numericReg = /^\d*[0-9]$/;
            if (!numericReg.test(inputVal)) {
                this.value = this.value.replace(/[^0-9]/g, '');
                alert('Numeric characters only');
               /* $(this).after('<label style="font-size: 12px; text-align: right;" class="error error-keyup-1">Numeric characters only.</label>');*/
            }
        });

        /*  $('#donor_message').keyup(function() {
         var data = $(this).val();
         var dataFull = data.replace(/[^\w\s]/gi, '');
         $('#donor_message').val(dataFull);
         });

         $('#donor_name').keyup(function() {
         var data = $(this).val();
         var dataFull = data.replace(/[^\w\s]/gi, '');
         $('#donor_message').val(dataFull);
         });*/


        $('#datetimepicker1').datetimepicker({
            format: 'DD/MM/YYYY',
            maxDate: new Date()
        });

        $("#verification_form").validate({
            /*errorPlacement: function(error, element) {}*/
            submitHandler: function(form) { 
                $("#save_button").removeAttr("onclick");
                $("#save_button").addClass("disabled", true);
                $("#save_button").html("<?php echo Lang::get('messages.Processing');?> <i class='fa fa-spinner fa-spin'></i>");
                form.submit(); 
            }
        });

    });


    function add_verifcation() {
        var currency_id = $('#currency_id').val();
        var amount = $('#amount').val();

        if (currency_id > 0 && amount > 0) {
            var url = "{{ url('inbox_form_submit_check') }}";
            $.post(url, {'currency_id': currency_id, 'amount': amount}, function (data) {
                if (data.check == 1) {
                    $("#verification_form").submit();
                }
                else {
                    $.alert(data.msg + data.min_donate_amount + ' ' + data.currency_name);
                }
            });
        }
        else {
            $("#verification_form").submit();
        }
    }

    function account_hide(value) {
        if (value > 3) {
            $('.account_div').show();

            if(value==8)
            {
                $('#payer_account_no_div').hide();
            }
            else
            {
                $('#payer_account_no_div').show();
            }

            if(value==4)
            {
                //....rocket....
                $('#l_payer_account_no').html("{{ Lang::get('messages.Donor Rocket No') }} <span>*</span>");
                $('#l_payee_account_no').html("{{ Lang::get('messages.Recipient Rocket No') }} <span>*</span>");

                $('#payer_account_no').attr('placeholder',"{{ Lang::get('messages.Enter Your Rocket No') }}");

                $("#payee_account_no_r").empty();
                $('#payee_account_no_r').append('<?php echo $rocket_options;?>');
            }
            else if(value==5)
            {
                //....bkash....
                $('#l_payer_account_no').html("{{ Lang::get('messages.Donor Bkash No') }} <span>*</span>");
                $('#l_payee_account_no').html("{{ Lang::get('messages.Recipient Bkash No') }} <span>*</span>");

                $('#payer_account_no').attr('placeholder',"{{ Lang::get('messages.Enter Your Bkash No') }}");

                $("#payee_account_no_r").empty();
                $('#payee_account_no_r').append('<?php echo $bkash_options;?>');
            }
            else if(value==6)
            {
                //....Paypal....
                $('#l_payer_account_no').html("{{ Lang::get('messages.Donor Paypal Account No') }} <span>*</span>");
                $('#l_payee_account_no').html("{{ Lang::get('messages.Recipient Paypal Account No') }} <span>*</span>");

                $('#payer_account_no').attr('placeholder',"{{ Lang::get('messages.Enter Your Paypal Email') }}");

                $("#payee_account_no_r").empty();
                $('#payee_account_no_r').append('<?php echo $paypal_options;?>');
            }
            else if(value==7)
            {
                //....Bank Ttansfer....
                $('#l_payer_account_no').html("{{ Lang::get('messages.Donor Bank Account No') }} <span>*</span>");
                $('#l_payee_account_no').html("{{ Lang::get('messages.Recipient Bank Account No') }} <span>*</span>");
                $('#payer_account_no').attr('placeholder',"{{ Lang::get('messages.Enter Your Bank Account No') }}");

                $("#payee_account_no_r").empty();
                $('#payee_account_no_r').append('<?php echo $bank_options;?>');
            }
            else if(value==8)
            {
                //....Cash deposit Through bank....
                $('#l_payer_account_no').html("{{ Lang::get('messages.Donor Account No') }} <span>*</span>");
                $('#l_payee_account_no').html("{{ Lang::get('messages.Recipient Bank Account No') }} <span>*</span>");

                $("#payee_account_no_r").empty();
                $('#payee_account_no_r').append('<?php echo $bank_options;?>');
            }
            
            

        }
        else {
            $('.account_div').hide();
        }
    }
</script>
@endpush

