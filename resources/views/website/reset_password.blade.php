@extends('website.layouts.app')


@section('main-content')

<!-- Sing in  Form -->
<section class="sign-in section-padding">
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

        <div class="signin-content wow slideInDown">
            <div class="signin-image">
                <figure><img src="{{asset($setting->sign_in_image)}}" alt="sing up image"></figure>
                <a href="{{ url('signup') }}" data-toggle="tooltip" title="@lang('messages.Click here and create new account!')" class="signup-image-link">@lang('messages.Create an account')</a>
            </div>

            <div style="margin-top: -60px" class="signin-form wow slideInRight">
                <h2 class="form-title">@lang('messages.Reset Password')</h2>
                <form method="POST" class="register-form" id="login-form" action="{{ url('/reset-password') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="your_pass"><i class="zmdi zmdi-lock" ></i></label>
                        <input type="password" name="old_password" id="old-password" placeholder="@lang('messages.Old Password')" required="1"/>
                    </div>
                    <div class="form-group">
                        <label for="your_pass"><i class="zmdi zmdi-lock" style="padding-bottom: 30px;" ></i></label>
                        <input type="password" name="password" id="new-password" placeholder="@lang('messages.New Password')" required="1"/>
                        <p class="suggestion_text" style="color:green; font-size: 12px; margin-top: 11px">
                            <i class="fa fa-hand-o-right" aria-hidden="true"> @lang('messages.Only number is allowed,Minimum digit is 6.')</i>
                        </p>

                    </div>
                    <div class="form-group">
                        <label for="your_pass"><i class="zmdi zmdi-lock" style="padding-bottom: 30px;"></i></label>
                        <input type="password" name="password_confirmation" id="confirm-password" placeholder="@lang('messages.Re-type Password')" required="1"/>
                        <p class="suggestion_text" style="color:green; font-size: 12px; margin-top: 11px">
                            <i class="fa fa-hand-o-right" aria-hidden="true"> @lang('messages.Only number is allowed,Minimum digit is 6.')</i>
                        </p>
                    </div>
                    <div class="form-group">
                        @if(env('GOOGLE_RECAPTCHA_KEY'))
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                            </div>
                        @endif
                    </div>


                    <div class="form-group form-button">
                        <!-- <input type="submit" name="signin" id="signin"  class="btn theme-btn" value="Log in"/> -->
                        <button  type="submit" class="btn theme-btn">@lang('messages.Submit')</button>
                        <a style="display: inline; margin-left: 15px" href="{{ url('forget-password') }}" class="signup-image-link">@lang('messages.Forget Password')</a>
                    </div>
                </form>
                <div class="social-login">
                    <!-- <span class="social-label">Or login with</span>
                    <ul class="socials">
                        <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                        <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                        <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                    </ul> -->
                </div>
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
        #login-form .form-group {
            overflow: visible;
            margin-bottom: 25px;
        }
        #login-form .form-group label.error {
            position: absolute;
            top: 23px;
            padding-left: 0;
            color: #ed3237;
            font-size: 13px;
        }
    </style>
@endpush

@push('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();

        $("#login-form").validate({
            submitHandler: function (form) {
                var form_btn = $(form).find('button[type="submit"]');
                form_btn.prop('disabled', true);
                form_btn.html("<?php echo Lang::get('messages.Processing');?> <i class='fa fa-spinner fa-spin'></i>");
                form.submit();
            }
        });

    });
</script>
@endpush


