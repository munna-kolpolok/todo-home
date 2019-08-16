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
                <h2 class="form-title">@lang('messages.Sign up')</h2>

                <form method="POST" class="register-form" id="register-form" action="{{ url('/user_register') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input type="text" id="name" placeholder="@lang('messages.Your Name')" name="name" required="1"
                               value="{{ old('name') }}"/>
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="zmdi zmdi-email"></i></label>
                        <input type="email" id="email" placeholder="@lang('messages.Your Email')" name="email"
                               required="1" unique="true" value="{{ old('email') }}"/>
                    </div>
                    <div class="form-group">
                        <label for="pass"><i class="zmdi zmdi-lock" style="padding-bottom: 30px;"></i></label>
                        <input type="password" id="pass" placeholder="@lang('messages.Password')" name="password"
                               required="1"/>
                        <span class="suggestion_text" style="color:green; font-size: 12px;">
                                      <i class="fa fa-hand-o-right" aria-hidden="true"> @lang('messages.Only number is allowed,Minimum digit is 6.')</i>
                     </span>
                    </div>


                    <div class="form-group">
                        <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                        <input type="password" name="re_password" id="re_pass"
                               placeholder="@lang('messages.Repeat your password')" required="1"/>
                    </div>
                    <div class="form-group">
                        <!-- <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                        <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label> -->


                        @if(env('GOOGLE_RECAPTCHA_KEY'))
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                            </div>
                        @endif

                    </div>


                   {{-- <div class="form-group form-button">
                        <button type="submit" class="btn theme-btn">@lang('messages.Register')</button>
                    </div>--}}
                    <div class="row row-no-padding" style="margin-bottom: 15px">
                        <div class="col-md-5">
                            <div class="form-group form-button">
                                <button type="submit" class="btn theme-btn btn-block" id="login_button">
                                    <i class="fa fa-sign-in" aria-hidden="true"></i>
                                    @lang('messages.Register')
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <h3 class="signin-options">@lang('messages.Or')</h3>
                        </div>
                        <div class="col-md-5">
                            <div class="social-login-wrapper">
                                <button type="button" class="google-button btn-block">
                                          <span class="google-button__icon">
                                            <svg viewBox="0 0 366 372" xmlns="http://www.w3.org/2000/svg"><path d="M125.9 10.2c40.2-13.9 85.3-13.6 125.3 1.1 22.2 8.2 42.5 21 59.9 37.1-5.8 6.3-12.1 12.2-18.1 18.3l-34.2 34.2c-11.3-10.8-25.1-19-40.1-23.6-17.6-5.3-36.6-6.1-54.6-2.2-21 4.5-40.5 15.5-55.6 30.9-12.2 12.3-21.4 27.5-27 43.9-20.3-15.8-40.6-31.5-61-47.3 21.5-43 60.1-76.9 105.4-92.4z" id="Shape" fill="#EA4335"/><path d="M20.6 102.4c20.3 15.8 40.6 31.5 61 47.3-8 23.3-8 49.2 0 72.4-20.3 15.8-40.6 31.6-60.9 47.3C1.9 232.7-3.8 189.6 4.4 149.2c3.3-16.2 8.7-32 16.2-46.8z" id="Shape" fill="#FBBC05"/><path d="M361.7 151.1c5.8 32.7 4.5 66.8-4.7 98.8-8.5 29.3-24.6 56.5-47.1 77.2l-59.1-45.9c19.5-13.1 33.3-34.3 37.2-57.5H186.6c.1-24.2.1-48.4.1-72.6h175z" id="Shape" fill="#4285F4"/><path d="M81.4 222.2c7.8 22.9 22.8 43.2 42.6 57.1 12.4 8.7 26.6 14.9 41.4 17.9 14.6 3 29.7 2.6 44.4.1 14.6-2.6 28.7-7.9 41-16.2l59.1 45.9c-21.3 19.7-48 33.1-76.2 39.6-31.2 7.1-64.2 7.3-95.2-1-24.6-6.5-47.7-18.2-67.6-34.1-20.9-16.6-38.3-38-50.4-62 20.3-15.7 40.6-31.5 60.9-47.3z" fill="#34A853"/></svg>
                                          </span>
                                    <a class="google-button__text" href="{{url('/redirect/google')}}">@lang('messages.Sign up with Google')</a>
                                </button>
                            </div>
                        </div>
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
<link rel="stylesheet"
      href="{{asset('site-assets/registration/fonts/material-icon/css/material-design-iconic-font.min.css')}}">

<!-- Main css -->
<link rel="stylesheet" href="{{asset('site-assets/registration/css/style.css')}}">

<style>
    .row-no-padding > [class*="col-"] {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .signup-form  {
        margin: 0;
    }
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


