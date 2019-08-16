@extends('website.layouts.app')

@section('main-content')
    <div class="page-wrapper contact-page" id="donation-page">
        <!-- start page-title -->
    {{--<section class="page-title">
        <div class="page-title-bg"
             style="background: url({{asset($setting->contact_background_image)}}) center center/cover no-repeat local;"></div>
        <div class="container">
            <div class="title-box">
                <h1><span class="title-custom-color">Donation</span></h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Donation</li>
                </ol>
                <a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">Donate</a>
            </div>
        </div> <!-- end container -->
    </section>--}}
    <!-- end page-title -->


        <!-- start contact-main-content -->
        <section class="contact-main-content section-padding">

            <div class="row map-concate-form">
                {{--<div class="col col-xs-12">
                    <div class="map" id="map"></div>
                </div>--}}

                <div class="contact-form">
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
                        <div class="row  wow bounceInUp">
                            <div class="col col-md-10 col-md-offset-1 form-inner">
                                <h3>Donate confirmation form</h3>
                                {!! Form::open(['url' => 'donation/store','files'=>true, 'class'=>'form row']) !!}
                                <div class="col col-md-6">
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='text' class="form-control" name="date" id="date"
                                               placeholder="@lang('messages.Enter Date')" required="1"
                                               value="{{ App\Helpers\CommonHelper::showDateFormat(date('Y-m-d')) }}"/>
                                        <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
                                    </div>
                                </div>
                                
                                <div class="col col-md-6">
                                    <input type="email" class="form-control" name="donor_email"
                                           placeholder="your email.." required>
                                </div>
                                <div class="col col-md-6">
                                    <input type="text" class="form-control" name="donor_name" placeholder="your name..">
                                </div>
                                <!-- <div class="col col-md-6">
                                    <input type="text" class="form-control" name="donor_contact_no"
                                           placeholder="your contact no..">
                                </div> -->
                                <div class="col col-md-6">
                                    <select class="form-control select2" name="sector_id" id="sector_id" required>
                                        <option>Select sector</option>
                                        @foreach($sectors as $sector)
                                            <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col col-md-6">
                                    <input type="number" required min="1" class="form-control" name="amount" id="amount"
                                           placeholder="@lang("messages.Enter Amount")">
                                </div>

                                <div class="col col-md-6">
                                    <select class="form-control select2" name="currency_id" id="currency_id" required>
                                        <option>Select currency</option>
                                        @foreach($currency_lists as $currency_list)
                                            <option value="{{ $currency_list->id }}">{{ $currency_list->currency_code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col col-md-6">
                                    <select class="form-control select2" name="payment_method_id" id="payment_method_id"
                                            required>
                                        <option>Select payment method</option>
                                        @foreach($payment_methods as $payment_method)
                                            <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col col-md-6">
                                    <input type="file" id="attachment" class="form-control" name="attachment">
                                </div>

                                <div class="col col-md-12">
                                    <textarea class="form-control" name="donor_message"
                                              placeholder="@lang("messages.Enter Your Message")"></textarea>
                                </div>
                                <div class="col col-md-12 text-center">
                                    @if(env('GOOGLE_RECAPTCHA_KEY'))
                                        <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                                    @endif
                                </div>
                                <div class="col col-md-12">
                                    <button type="submit" class="bnt theme-btn">Send</button>
                                    <span id="loader"><img src="{{asset('site-assets/images/contact-ajax-loader.gif')}}"
                                                           alt="Loader"></span>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div> <!-- end row -->
                    </div> <!-- end container -->
                </div>
            </div>

        </section>
        <!-- end contact-main-content -->

    </div>

@endsection
@push('style')
<link href="{{ asset('la-assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>

<!-- jquery.validate + select2 -->
<script src="{{ asset('la-assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>

<script>
    $('.select2').select2();
</script>
@endpush

