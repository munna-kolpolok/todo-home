@extends('website.layouts.app')


@section('main-content')
<!-- Sign up form -->
<section class="signup section-padding">
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

        <div class="signup-content">
            <div class="signup-form wow bounceInUp">
                <h2 class="form-title">@lang('messages.Forgot Password')</h2>
                <form method="POST" class="register-form" id="register-form"  action="{{ url('/forget-password') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="email"><i class="zmdi zmdi-email"></i></label>
                        <input type="email" id="email" placeholder="@lang('messages.Email')" name="email" required="1" unique="true" value="{{ old('email') }}"/>
                    </div>

                    <div class="form-group">
                        @if(env('GOOGLE_RECAPTCHA_KEY'))
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                        </div>
                        @endif

                    </div>


                    

                    <div class="form-group form-button">
                        <!-- <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/> -->
                        <button  type="submit" class="btn theme-btn">@lang('messages.Send')</button>
                    </div>
                </form>
            </div>
            <div class="signup-image">
                <figure><img src="{{asset($setting->sign_up_image)}}" alt="sing up image"></figure>
                <a href="{{ url('signin') }}" class="signup-image-link">@lang('messages.I am already member')</a>
            </div>
        </div>
    </div>
</section>   

    
@endsection

@push('style')
    <!-- Font Icon -->
    <link rel="stylesheet" href="{{asset('site-assets/registration/fonts/material-icon/css/material-design-iconic-font.min.css')}}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{asset('site-assets/registration/css/style.css')}}">
    <style type="text/css">
        #register-form .form-group {
            overflow: visible;
        }
        #register-form .form-group label.error {
            position: absolute;
            top: 24px;
            padding-left: 0;
            color: #ed3237;
        }
</style>
@endpush

@push('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
    $("#register-form").validate({
        submitHandler: function (form) {
            var form_btn = $(form).find('button[type="submit"]');
            form_btn.prop('disabled', true);
            form_btn.html("<?php echo Lang::get('messages.Processing');?> <i class='fa fa-spinner fa-spin'></i>");
            form.submit();
        }
    });
</script>
@endpush


