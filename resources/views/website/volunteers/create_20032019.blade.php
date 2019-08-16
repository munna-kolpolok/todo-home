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

            <div class="">
                {{--<div class="col col-xs-12">
                    <div class="map" id="map"></div>
                </div>--}}

                <div class="">
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
                            <div class="col-md-10 py-5 col-centered">
                                <div id="donation-form">
                                    <h4 class="pb-4">@lang('messages.Volunteer Registration Form')</h4>
                                    {!! Form::open(['url' => 'volunteers','files'=>true, 'class'=>'form row','id'=>'verification_form']) !!}
                                    {{-- {!! Form::open(['url' => 'donation/store','files'=>true,'id'=>'verification_form']) !!}--}}
                                    {{--Bangla language start--}}
                                    @if(request()->cookie('locale')=='bn')
                                        <div class="form-row">
                                            <div class="form-group col-md-6 volunteer_col">
                                                <select class="form-control select2" name="volunteer" id="volunteer"
                                                        onchange="volunteerFnc(this.value)" required>
                                                    <option value="">@lang('messages.Select Nationality')</option>
                                                    <option value="1">@lang('messages.Local')</option>
                                                    <option value="2">@lang('messages.International')</option>
                                                </select>
                                                <span class="required">*</span>
                                            </div>

                                            {{--if local show this col--}}
                                            <div class="form-group col-md-4 contact_id" id="contact_col"
                                                 style="display: none">
                                                <select class="form-control select2" name="contact_id" id="contact_id"
                                                        required>
                                                    <option value="">@lang('messages.Select Branch')</option>
                                                    @foreach($contacts as $contact)
                                                        <option value="{{ $contact->id }}">{{ $contact->bn_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="required">*</span>
                                            </div>

                                            <div class="form-group col-md-6 dob_col">
                                                <div class='input-group date' id='datetimepicker1'>
                                                    <input type='text' class="form-control" name="dob" id="date"
                                                           placeholder="@lang('messages.Date Of Birth')" required="1"
                                                            />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                                </div>
                                                <span class="required">*</span>
                                            </div>
                                        </div>

                                        {{--if international show this row--}}
                                        <div class="form-row" id="international_row" style="display: none;">
                                            <div class="form-group col-md-4 nationality_col" id="nationality_col">
                                                <input type="text" required class="form-control nationality"
                                                       name="nationality"
                                                       id="nationality"
                                                       placeholder="@lang("messages.Enter Country Name")"
                                                       value="{{ old('nationality') }}">
                                                <span class="required">*</span>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control" name="passport_no"
                                                       id="passport_no"
                                                       placeholder="@lang('messages.Passport No')"
                                                       value="{{ old('passport_no') }}">
                                            </div>
                                            <div class="col-md-12 gorm-group col-lg-2">
                                                <lable class="form-control text_lable">@lang('messages.PP Scan copy')
                                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i></lable>
                                                {{--<span class="" style="color: white; font-weight: bold;">@lang('messages.PP Scan copy')</span>--}}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <input type="file" id="pasport_image"
                                                       class="form-control"
                                                       name="pasport_image" required><span
                                                        class="required">*</span>
                                            </div>
                                        </div>
                                        {{--if international show this row End--}}

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <input type="text" required class="form-control first_name"
                                                       name="first_name"
                                                       id="first_name" placeholder="@lang("messages.First Name")"
                                                       value="{{ old('first_name') }}">
                                                <span class="required">*</span>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control" name="last_name" id="last_name"
                                                       placeholder="@lang('messages.Last Name')"
                                                       value="{{ old('Last_name') }}" required>
                                                <span class="required">*</span>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="email" required class="form-control email" name="email"
                                                       id="email" placeholder="@lang("messages.Email")"
                                                       value="{{ old('email') }}">
                                                <span class="required">*</span>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <input type="text" required class="form-control contact_no"
                                                       name="contact_no"
                                                       id="contact_no" placeholder="@lang("messages.Contact No")"
                                                       value="{{ old('contact_no') }}">
                                                <span class="required">*</span>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <select class="form-control select2" name="gender_id" id="gender_id"
                                                        required>
                                                    <option value="">@lang('messages.Select Gender')</option>
                                                    @foreach($genders as $gender)
                                                        <option value="{{ $gender->id }}">{{ $gender->gender_bn_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="required">*</span>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" required class="form-control interest"
                                                       name="interest"
                                                       id="interest" placeholder="@lang("messages.Interest")"
                                                       value="{{ old('interest') }}">
                                                <span class="required">*</span>
                                            </div>
                                        </div>
                                        {{--//Bangla end--}}
                                    @else
                                        {{--Eng Start--}}
                                        <div class="form-row">
                                            <div class="form-group col-md-6 volunteer_col">
                                                <select class="form-control select2" name="volunteer" id="volunteer"
                                                        onchange="volunteerFnc(this.value)" required>
                                                    <option value="">@lang('messages.Select Nationality')</option>
                                                    <option value="1">@lang('messages.Local')</option>
                                                    <option value="2">@lang('messages.International')</option>
                                                </select>
                                                <span class="required">*</span>
                                            </div>

                                            {{--if local show this col--}}
                                            <div class="form-group col-md-4 contact_id" id="contact_col"
                                                 style="display: none">
                                                <select class="form-control select2" name="contact_id" id="contact_id"
                                                        required>
                                                    <option value="">@lang('messages.Select Branch')</option>
                                                    @foreach($contacts as $contact)
                                                        <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="required">*</span>
                                            </div>

                                            <div class="form-group col-md-6 dob_col">
                                                <div class='input-group date' id='datetimepicker1'>
                                                    <input type='text' class="form-control" name="dob" id="date"
                                                           placeholder="@lang('messages.Date Of Birth')" required="1"
                                                            />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                                </div>
                                                <span class="required">*</span>
                                            </div>
                                        </div>

                                        {{--if international show this row--}}
                                        <div class="form-row" id="international_row" style="display: none;">
                                            <div class="form-group col-md-4 nationality_col" id="nationality_col">
                                                <input type="text" required class="form-control nationality"
                                                       name="nationality"
                                                       id="nationality"
                                                       placeholder="@lang("messages.Enter Country Name")"
                                                       value="{{ old('nationality') }}">
                                                <span class="required">*</span>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control" name="passport_no"
                                                       id="passport_no"
                                                       placeholder="@lang('messages.Passport No')"
                                                       value="{{ old('passport_no') }}">
                                            </div>
                                            <div class="col-md-12 gorm-group col-lg-2">
                                                <lable class="form-control text_lable">@lang('messages.PP Scan copy')
                                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i></lable>
                                                {{--<span class="" style="color: white; font-weight: bold;">@lang('messages.PP Scan copy')</span>--}}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <input type="file" id="pasport_image"
                                                       class="form-control"
                                                       name="pasport_image" required><span
                                                        class="required">*</span>
                                            </div>
                                        </div>
                                        {{--if international show this row End--}}

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <input type="text" required class="form-control first_name"
                                                       name="first_name"
                                                       id="first_name" placeholder="@lang("messages.First Name")"
                                                       value="{{ old('first_name') }}">
                                                <span class="required">*</span>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <input type="text" class="form-control" name="last_name" id="last_name"
                                                       placeholder="@lang('messages.Last Name')"
                                                       value="{{ old('Last_name') }}" required>
                                                <span class="required">*</span>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="email" required class="form-control email" name="email"
                                                       id="email" placeholder="@lang("messages.Email")"
                                                       value="{{ old('email') }}">
                                                <span class="required">*</span>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <input type="text" required class="form-control contact_no"
                                                       name="contact_no"
                                                       id="contact_no" placeholder="@lang("messages.Contact No")"
                                                       value="{{ old('contact_no') }}">
                                                <span class="required">*</span>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <select class="form-control select2" name="gender_id" id="gender_id"
                                                        required>
                                                    <option value="">@lang('messages.Select Gender')</option>
                                                    @foreach($genders as $gender)
                                                        <option value="{{ $gender->id }}">{{ $gender->gender_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="required">*</span>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" required class="form-control interest"
                                                       name="interest"
                                                       id="interest" placeholder="@lang("messages.Interest")"
                                                       value="{{ old('interest') }}">
                                                <span class="required">*</span>
                                            </div>
                                        </div>
                                        {{--Eng end--}}
                                    @endif

                                    <div class="form-row">
                                        <div class="col-md-12 gorm-group col-lg-4" style="">
                                            <lable class="form-control text_lable">@lang('messages.Volunteerity Duration')
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i></lable>
                                            {{-- <span class="" style="color: white; font-weight: bold;">@lang('messages.Volunteerity Duration')</span>--}}
                                        </div>
                                        <div class="form-group col-md-4 ">
                                            <div class='input-group date' id='datetimepicker2'>
                                                <input type='text' class="form-control" name="start_date" id="date"
                                                       placeholder="@lang('messages.Start Date')" required="1"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                            </div>
                                            <span class="required">*</span>

                                        </div>
                                        <div class="form-group col-md-4 ">
                                            <div class='input-group date' id='datetimepicker3'>
                                                <input type='text' class="form-control" name="end_date" id="date"
                                                       placeholder="@lang('messages.End Date')" required="1"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                            </div>
                                            <span class="required">*</span>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                            <textarea class="form-control" name="address" id="address" required
                                      placeholder="@lang("messages.Enter Your Address")">{{ old('address') }}</textarea><span
                                                    class="required">*</span>
                                        </div>
                                        <div class="form-group col-md-12 col-lg-6">
                            <textarea class="form-control" name="emergency_contact_details"
                                      id="emergency_contact_details" required
                                      placeholder="@lang("messages.Enter Emergency Contact Details")">{{ old('emergency_contact_details') }}</textarea><span
                                                    class="required">*</span>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12 col-lg-6">
                            <textarea class="form-control" name="biography" id="biography" required
                                      placeholder="@lang("messages.Enter Your Biography")">{{ old('biography') }}</textarea><span
                                                    class="required">*</span>
                                        </div>
                                        <div class="col-md-12 gorm-group col-lg-2">
                                            <lable class="form-control text_lable">@lang('messages.Profile Image')
                                                {{-- <i class="fa fa-hand-o-right" aria-hidden="true" style="font-size: 12px;"></i>--}}</lable>
                                            {{--<span class="" style="color: white; font-weight: bold;">@lang('messages.Profile Image')</span>--}}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="file" id="profile_image"  class="form-control"
                                                   name="profile_image" required><span
                                                    class="required">*</span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 text-center">
                                        @if(env('GOOGLE_RECAPTCHA_KEY'))
                                            <div class="g-recaptcha"
                                                 data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                                        @endif
                                        <div style="margin-top: 10px" class="submit-button">
                                            <a href="#" onclick="add_verifcation()"
                                               class="bnt theme-btn btn-block">@lang('messages.Send')</a>
                                        </div>

                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <!-- end container -->
                </div>
            </div>

        </section>
        <!-- end contact-main-content -->

    </div>

@endsection

@push('style')
<link href="{{ asset('la-assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>

<style>
    a {
        color: white;
    }

    .text_lable {
        background-color: rgba(184, 184, 184, 0.64);
        color: white;
        border-color: lightgray;
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


        $('#datetimepicker1').datetimepicker({
            format: 'DD/MM/YYYY',
            maxDate: new Date()
        });
        $('#datetimepicker2').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#datetimepicker3').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        $("#verification_form").validate({
            /*errorPlacement: function(error, element) {}*/
        });
    });

    function add_verifcation() {
        $("#verification_form").submit();
    }
    function volunteerFnc(val) {

        /*dynamic col row show/hide  */
        if (val == 1) {
            $('.dob_col').replaceClass('col-md-6', 'col-md-4');
            $('.volunteer_col').replaceClass('col-md-6', 'col-md-4');

            $("#contact_col").show();

            $("#international_row").hide();
            $('#passport_no').val('');
            $('#nationality').val('');
            $('#pasport_image').val('');
        } else if (val == 2) {
            $('.dob_col').replaceClass('col-md-4', 'col-md-6');
            $('.volunteer_col').replaceClass('col-md-4', 'col-md-6');

            $("#international_row").show();
            $("#contact_col").hide();
            $("#contact_id").val('');

        } else {
            $('.dob_col').replaceClass('col-md-4', 'col-md-6');
            $('.volunteer_col').replaceClass('col-md-4', 'col-md-6');

            $("#international_row").hide();
            $("#contact_col").hide();

            $("#contact_id").val('');
            $('#passport_no').val('');
            $('#nationality').val('');
            $('#pasport_image').val("");

        }

    }


    /*replace class plugin func*/
    (function ($) {
        $.fn.replaceClass = function (pFromClass, pToClass) {
            return this.removeClass(pFromClass).addClass(pToClass);
        };
    }(jQuery));

</script>
@endpush

