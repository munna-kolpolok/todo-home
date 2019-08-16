@extends('website.layouts.app')

@section('main-content')
    <div class="page-wrapper contact-page" id="donation-page">
        <!-- start page-title -->
        {{--<section class="page-title">
            <div class="page-title-bg"
                 style="background: url({{asset($setting->contact_background_image)}}) center center/cover no-repeat local;"></div>
            <div class="container">
                <div class="title-box">
                    <h1><span class="title-custom-color">Volunteers</span> Registration</h1>
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li class="active">Volunteers Registration</li>
                    </ol>
                   --}}{{-- <a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">Donate</a>--}}{{--
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
                                <h3>@lang('messages.Volunteers Registration Form')</h3>
                                {!! Form::open(['url' => 'volunteers','files'=>true, 'class'=>'form row','id'=>'volunteers-add-form']) !!}
                                <div class="col col-md-6">
                                    <input type="text" class="form-control" name="name" placeholder="@lang('messages.your name..')@lang('messages.required')" value="{{old('name')}}" required>
                                </div>
                                <div class="col col-md-6">
                                    <input type="email" class="form-control" name="email"
                                           placeholder="@lang('messages.your email..')@lang('messages.required')" value="{{old('email')}}" required>
                                </div>
                                <div class="col col-md-6">
                                    <input type="text" class="form-control" name="contact_no"
                                           placeholder="@lang('messages.your contact no..')@lang('messages.required')" value="{{old('contact_no')}}" required>
                                </div>
                                <div class="col col-md-6">
                                    <input type="text" class="form-control" name="address"
                                           placeholder="@lang('messages.address here..')@lang('messages.required')"value="{{old('address')}}" required>
                                </div>
                                <div class="col col-md-6">
                                    <input type="text" class="form-control" name="interest"
                                           placeholder="@lang('messages.your interest..')">
                                </div>
                                <div class="col col-md-6">
                                    @if(request()->cookie('locale')=='bn')
                                    <select class="form-control" name="contact_id" id="contact_id">
                                            @foreach($contacts as $contact)
                                                <option value="{{ $contact->id }}">{{ $contact->bn_name }}</option>
                                            @endforeach
                                    </select>
                                    @else
                                        <select class="form-control" name="contact_id" id="contact_id">
                                            @foreach($contacts as $contact)
                                                <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>

                                <div class="col col-md-12">
                                    <label for="block_image">@lang('messages.Photo')</label>
                                    <input type="file" id="block_image" class="form-control" name="block_image">
                                </div>
                                <div class="col col-md-12">
                                    <textarea class="form-control" name="biography"
                                              placeholder="@lang('messages.Enter your biography')">{{old('biography')}}</textarea>
                                </div>
                                <div class="col col-md-12 text-center">
                                    @if(env('GOOGLE_RECAPTCHA_KEY'))
                                        <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                                    @endif
                                </div>
                                <div class="col col-md-12">
                                    <button type="submit" class="bnt theme-btn">@lang('messages.Save')</button>
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

@push('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>

<script>
    $(function () {

        $("#volunteers-add-form").validate({});

    });
</script>
@endpush

