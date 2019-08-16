@extends('website.layouts.app')


@section('main-content')
    <!-- Sign up form -->
    <section class="signup section-padding" id="donation-registration-form">
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

            <div>
                <div class="wrapper">
                    <div class="inner">
                        <div class="image-holder">
                            <img src="{{asset('site-assets/colorib/285_400.jpg')}}" alt="">
                        </div>
                        <form action="">
                            <h3>DONATE CONFIRMATION FORM</h3>
                            <div class="form-row">
                                <input type="text" class="form-control" name="donor_name" placeholder="Name">
                                <input type="text" class="form-control" name="donor_email" placeholder="Mail">
                            </div>
                            <div class="form-row">
                                <div class="form-holder">
                                    <select name="sector_id" id="sector_id" class="form-control select2" required>
                                        <option>Select sector</option>
                                        @foreach($sectors as $sector)
                                            <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                        @endforeach
                                    </select>
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </div>
                                <div class="form-holder">
                                    <select style="margin-left: 10px" name="currency_id" id="currency_id" class="form-control select2" required>
                                        <option>Select currency</option>
                                        @foreach($currency_lists as $currency_list)
                                            <option value="{{ $currency_list->id }}">{{ $currency_list->currency_code }}</option>
                                        @endforeach
                                    </select>
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-holder">
                                    <select name="payment_method_id" id="payment_method_id" class="form-control select2">
                                        <option>Select payment method</option>
                                        @foreach($payment_methods as $payment_method)
                                            <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
                                        @endforeach
                                    </select>
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </div>
                                <input type="file" class="form-control" placeholder="attachment" name="attachment">
                            </div>
                            <textarea  name="" id="" placeholder="Message" class="form-control" style="height: 130px;"></textarea>
                            <button type="submit">Send
                                <i class="zmdi zmdi-long-arrow-right"></i>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>


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


