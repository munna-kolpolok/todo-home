@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/ahar_settings') }}"><img src="{{asset($site_setting->logo)}}"
                                                                                height="45"
                                                                                alt="logo"> @lang('messages.Ahar Site Settings')
    </a> :
@endsection
@section("section", trans("messages.Ahar Site Settings"))
@section("section_url", url(config('laraadmin.adminRoute') . '/ahar_settings'))
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
                        <a class="nav-link" data-toggle="tab" href="#home">Home Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu1">About Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu2">Images</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu3">Other's</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    {{--Home settings--}}
                    <div id="home" class="tab-pane active"><br>

                        <div id="home-tab-wrapper" style="padding: 10px 0 25px 0">
                            <div class="row">
                                <h4 class="section-heading">Who We Section / Under Slider</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_title">@lang('messages.About title')</label>
                                        <textarea name="about_title" class="form-control" id="about_title"
                                                  rows="3">{{$site_setting->about_title or null}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_short_brief">@lang('messages.About Short Brief')</label>
                                        <textarea name="about_short_brief" id="about_short_brief" rows="3"
                                                  class="form-control">{{$site_setting->about_short_brief or null}}</textarea>
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
                                        <label for="donation_feature_1">@lang('messages.Donation feature line-1')</label>
                                        <input name="donation_feature_1" class="form-control"
                                               value="{{$site_setting->donation_feature_1 or null}}"
                                               id="donation_feature_1">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="donation_feature_2">@lang('messages.Donation feature line-2')</label>
                                        <input name="donation_feature_2" class="form-control"
                                               value="{{$site_setting->donation_feature_2 or null}}"
                                               id="donation_feature_2">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="donation_feature_3">@lang('messages.Donation feature line-3')</label>
                                        <input name="donation_feature_3" class="form-control"
                                               value="{{$site_setting->donation_feature_3 or null}}"
                                               id="donation_feature_3">
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
                                        <label for="volunteers_feature_1">@lang('messages.Volunteers feature line-1')</label>
                                        <input name="volunteers_feature_1" class="form-control"
                                               value="{{$site_setting->volunteers_feature_1 or null}}"
                                               id="volunteers_feature_1">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="volunteers_feature_2">@lang('messages.Volunteers feature line-2')</label>
                                        <input name="volunteers_feature_2" class="form-control"
                                               value="{{$site_setting->volunteers_feature_2 or null}}"
                                               id="volunteers_feature_2">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="volunteers_feature_3">@lang('messages.Volunteers feature line-3')</label>
                                        <input name="volunteers_feature_3" class="form-control"
                                               value="{{$site_setting->volunteers_feature_3 or null}}"
                                               id="volunteers_feature_3">
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
                                        <label for="sponsor_feature_1">@lang('messages.Sponsor a kid feature line-1')</label>
                                        <input name="sponsor_feature_1" class="form-control"
                                               value="{{$site_setting->sponsor_feature_1 or null}}"
                                               id="sponsor_feature_1">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sponsor_feature_2">@lang('messages.Sponsor a kid feature line-2')</label>
                                        <input name="sponsor_feature_2" class="form-control"
                                               value="{{$site_setting->sponsor_feature_2 or null}}"
                                               id="sponsor_feature_2">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sponsor_feature_3">@lang('messages.Sponsor a kid feature line-3')</label>
                                        <input name="sponsor_feature_3" class="form-control"
                                               value="{{$site_setting->sponsor_feature_3 or null}}"
                                               id="sponsor_feature_3">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <h4 class="section-heading">Cover Projects Section & Popular Food Project Message</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="home_highlighted_message_title">@lang('messages.Cover Title')</label>
                                        <textarea name="home_highlighted_message_title" class="form-control"
                                                  id="home_highlighted_message_title"
                                                  rows="1">{{$site_setting->home_highlighted_message_title or null}}</textarea>
                                                <span class="suggestion_text">
                                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                    Minimum 10 and Maximum 20 Character.
                                                </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="home_highlighted_image">@lang('messages.Home Cover Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->home_highlighted_image))
                                                    <img src="{{asset($site_setting->home_highlighted_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="home_highlighted_image" class="form-control"
                                                       name="home_highlighted_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                     <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                      aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size: 1920X1080px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="home_highlighted_message_description">@lang('messages.Cover Project Description')</label>
                                        <textarea name="home_highlighted_message_description"
                                                  id="home_highlighted_message_description" rows="3"
                                                  class="form-control">{{$site_setting->home_highlighted_message_description or null}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 100 and Maximum 200 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="home_highlighted_message_description">@lang('messages.Popular Food Project Message')</label>
                                        <textarea name="popular_project_message"
                                                  id="home_highlighted_message_description" rows="3"
                                                  class="form-control">{{$site_setting->popular_project_message or null}}</textarea>
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
                                        <label for="donate_title">@lang('messages.Donate Title')</label>
                                        <textarea name="donate_title"
                                                  id="donate_title" rows="3"
                                                  class="form-control">{{$site_setting->donate_title or null}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="donate_message">@lang('messages.Donate Message')</label>
                                        <textarea name="donate_message"
                                                  id="donate_message" rows="3"
                                                  class="form-control">{{$site_setting->donate_message or null}}</textarea>
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
                                        <label for="sponsor_monthly_food_cost ">@lang('messages.Sponsor Monthly Food Cost')</label>
                                        <input type="number" name="sponsor_monthly_food_cost"
                                               value="{{$site_setting->sponsor_monthly_food_cost  or null}}"
                                               id="sponsor_monthly_food_cost "
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sponsor_min_no_person">@lang('messages.Sponsor min no person')</label>
                                        <input type="number" name="sponsor_min_no_person"
                                               value="{{$site_setting->sponsor_min_no_person or null}}"
                                               id="sponsor_min_no_person"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="max_no_unit">@lang('messages.Max no unit')</label>
                                        <input type="number" name="max_no_unit"
                                               value="{{$site_setting->max_no_unit or null}}"
                                               id="max_no_unit"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="section-heading">Volunteers Section</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="volunteers_title">@lang('messages.Volunteers Title')</label>
                                        <textarea name="volunteers_title" class="form-control"
                                                  id="volunteers_title"
                                                  rows="1">{{$site_setting->volunteers_title or null}}</textarea>
                                                <span class="suggestion_text">
                                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                    Minimum 10 and Maximum 20 Character.
                                                </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="volunteers_bg_image">@lang('messages.Volunteers Background Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->volunteers_bg_image))
                                                    <img src="{{asset($site_setting->volunteers_bg_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="volunteers_bg_image" class="form-control"
                                                       name="volunteers_bg_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                     <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                      aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size: 1920X1000px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="volunteers_message">@lang('messages.Volunteers Description')</label>
                                        <textarea name="volunteers_message"
                                                  id="volunteers_message" rows="3"
                                                  class="form-control">{{$site_setting->volunteers_message or null}}</textarea>
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
                                        <label for="about_story">@lang('messages.Our Story')</label>
                                        <textarea name="about_story" id="about_story" rows="5"
                                                  class="form-control">{{$site_setting->about_story or null}}</textarea><span
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
                                        <label for="about_vision">@lang('messages.Vision')</label>
                                        <textarea name="about_vision" id="about_vision" rows="6"
                                                  class="form-control">{{$site_setting->about_vision or null}}</textarea><span
                                                class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 100 and Maximum 200 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_mission">@lang('messages.Mission')</label>
                                        <textarea name="about_mission" id="about_mission" rows="6"
                                                  class="form-control">{{$site_setting->about_mission or null}}</textarea>
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
                                        <label for="about_helping_section_title">@lang('messages.Section Title')</label>
                                        <textarea name="about_helping_section_title" class="form-control"
                                                  id="about_helping_section_title"
                                                  rows="3">{{$site_setting->about_helping_section_title or null}}</textarea><span
                                                class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 20 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_helping_section_message">@lang('messages.Section Description')</label>
                                        <textarea name="about_helping_section_message" class="form-control"
                                                  id="about_helping_section_message"
                                                  rows="3">{{$site_setting->about_helping_section_message or null}}</textarea>
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
                                        <label for="about_donation_message">@lang('messages.About Donation Message')</label>
                                        <textarea name="about_donation_message" class="form-control"
                                                  id="about_donation_message"
                                                  rows="3">{{$site_setting->about_donation_message or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 50 and Maximum 100 Character.
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_volunteers_message">@lang('messages.About Volunteers Message')</label>
                                        <textarea name="about_volunteers_message" class="form-control"
                                                  id="about_volunteers_message"
                                                  rows="3">{{$site_setting->about_volunteers_message or null}}</textarea>
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
                        </div>

                    </div>
                    {{--Images Setting--}}
                    <div id="menu2" class="tab-pane fade"><br>

                        <div id="contact-tab-wrapper" style="padding: 10px 0 25px 0">
                            <div class="row">
                                <h4 class="section-heading">Logo and FavIcon</h4>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="logo">@lang('messages.Site Logo')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->logo))
                                                    <img src="{{asset($site_setting->logo)}}" alt="Site Logo"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="logo" class="form-control" name="logo"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                 <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                  aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:283X65px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="favicon">@lang('messages.Site Favicon')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->favicon))
                                                    <img src="{{asset($site_setting->favicon)}}" alt="Site Favicon"
                                                         width="32px" height="32">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="favicon" class="form-control" name="favicon"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg,png. Size:32X32px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="section_icon">@lang('messages.Section Icon')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->section_icon))
                                                    <img src="{{asset($site_setting->section_icon)}}" alt="icon"
                                                         width="32px" height="32">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="section_icon" class="form-control"
                                                       name="section_icon"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg,png. Size:32X32px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="section-heading">Header Image</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_us_header">@lang('messages.About Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->about_us_header))
                                                    <img src="{{asset($site_setting->about_us_header)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="about_us_header" class="form-control"
                                                       name="about_us_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:1920X466px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_us_header">@lang('messages.Contact Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->contact_us_header))
                                                    <img src="{{asset($site_setting->contact_us_header)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="contact_us_header" class="form-control"
                                                       name="contact_us_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:1920X466px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="donor_profile_header">@lang('messages.Donor Profile Header')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->donor_profile_header))
                                                    <img src="{{asset($site_setting->donor_profile_header)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="donor_profile_header" class="form-control"
                                                       name="donor_profile_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:1920X466px
                                </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="donation_clarification_header">@lang('messages.Donation Clarification Header')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->donation_clarification_header))
                                                    <img src="{{asset($site_setting->donation_clarification_header)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="donation_clarification_header"
                                                       class="form-control"
                                                       name="donation_clarification_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:1920X466px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bank_info_header">@lang('messages.Bank Info Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->bank_info_header))
                                                    <img src="{{asset($site_setting->bank_info_header)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="bank_info_header" class="form-control"
                                                       name="bank_info_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:1920X466px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sponsor_header">@lang('messages.Sponsor Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->sponsor_header))
                                                    <img src="{{asset($site_setting->sponsor_header)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="sponsor_header" class="form-control"
                                                       name="sponsor_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:1920X466px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="package_header">@lang('messages.Package Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->package_header))
                                                    <img src="{{asset($site_setting->package_header)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="package_header" class="form-control"
                                                       name="package_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:1920X466px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="faq_header">@lang('messages.FAQ Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->faq_header))
                                                    <img src="{{asset($site_setting->faq_header)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="faq_header" class="form-control"
                                                       name="faq_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:1920X466px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gallery_header">@lang('messages.Gallery Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->gallery_header))
                                                    <img src="{{asset($site_setting->gallery_header)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="gallery_header" class="form-control"
                                                       name="gallery_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:1920X466px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="press_header">@lang('messages.Press Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->press_header))
                                                    <img src="{{asset($site_setting->press_header)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="press_header" class="form-control"
                                                       name="press_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:1920X466px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="video_album_header">@lang('messages.Video Album Header')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->video_album_header))
                                                    <img src="{{asset($site_setting->video_album_header)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="video_album_header" class="form-control"
                                                       name="video_album_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:1920X466px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="video_list_header">@lang('messages.Video Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->video_list_header))
                                                    <img src="{{asset($site_setting->video_list_header)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="video_list_header" class="form-control"
                                                       name="video_list_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:1920X466px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sign_in_header">@lang('messages.Sign In Header')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->sign_in_header))
                                                    <img src="{{asset($site_setting->sign_in_header)}}"
                                                         alt="About Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="sign_in_header" class="form-control"
                                                       name="sign_in_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:292X350px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sign_up_header">@lang('messages.Sign Up Header')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->sign_up_header))
                                                    <img src="{{asset($site_setting->sign_up_header)}}" alt="Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="sign_up_header" class="form-control"
                                                       name="sign_up_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:294X314px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="forgot_password_header">@lang('messages.Forgot Password Header')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->forgot_password_header))
                                                    <img src="{{asset($site_setting->forgot_password_header)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="forgot_password_header" class="form-control"
                                                       name="forgot_password_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:1920X466px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reset_password_header">@lang('messages.Reset Password Header')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->reset_password_header))
                                                    <img src="{{asset($site_setting->reset_password_header)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="reset_password_header" class="form-control"
                                                       name="reset_password_header"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:1920X466px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--other setting--}}
                    <div id="menu3" class="tab-pane fade"><br>

                        <div id="about-tab-wrapper" style="padding: 10px 0 25px 0">
                            <div class="row">
                                <h4 class="section-heading">Footer Info</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="organization_name">@lang('messages.Organization Name')</label>
                                        <input class="form-control" type="text" name="organization_name"
                                               id="organization_name"
                                               value="{{$site_setting->organization_name or null}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_email">@lang('messages.Contact Email')</label>
                                        <input class="form-control" type="text" name="contact_email" id="contact_email"
                                               value="{{$site_setting->contact_email or null}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_address">@lang('messages.Contact Address')</label>
                                        <textarea name="contact_address" id="contact_address" class="form-control"
                                                  rows="2">{{$site_setting->contact_address or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_no">@lang('messages.Contact Number')</label>
                                        <textarea name="contact_no" id="contact_no" rows="2"
                                                  class="form-control">{{$site_setting->contact_no or null}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="section-heading">Social Media Contact Link</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="fa fa-facebook-square" style="margin-right: 10px; color:#009CE4;"></i><label
                                                for="facebook_social_link"> @lang('messages.Facebook URL')</label>
                                        <input type="text" name="facebook_social_link" id="facebook_social_link" rows="1"
                                                  class="form-control" value="{{$site_setting->facebook_social_link or null}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="fa fa-google-plus-circle" style="margin-right: 10px; color:#DC4E41;"></i><label
                                                for="goole_plus_social_link"> @lang('messages.Google Plus URL')</label>
                                        <input type="text" name="goole_plus_social_link" id="goole_plus_social_link" rows="1"
                                                  class="form-control" value="{{$site_setting->goole_plus_social_link or null}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="fa fa-twitter-square" style="margin-right: 10px;color:#009CE4;"></i><label
                                                for="twitter_social_link"> @lang('messages.Twitter URL')</label>
                                        <input type="text" name="twitter_social_link" id="twitter_social_link" rows="1"
                                                  class="form-control" value="{{$site_setting->twitter_social_link or null}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="fa fa-instagram" style="margin-right: 10px; color:#B26266;"></i><label
                                                for="instagram_social_link"> @lang('messages.Instagram URL')</label>
                                        <input type="text" name="instagram_social_link" id="instagram_social_link" rows="1"
                                                  class="form-control" value="{{$site_setting->instagram_social_link or null}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="fa fa-linkedin-square" style="margin-right: 10px;"></i><label
                                                for="linkdin_social_link"> @lang('messages.Linkdin URL')</label>
                                        <input type="text" name="linkdin_social_link" id="linkdin_social_link" rows="1"
                                                  class="form-control" value="{{$site_setting->linkdin_social_link or null}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="fa fa-youtube" style="margin-right: 10px;"></i><label
                                                for="youtube_social_link"> @lang('messages.Youtube Link')</label>
                                        <input type="text" name="youtube_social_link"  value="{{$site_setting->youtube_social_link or null}}" id="youtube_social_link"  class="form-control">
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

