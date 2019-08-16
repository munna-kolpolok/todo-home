@extends('website.layouts.app')

@section('main-content')
    <div class="page-wrapper contact-page" id="donation-page"
         style="background-image:  url('{{asset($setting->volunteers_form_bg_image)}}')!important; background-repeat: no-repeat; background-position: center center;background-size: cover; background-attachment: fixed;">

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
                            <div class="col-md-8 py-5 col-centered">

                                <div class="" id="tab-cont">
                                    <h3 class="pb-4 form-tiltle"
                                        style="color: white; padding: 10px;">@lang('messages.Volunteer Registration Form')
                                    </h3><br>
                                    <ul class="nav nav-tabs nav-tabs2 tab-title" style="">
                                        <li class="active" style="width: 50%"><a data-toggle="tab"  href="#local" id="local_nav">@lang('messages.Local')</a>
                                        </li>
                                        <li style="width: 50%">
                                            <a data-toggle="tab"  href="#international"  id="international_nav">@lang('messages.International')</a>
                                        </li>
                                    </ul>


                                    <div class="tab-content">
                                        <div id="local" class="tab-pane fade in active">
                                            <div id="donation-form">
                                                {{-- <p style="color: #ff0000db">Please, fill up all information for
                                                     registration.</p>--}}
                                                <br>
                                                {!! Form::open(['url' => 'volunteers','files'=>true, 'class'=>'form row','id'=>'verification_form']) !!}

                                                <div class="local_form" id="local_form" style="">
                                                    <div class="form-row" id="">
                                                        <div class="form-group col-md-6">

                                                            <input type="hidden" name="volunteer" value="1">

                                                            <p class="lable" style="">@lang("messages.First Name")
                                                                <span>*</span></p>
                                                            <input type="text" required class="form-control first_name"
                                                                   name="first_name"
                                                                   id="first_name"
                                                                   placeholder="@lang("messages.Enter your first name")"
                                                                   value="{{ old('first_name') }}">

                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <p class="lable">@lang('messages.Last Name') <span>*</span>
                                                            </p>
                                                            <input type="text" class="form-control" name="last_name"
                                                                   id="last_name"
                                                                   placeholder="@lang('messages.Enter your last name')"
                                                                   value="{{ old('last_name') }}" required>

                                                        </div>
                                                    </div>

                                                    <div class="form-row" id="">
                                                        <div class="form-group col-md-6">
                                                            <p class="lable">@lang("messages.Email") <span>*</span></p>
                                                            <input type="email" required class="form-control email"
                                                                   name="email"
                                                                   id="email"
                                                                   placeholder="@lang("messages.Enter Your Email")"
                                                                   value="{{ old('email') }}">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <p class="lable">@lang("messages.Contact No") <span>*</span>
                                                            </p>
                                                            <input type="text" required class="form-control contact_no"
                                                                   name="contact_no"
                                                                   id="contact_no"
                                                                   placeholder="@lang("messages.Enter Contact No")"
                                                                   value="{{ old('contact_no') }}">
                                                        </div>
                                                    </div>
                                                    {{--for bengali--}}
                                                    @if(request()->cookie('locale')=='bn')
                                                        <div class="form-row" id="bn_gender_cont">
                                                            <div class="form-group col-md-6">
                                                                <p class="lable">@lang("messages.Gender")
                                                                    <span>*</span></p>
                                                                <select class="form-control select2" name="gender_id"
                                                                        id="gender_id"
                                                                        required>
                                                                    {{-- <option value="">@lang('messages.Select Gender')</option>--}}
                                                                    @foreach($genders as $gender)
                                                                        <option value="{{ $gender->id }}">{{ $gender->gender_bn_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <p class="lable">@lang("messages.Select Branch")
                                                                    <span>*</span></p>
                                                                <select class="form-control select2" name="contact_id"
                                                                        id="contact_id"
                                                                        required>
                                                                   {{-- <option value="">@lang('messages.Select Branch')</option>--}}
                                                                    @foreach($contacts as $contact)
                                                                        <option value="{{ $contact->id }}">{{ $contact->bn_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @else
                                                        {{--for english--}}
                                                        <div class="form-row" id="bn_gender_cont">
                                                            <div class="form-group col-md-6">
                                                                <p class="lable">@lang("messages.Gender")
                                                                    <span>*</span></p>
                                                                <select class="form-control select2" name="gender_id"
                                                                        id="gender_id"
                                                                        required>
                                                                    {{-- <option value="">@lang('messages.Select Gender')</option>--}}
                                                                    @foreach($genders as $gender)
                                                                        <option value="{{ $gender->id }}">{{ $gender->gender_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <p class="lable">@lang("messages.Select Branch")
                                                                    <span>*</span></p>
                                                                <select class="form-control select2" name="contact_id"
                                                                        id="contact_id"
                                                                        required>
                                                                   {{-- <option value="">@lang('messages.Select Branch')</option>--}}
                                                                    @foreach($contacts as $contact)
                                                                        <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="form-row" id="bn_img">

                                                        <div class="form-group col-md-6">
                                                            <p class="lable">@lang("messages.Profile Image")
                                                                <span>*</span></p>

                                                            <div id="" class="form-group"
                                                                 onclick="show_img(1)">
                                                                <input type="file" name="profile_image"
                                                                       class="form-control" id="image-upload" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <div id="image-preview" class="form-group"
                                                                 style="display: none">

                                                            </div>
                                                        </div>
                                                        <br>
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

                                        {{--tab for international--}}
                                        <div id="international" class="tab-pane fade">
                                            <div id="donation-form">
                                                {{-- <p style="color: #ff0000db">Please, fill up all information for
                                                     registration.</p>--}}
                                                <br>
                                                {!! Form::open(['url' => 'volunteers','files'=>true, 'class'=>'form row','id'=>'verification_form2']) !!}

                                                <div class="local_form" id="international_form" style="">
                                                    <div class="form-row" id="">
                                                        <div class="form-group col-md-6">
                                                            <input type="hidden" name="volunteer" value="2">

                                                            <p class="lable" style="">@lang("messages.First Name")
                                                                <span>*</span></p>
                                                            <input type="text" required class="form-control first_name"
                                                                   name="first_name"
                                                                   id="first_name"
                                                                   placeholder="@lang("messages.Enter your first name")"
                                                                   value="{{ old('first_name') }}">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <p class="lable" style="">@lang("messages.Last Name")
                                                                <span>*</span>
                                                            </p>
                                                            <input type="text" class="form-control" name="last_name"
                                                                   id="last_name"
                                                                   placeholder="@lang('messages.Enter your last name')"
                                                                   value="{{ old('Last_name') }}" required>

                                                        </div>
                                                    </div>

                                                    <div class="form-row" id="">
                                                        <div class="form-group col-md-6">
                                                            <p class="lable" style="">@lang("messages.Email")
                                                                <span>*</span></p>
                                                            <input type="email" required class="form-control email"
                                                                   name="email"
                                                                   id="email"
                                                                   placeholder="@lang("messages.Enter Your Email")"
                                                                   value="{{ old('email') }}">

                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <p class="lable" style="">@lang("messages.Contact No")
                                                                <span>*</span></p>
                                                            <input type="text" required class="form-control contact_no"
                                                                   name="contact_no"
                                                                   id="contact_no"
                                                                   placeholder="@lang("messages.Enter Contact No")"
                                                                   value="{{ old('contact_no') }}">

                                                        </div>
                                                    </div>

                                                    <div class="form-row" id="">
                                                        {{--for bengali--}}
                                                        @if(request()->cookie('locale')=='bn')
                                                            <div class="form-row" id="bn_gender_cont">
                                                                <div class="form-group col-md-6">
                                                                    <p class="lable">@lang("messages.Gender")
                                                                        <span>*</span></p>
                                                                    <select class="form-control select2"
                                                                            name="gender_id"
                                                                            id="gender_id"
                                                                            required>
                                                                        {{-- <option value="">@lang('messages.Select Gender')</option>--}}
                                                                        @foreach($genders as $gender)
                                                                            <option value="{{ $gender->id }}">{{ $gender->gender_bn_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @else
                                                            {{--for english--}}
                                                            <div class="form-row" id="bn_gender_cont">
                                                                <div class="form-group col-md-6">
                                                                    <p class="lable">@lang("messages.Gender")
                                                                        <span>*</span></p>
                                                                    <select class="form-control select2"
                                                                            name="gender_id"
                                                                            id="gender_id"
                                                                            required>
                                                                        {{-- <option value="">@lang('messages.Select Gender')</option>--}}
                                                                        @foreach($genders as $gender)
                                                                            <option value="{{ $gender->id }}">{{ $gender->gender_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div class="form-group col-md-6">
                                                            <p class="lable"
                                                               style="">@lang("messages.Nationality")
                                                                <span>*</span></p>
                                                            <input type="text" required class="form-control nationality"
                                                                   name="nationality"
                                                                   id="nationality"
                                                                   placeholder="@lang("messages.Enter Country Name")"
                                                                   value="{{ old('nationality') }}">

                                                        </div>
                                                    </div>

                                                    <div class="form-row" id="">
                                                        <div class="form-group col-md-6">
                                                            <p class="lable" style="">@lang("messages.your interest..")
                                                                <span>*</span></p>
                                                <textarea required class="form-control interest"
                                                          name="interest" id="interest"
                                                          placeholder="@lang("messages.Enter Your Interest")">{{ old('interest') }}</textarea>

                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <p class="lable"
                                                               style="">@lang("messages.Your Address")
                                                                <span>*</span></p>
                                                <textarea class="form-control" name="address" id="address" required
                                                          placeholder="@lang("messages.Enter Your Address")">{{ old('address') }}</textarea>

                                                        </div>
                                                    </div>

                                                    <div class="form-row" id="">
                                                        <div class="form-group col-md-6">
                                                            <p class="lable"
                                                               style="">@lang("messages.Emergency Contact Details")
                                                                <span>*</span></p>
                                                <textarea class="form-control" name="emergency_contact_details"
                                                          id="emergency_contact_details" required
                                                          placeholder="@lang("messages.Enter Emergency Contact Details")">{{ old('emergency_contact_details') }}</textarea>

                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <p class="lable"
                                                               style="">@lang("messages.Biography")
                                                                <span>*</span></p>
                                                <textarea class="form-control" name="biography" id="biography" required
                                                          placeholder="@lang("messages.Enter Your Biography")">{{ old('biography') }}</textarea>

                                                        </div>
                                                    </div>

                                                    <div class="form-row" id="volunteer_duration_date_range">
                                                        <div class="form-group col-md-6">
                                                            <p class="lable"
                                                               style="">@lang("messages.Volunteerity Start Date")
                                                                <span>*</span></p>

                                                            <div class='input-group date' id='datetimepicker2'>
                                                                <input type='text' class="form-control"
                                                                       name="start_date" id="date"
                                                                       placeholder="@lang('messages.DD/MM/YY')"
                                                                       required="1"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                                            </div>

                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <p class="lable"
                                                               style="">@lang("messages.Volunteerity End Date")
                                                                <span>*</span></p>

                                                            <div class='input-group date' id='datetimepicker3'>
                                                                <input type='text' class="form-control" name="end_date"
                                                                       id="date2"
                                                                       placeholder="@lang('messages.DD/MM/YY')"
                                                                       required="1"/>
                                                                        <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                        </span>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-row" id="">
                                                        <div class="form-group col-md-12">
                                                            <p class="lable" style="">@lang("messages.Passport No")
                                                                <span>*</span></p>
                                                            <input type="text" class="form-control" required
                                                                   name="passport_no"
                                                                   id="passport_no"
                                                                   placeholder="@lang('messages.Enter Passport No')"
                                                                   value="{{ old('passport_no') }}">

                                                        </div>

                                                    </div>

                                                    <div class="form-row" id="">
                                                        <div class="form-group col-md-6"  onclick="show_img(2)">
                                                            <p class="lable" style="">@lang("messages.Profile Image")
                                                                <span>*</span></p>
                                                            <input type="file"  id="image-upload2"  class="form-control"
                                                                   name="profile_image" required>

                                                            <div id="image-preview2" class="form-group" style="margin-top: 10px; display: none;"
                                                                    >
                                                                {{--<label for="image-upload2" id="image-label2" style="color:black">Choose
                                                                    Picture</label>
                                                                <input type="file" name="profile_image" class="input_img"
                                                                       id="image-upload2" required>--}}
                                                            </div>

                                                        </div>


                                                        <div class="form-group col-md-6" onclick="show_img(3)">
                                                            <p class="lable" style="">@lang("messages.PP Scan copy")
                                                                <span>*</span></p>
                                                            <input type="file"  class="form-control"
                                                                   name="pasport_image" required  id="image-upload3">

                                                            <div id="image-preview3" class="form-group" style="margin-top:10px; display: none;">
                                                                {{-- <label for="image-upload3" id="image-label3" style="color:black">Choose
                                                                     Passport Picture</label>
                                                                 <input type="file" name="pasport_image" class="input_img"
                                                                        id="image-upload3" required>--}}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                {{--//Portion for outside bangladeshi volunteer End--}}

                                                <div class="col-md-12 text-center">
                                                    @if(env('GOOGLE_RECAPTCHA_KEY'))
                                                        <div class="g-recaptcha"
                                                             data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                                                    @endif
                                                    <div style="margin-top: 10px" class="submit-button">
                                                        <a href="#" onclick="add_verifcation2()"
                                                           class="bnt theme-btn btn-block">@lang('messages.Send')</a>
                                                    </div>

                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>

                                    </div>
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
    .lable {
        color: white;
        text-align: left;
        font-weight: 600;
        margin-bottom: 0;
        line-height: 18px;
    }

    .lable span {
        color: red;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        text-align: left;
    }

    a {
        color: white;
    }

    .nav-tabs2 > li.active > a {
        font-weight: 700;
        background-color: #ED3237 !important;
        color: #F1F1F1 !important;
    }

    .text_lable, {
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

    /*image upload */
    #image-preview, #image-preview2, #image-preview3 {
        width: 100px;
        height: 60px;
        position: relative;
        overflow: hidden;
        background-color: #ffffff;
        color: #ecf0f1;
    }

    #image-preview input, #image-preview2 input, #image-preview3 input {
        line-height: 200px;
        font-size: 200px;
        position: absolute;
        opacity: 0;
        z-index: 10;
    }

    #image-preview label, #image-preview2 label, #image-preview3 label {
        position: absolute;
        z-index: 5;
        opacity: 0.8;
        cursor: pointer;
        background-color: #bdc3c7;
        width: 200px;
        height: 30px;
        font-size: 13px;
        line-height: 30px;
        text-transform: uppercase;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        text-align: center;
    }

    /*image upload */

</style>
@endpush

@push('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="{{ asset('la-assets/plugins/jquery-upload-preview/jquery.uploadPreview.js') }}"
        type="text/javascript"></script>

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

        $("#verification_form2").validate({
            /*errorPlacement: function(error, element) {}*/
        });
    });

    function add_verifcation() {
        $("#verification_form").submit();
    }

    function add_verifcation2() {
        $("#verification_form2").submit();
    }


    /*upload image*/
    function show_img(val) {
        if (val == 1) {

            $.uploadPreview({
                input_field: "#image-upload",   // Default: .image-upload
                preview_box: "#image-preview",  // Default: .image-preview
                label_field: "#image-label",    // Default: .image-label
                label_default: "Choose File",   // Default: Choose File
                label_selected: "Change Picture",  // Default: Change File
                no_label: false                 // Default: false
            });
            $('#image-preview').show();
        }
        else if (val == 2) {
            $('#image-preview2').show();
            $.uploadPreview({
                input_field: "#image-upload2",   // Default: .image-upload
                preview_box: "#image-preview2",  // Default: .image-preview
                label_field: "#image-label2",    // Default: .image-label
                label_default: "Choose File",   // Default: Choose File
                label_selected: "Change Picture",  // Default: Change File
                no_label: false                 // Default: false
            });
        }
        else if (val == 3) {
            $('#image-preview3').show();
            $.uploadPreview({
                input_field: "#image-upload3",   // Default: .image-upload
                preview_box: "#image-preview3",  // Default: .image-preview
                label_field: "#image-label3",    // Default: .image-label
                label_default: "Choose File",   // Default: Choose File
                label_selected: "Change Picture",  // Default: Change File
                no_label: false                 // Default: false
            });
        }

    }
    /*upload image*/


    /*replace class plugin func*/
    (function ($) {
        $.fn.replaceClass = function (pFromClass, pToClass) {
            return this.removeClass(pFromClass).addClass(pToClass);
        };
    }(jQuery));


</script>
@endpush

