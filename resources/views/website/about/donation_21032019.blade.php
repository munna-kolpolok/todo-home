@extends('website.layouts.app')

<style type="text/css">
    .account_div
    {
        display: none;
    }
</style>

@section('main-content')
    <!-- Sign up form -->
    <section style="padding: 100px 0" class="signup section-padding" id="donation-registration-form">
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
            <div class="row wow fadeInLeftSlow">
                <div class="col-md-7 py-5">
                    <div id="donation-form">
                        <h4 class="pb-4">@lang('messages.Donation Clarification Form')</h4>
                        {!! Form::open(['url' => 'donation/store','files'=>true,'id'=>'verification_form']) !!}
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="number" required min="1" class="form-control add-amount" name="amount" id="amount" placeholder="@lang("messages.Enter Amount In English")" value="{{ old('amount') }}" max="10000000">
                                <span class="required">*</span>
                            </div>
                            <div class="form-group col-md-6">
                                <select class="form-control select2" name="currency_id" id="currency_id" required>
                                    <option value="">@lang('messages.Select currency')</option>
                                    @foreach($currency_lists as $currency_list)
                                        <option value="{{ $currency_list->id }}" @if(old('currency_id')==$currency_list->id) selected @endif>{{ $currency_list->currency_name }} ({{ $currency_list->currency_code }})</option>
                                    @endforeach
                                </select>
                                <span class="required">*</span>
                            </div>
                        </div>

                        @if(request()->cookie('locale')=='bn')
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <select class="form-control select2" name="sector_id" id="sector_id" required>
                                    <option value="">@lang('messages.Select donation reason')</option>
                                    @foreach($sectors as $sector)
                                        <option value="{{ $sector->id }}" @if(old('sector_id')==$sector->id) selected @endif>{{ $sector->bn_name }}</option>
                                    @endforeach
                                </select>
                                <span class="required">*</span>
                            </div>
                            <div class="form-group col-md-6">
                                <select class="form-control select2" name="payment_method_id" id="payment_method_id" required onchange="account_hide(this.value)">
                                    <option value="">@lang('messages.Select payment channel')</option>
                                    @foreach($payment_methods as $payment_method)
                                        <option value="{{ $payment_method->id }}">{{ $payment_method->bn_name }}</option>
                                    @endforeach
                                </select>
                                <span class="required">*</span>
                            </div>
                        </div>
                        @else
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <select class="form-control select2" name="sector_id" id="sector_id" required>
                                    <option value="">@lang('messages.Select donation reason')</option>
                                    @foreach($sectors as $sector)
                                        <option value="{{ $sector->id }}" @if(old('sector_id')==$sector->id) selected @endif>{{ $sector->name }}</option>
                                    @endforeach
                                </select>
                                <span class="required">*</span>
                            </div>
                            <div class="form-group col-md-6">
                                <select class="form-control select2" name="payment_method_id" id="payment_method_id" required onchange="account_hide(this.value)">
                                    <option value="">@lang('messages.Select payment channel')</option>
                                    @foreach($payment_methods as $payment_method)
                                        <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
                                    @endforeach
                                </select>
                                <span class="required">*</span>
                            </div>
                        </div>
                        @endif


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="email" class="form-control" name="donor_email"
                                       placeholder="@lang('messages.Email')" required value="{{ old('donor_email') }}">
                                <span class="required">*</span>
                            </div>
                            <div class="form-group col-md-6">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" name="date" id="date"
                                           placeholder="@lang('messages.Enter Date')" required="1"
                                           value="{{ App\Helpers\CommonHelper::showDateFormat(date('Y-m-d')) }}"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div><span style="" class="required">*</span>

                                </span>
                            </div>
                        </div>

                        <div class="form-row account_div">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="payer_account_no"
                                       placeholder="@lang('messages.Enter Payer Account No')" required value="{{ old('payer_account_no') }}">
                                <span class="required">*</span>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="payee_account_no"
                                       placeholder="@lang('messages.Enter Payee Account No')" required value="{{ old('payer_account_no') }}">
                                <span class="required">*</span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="donor_name" id="donor_name" placeholder="@lang('messages.Name')"  value="{{ old('donor_name') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="file" id="attachment" class="form-control" name="attachment">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <textarea class="form-control" name="donor_message" id="donor_message"
                                          placeholder="@lang("messages.Enter Your Message")">{{ old('donor_message') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            @if(env('GOOGLE_RECAPTCHA_KEY'))
                                <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                            @endif
                            <div style="margin-top: 10px" class="submit-button">
                                <a href="#" onclick="add_verifcation()" class="bnt theme-btn btn-block">@lang('messages.Send')</a>
                            </div>

                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

    </section>


@endsection

@push('style')
<link href="{{ asset('la-assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ asset('jquery-confirm-v3.2.0/css/jquery-confirm.min.css') }}">
<style>
    [class^='select2'] {
        border-radius: 0px !important;
    }
    .select2-container .select2-selection--single {
        height: 34px;
    }

    #donation-form .form-row .col-md-6 {
        position: relative;
    }

    #donation-form .form-row .col-md-6 span.required {
        position: absolute;
        top: 9%;
        right: 0px;
        font-size: 30px;
        color: #ed3237;
    }

    #donation-form .form-row .col-md-6 label.error {
        position: absolute;
        bottom: -21px;
        left: 16px;
        font-size: 12px;
        color: #ffffff;
        background-color: red;
    }

</style>
@endpush
@push('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>

<!-- jquery.validate + select2 -->
<script src="{{ asset('la-assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>

<script src="{{ asset('jquery-confirm-v3.2.0/js/jquery-confirm.min.js') }}" type="text/javascript"></script>

<script>
    $('.select2').select2();

    $(function () {
        /*Integer amount input*/
        $('.add-amount').keyup(function() {
            $('span.error-keyup-1').hide();
            var inputVal = $(this).val();
            var numericReg = /^\d*[0-9]$/;
            if(!numericReg.test(inputVal)) {
                this.value=this.value.replace(/[^0-9]/g,'');
                $(this).after('<label style="font-size: 12px" class="error error-keyup-1">Numeric characters only.</label>');
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
        });
    });

    function add_verifcation()
    {
        var currency_id=$('#currency_id').val();
        var amount=$('#amount').val();

        if(currency_id>0 && amount>0)
        {
            var url="{{ url('inbox_form_submit_check') }}";
            $.post(url,{'currency_id':currency_id,'amount':amount},function( data ) {
                if(data.check==1)
                {
                    $( "#verification_form" ).submit();
                }
                else
                {
                    $.alert(data.msg+data.min_donate_amount+ ' '+data.currency_name);
                }
            });
        }
        else
        {
            $( "#verification_form" ).submit();
        }
    }

    function account_hide(value)
    {
        if(value>3)
        {
            $('.account_div').show();

        }
        else
        {
            $('.account_div').hide();
        }
    }

</script>
@endpush


