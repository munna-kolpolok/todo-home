@extends('website.layouts.app')

@section('main-content')
<div class="page-wrapper contact-page">
<!-- start page-title -->    
<section class="page-title">
    <div class="page-title-bg" style="background: url({{asset($setting->contact_background_image)}}) center center/cover no-repeat local;"></div>
    <div class="container">
        <div class="title-box">
            <h1><span class="title-custom-color">@lang('messages.Contact head1')</span> @lang('messages.Contact head2')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">@lang('messages.Home')</a></li>
                <li class="active">@lang('messages.Contact Us')</li>
            </ol>
            {{--<a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">Donate</a>--}}
        </div>
    </div> <!-- end container -->
</section>
<!-- end page-title -->


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
                @if(request()->cookie('locale')=='bn')
                <div class="row contact-info">

                    <div class="col col-sm-4">
                <div class="wow slideInUpSlow">
                    <span class="icon"><i class="fa fa-map-marker"></i></span>
                    <h3>@lang('messages.Address')</h3>
                    <p>{{ $setting->bn_contact_address or null }}</p>
                </div>
            </div>
                    <div class="col col-sm-4">
                <div class="wow slideInUpSlow" data-wow-delay="0.2s">
                    <span class="icon"><i class="fa fa-envelope-o"></i></span>
                    <h3>@lang('messages.Email')</h3>
                    <p>{{ $setting->contact_email or null }}</p>
                </div>
            </div>
                    <div class="col col-sm-4">
                <div class="wow slideInUpSlow" data-wow-delay="0.4s">
                    <span class="icon"><i class="fa fa-fax"></i></span>
                    <h3>@lang('messages.Phone')</h3>
                    <p>{{$setting->bn_contact_no }}</p>
                </div>
            </div>
                </div> <!-- end contact info -->
                @else
                <div class="row contact-info">

                        <div class="col col-sm-4">
                            <div class="wow slideInUpSlow">
                                <span class="icon"><i class="fa fa-map-marker"></i></span>
                                <h3>@lang('messages.Address')</h3>
                                <p>{{ $setting->contact_address or null }}</p>
                            </div>
                        </div>
                        <div class="col col-sm-4">
                            <div class="wow slideInUpSlow" data-wow-delay="0.2s">
                                <span class="icon"><i class="fa fa-envelope-o"></i></span>
                                <h3>@lang('messages.Email')</h3>
                                <p>{{ $setting->contact_email or null }}</p>
                            </div>
                        </div>
                        <div class="col col-sm-4">
                            <div class="wow slideInUpSlow" data-wow-delay="0.4s">
                                <span class="icon"><i class="fa fa-fax"></i></span>
                                <h3>@lang('messages.Phone')</h3>
                                <p>{{ $setting->contact_no or null }}</p>
                            </div>
                        </div>
                    </div> <!-- end contact info -->
                @endif

    </div> <!-- end container -->



    
    <div class="row map-concate-form">
        {{--<div class="col col-xs-12">
            <div class="map" id="map"></div>
        </div>--}}
        <div class="contact-form">
            <div class="container">
                <div class="row  wow bounceInUp">
                    <div class="col col-md-10 col-md-offset-1 form-inner">
                        <h3>@lang('messages.Leave us a message')</h3>
                        {!! Form::open(['url' => 'contact/store','class'=>'form row']) !!}
                        <div class="col col-md-6">
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="@lang('messages.your name..')">
                            </div>
                            <div class="col col-md-6">
                                <input type="email" class="form-control" required name="email" value="{{old('email')}}" placeholder="@lang('messages.your email..')">
                            </div>
                            <div class="col col-md-12">
                                <input type="text" class="form-control" required name="subject" value="{{old('subject')}}" placeholder="@lang('messages.subject..')">
                            </div>
                            <div class="col col-md-12">
                                <textarea class="form-control" name="message" required placeholder="@lang('messages.write here..')">{{old('message')}}</textarea>
                            </div>
                            <div class="col col-md-12 text-center">
                                @if(env('GOOGLE_RECAPTCHA_KEY'))
                                    <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                                @endif
                            </div>
                            <div class="col col-md-12">
                                <button type="submit" class="bnt theme-btn">@lang('messages.Send')</button>
                                <span id="loader"><img src="{{asset('site-assets/images/contact-ajax-loader.gif')}}" alt="Loader"></span>
                            </div>
                           {{-- <div class="col col-md-12">
                                <div id="success">Thank you</div>
                                <div id="error"> Error occurred while sending email. Please try again later. </div>
                            </div>--}}
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


@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQPX3ZpPgzQu7C7rABw4R2cdleADXbbC4"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
    $('.form').validate();
</script>
@endpush
