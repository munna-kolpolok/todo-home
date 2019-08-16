@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/bn_ahar_settings') }}"><img src="{{asset($site_setting->logo)}}"
                                                                                height="45"
                                                                                alt="logo"> @lang('messages.Ahar Site Settings') Bangla
    </a> :
@endsection
@section("section", trans("messages.Ahar Site Settings"))
@section("section_url", url(config('laraadmin.adminRoute') . '/bn_ahar_settings'))
@section("sub_section", trans("messages.Update"))

@section("htmlheader_title", trans("messages.Ahar Site Settings"))

@section("main-content")
    <style type="text/css">
        #save_div {
            display: none;
        }

        .section-heading {
            margin: 0 15px;
            color: #000;
            background-color: #eee;
            padding: 10px 0;
            text-align: center;
            margin-bottom: 10px;
        }

        .suggestion_text {
            color: green;
            font-size: 12px;
        }
    </style>
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(Session::has('seccess_msg'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{ Session::get('seccess_msg') }}</strong>
        </div>
    @endif

    <?php //print_r($groups); die(); ?>
    <div class="box box-success">
        <div class="box-body">
            {{ Form::open( array('url' => config('laraadmin.adminRoute').'/ahar_settings/'.$site_setting->id, 'files'=>true, 'method'=>'PATCH', 'id' => 'site-settings-form'))}}
            <div id="payment-tab">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item active">
                        <a class="nav-link" data-toggle="tab" href="#home">Home Page Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu1">About & Contact Setting</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    {{--Home settings--}}
                    <div id="home" class="tab-pane active"><br>

                        <div id="home-tab-wrapper" style="padding: 10px 0 25px 0">
                            <div class="row">
                                <input type="hidden" name="redirect" value="2">
                                <h4 class="section-heading">Who We Section / Under Slider</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_title_bn">About title Bangla</label>
                                        <textarea name="about_title_bn" class="form-control" id="about_title_bn"
                                                  rows="3">{{$site_setting->about_title_bn or null}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bn_about_short_brief">About Short Brief Bangla</label>
                                        <textarea name="bn_about_short_brief" id="bn_about_short_brief" rows="3"
                                                  class="form-control">{{$site_setting->bn_about_short_brief or null}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 100 and Maximum 200 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="donation_feature_bn_1">@lang('messages.Donation feature line-1')</label>
                                        <input name="donation_feature_bn_1" class="form-control"
                                               value="{{$site_setting->donation_feature_bn_1 or null}}"
                                               id="donation_feature_bn_1">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="donation_feature_bn_2">@lang('messages.Donation feature line-2')</label>
                                        <input name="donation_feature_bn_2" class="form-control"
                                               value="{{$site_setting->donation_feature_bn_2 or null}}"
                                               id="donation_feature_bn_2">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="donation_feature_bn_3">@lang('messages.Donation feature line-3')</label>
                                        <input name="donation_feature_bn_3" class="form-control"
                                               value="{{$site_setting->donation_feature_bn_3 or null}}"
                                               id="donation_feature_bn_3">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="volunteers_feature_bn_1">@lang('messages.Volunteers feature line-1')</label>
                                        <input name="volunteers_feature_bn_1" class="form-control"
                                               value="{{$site_setting->volunteers_feature_bn_1 or null}}"
                                               id="volunteers_feature_bn_1">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="volunteers_feature_bn_2">@lang('messages.Volunteers feature line-2')</label>
                                        <input name="volunteers_feature_bn_2" class="form-control"
                                               value="{{$site_setting->volunteers_feature_bn_2 or null}}"
                                               id="volunteers_feature_bn_2">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="volunteers_feature_bn_3">@lang('messages.Volunteers feature line-3')</label>
                                        <input name="volunteers_feature_bn_3" class="form-control"
                                               value="{{$site_setting->volunteers_feature_bn_3 or null}}"
                                               id="volunteers_feature_bn_3">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sponsor_feature_bn_1">@lang('messages.Sponsor a kid feature line-1')</label>
                                        <input name="sponsor_feature_bn_1" class="form-control"
                                               value="{{$site_setting->sponsor_feature_bn_1 or null}}"
                                               id="sponsor_feature_bn_1">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sponsor_feature_bn_2">@lang('messages.Sponsor a kid feature line-2')</label>
                                        <input name="sponsor_feature_bn_2" class="form-control"
                                               value="{{$site_setting->sponsor_feature_bn_2 or null}}"
                                               id="sponsor_feature_bn_2">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sponsor_feature_bn_3">@lang('messages.Sponsor a kid feature line-3')</label>
                                        <input name="sponsor_feature_bn_3" class="form-control"
                                               value="{{$site_setting->sponsor_feature_bn_3 or null}}"
                                               id="sponsor_feature_bn_3">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <h4 class="section-heading">Cover Projects Section & Popular Food Project Message</h4>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="home_highlighted_message_title_bn">@lang('messages.Cover Title')</label>
                                        <textarea name="home_highlighted_message_title_bn" class="form-control"
                                                  id="home_highlighted_message_title_bn"
                                                  rows="1">{{$site_setting->home_highlighted_message_title_bn or null}}</textarea>
                                                <span class="suggestion_text">
                                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                    Minimum 10 and Maximum 20 Character.
                                                </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="home_highlighted_message_description_bn">@lang('messages.Cover Project Description')</label>
                                        <textarea name="home_highlighted_message_description_bn"
                                                  id="home_highlighted_message_description_bn" rows="3"
                                                  class="form-control">{{$site_setting->home_highlighted_message_description_bn or null}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 100 and Maximum 200 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="popular_project_message_bn">@lang('messages.Popular Food Project Message')</label>
                                        <textarea name="popular_project_message_bn"
                                                  id="popular_project_message_bn" rows="3"
                                                  class="form-control">{{$site_setting->popular_project_message_bn or null}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 100 and Maximum 200 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="section-heading">Donation Section</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="donate_title_bn">@lang('messages.Donate Title')</label>
                                        <textarea name="donate_title_bn"
                                                  id="donate_title_bn" rows="3"
                                                  class="form-control">{{$site_setting->donate_title_bn or null}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="donate_message_bn">@lang('messages.Donate Message')</label>
                                        <textarea name="donate_message_bn"
                                                  id="donate_message_bn" rows="3"
                                                  class="form-control">{{$site_setting->donate_message_bn or null}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 100 and Maximum 200 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="section-heading">Volunteers Section</h4>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="volunteers_title_bn">@lang('messages.Volunteers Title')</label>
                                        <textarea name="volunteers_title_bn" class="form-control"
                                                  id="volunteers_title_bn"
                                                  rows="1">{{$site_setting->volunteers_title_bn or null}}</textarea>
                                                <span class="suggestion_text">
                                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                    Minimum 10 and Maximum 20 Character.
                                                </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="volunteers_message_bn">@lang('messages.Volunteers Description')</label>
                                        <textarea name="volunteers_message_bn"
                                                  id="volunteers_message_bn" rows="3"
                                                  class="form-control">{{$site_setting->volunteers_message_bn or null}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 100 and Maximum 200 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    {{--About setting--}}
                    <div id="menu1" class="tab-pane fade"><br>

                        <div id="about-tab-wrapper" style="padding: 10px 0 25px 0">

                            <div class="row">
                                <h4 class="section-heading">About page section 1</h4>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="about_story_bn">@lang('messages.Our Story')</label>
                                        <textarea name="about_story_bn" id="about_story_bn" rows="5"
                                                  class="form-control">{{$site_setting->about_story_bn or null}}</textarea><span
                                                class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 100 and Maximum 200 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_vision_bn">@lang('messages.Vision')</label>
                                        <textarea name="about_vision_bn" id="about_vision_bn" rows="6"
                                                  class="form-control">{{$site_setting->about_vision_bn or null}}</textarea><span
                                                class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 100 and Maximum 200 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_mission_bn">@lang('messages.Mission')</label>
                                        <textarea name="about_mission_bn" id="about_mission_bn" rows="6"
                                                  class="form-control">{{$site_setting->about_mission_bn or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 100 and Maximum 200 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <h4 class="section-heading">About page section 2</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_helping_section_title_bn">@lang('messages.Section Title')</label>
                                        <textarea name="about_helping_section_title_bn" class="form-control"
                                                  id="about_helping_section_title_bn"
                                                  rows="3">{{$site_setting->about_helping_section_title_bn or null}}</textarea><span
                                                class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_helping_section_message_bn">@lang('messages.Section Description')</label>
                                        <textarea name="about_helping_section_message_bn" class="form-control"
                                                  id="about_helping_section_message_bn"
                                                  rows="3">{{$site_setting->about_helping_section_message_bn or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 50 and Maximum 100 Character.
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_donation_message_bn">@lang('messages.About Donation Message')</label>
                                        <textarea name="about_donation_message_bn" class="form-control"
                                                  id="about_donation_message_bn"
                                                  rows="3">{{$site_setting->about_donation_message_bn or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 50 and Maximum 100 Character.
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_volunteers_message_bn">@lang('messages.About Volunteers Message')</label>
                                        <textarea name="about_volunteers_message_bn" class="form-control"
                                                  id="about_volunteers_message_bn"
                                                  rows="3">{{$site_setting->about_volunteers_message_bn or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 50 and Maximum 100 Character.
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_contact_message">@lang('messages.About Contact Message')</label>
                                        <textarea name="about_contact_message" class="form-control"
                                                  id="about_contact_message"
                                                  rows="3">{{$site_setting->about_contact_message or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 50 and Maximum 100 Character.
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_project_message">@lang('messages.About project Message')</label>
                                        <textarea name="about_project_message" class="form-control"
                                                  id="about_project_message"
                                                  rows="3">{{$site_setting->about_project_message or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 50 and Maximum 100 Character.
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row"><br>
                                <h4 class="section-heading">Contact Address</h4>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="bn_contact_address">@lang('messages.Contact Address')</label>
                                        <textarea name="bn_contact_address" id="bn_contact_address" class="form-control"
                                                  rows="2">{{$site_setting->bn_contact_address or null}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>


            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!}
                    <a class="btn btn-default"
                       href="{{ url(config('laraadmin.adminRoute')) }}">@lang('messages.Cancel')</a>
                </div>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection


@push('scripts')
<script>
    $(function () {
        $("#site-settings-form").validate({});
        $(".nav-tabs a").click(function () {
            console.log(this);
            $(this).tab('show');
        });

    });
</script>
@endpush

