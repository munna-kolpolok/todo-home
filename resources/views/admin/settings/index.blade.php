@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/settings') }}">@lang('messages.Site Settings')</a> :
@endsection
@section("section", trans("messages.Site Settings"))
@section("section_url", url(config('laraadmin.adminRoute') . '/settings'))
@section("sub_section", trans("messages.Update"))

@section("htmlheader_title", trans("messages.Site Settings"))

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
            {{ Form::open( array('url' => config('laraadmin.adminRoute').'/settings/'.$site_setting->id, 'files'=>true,
            'method'=>'PATCH', 'id' => 'site-settings-form'))}}
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
                                <h4 class="section-heading">Home Sponsor</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="scholarship_title">@lang('messages.Scholarship Title')</label>
                                        <textarea name="scholarship_title" class="form-control" id="scholarship_title"
                                                  rows="3">{{$site_setting->scholarship_title or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 30 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="scholarship_sub_title">@lang('messages.Scholarship Sub-Title')</label>
                                        <textarea name="scholarship_sub_title" class="form-control"
                                                  id="scholarship_sub_title"
                                                  rows="3">{{$site_setting->scholarship_sub_title or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 35 and Maximum 50 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="scholarship_message">@lang('messages.Scholarship Message')</label>
                                        <textarea name="scholarship_message" class="form-control"
                                                  id="scholarship_message"
                                                  rows="10">{{$site_setting->scholarship_message or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 150 and Maximum 250 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="scholarship_thumbnail_image">@lang('messages.Scholarship Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->scholarship_thumbnail_image))
                                                    <img src="{{asset($site_setting->scholarship_thumbnail_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="scholarship_thumbnail_image" class="form-control"
                                                       name="scholarship_thumbnail_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size: 1045X510px
                                                     </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="section-heading">Home Cover Project</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cover_project_name">@lang('messages.Project Name')</label>
                                        <textarea name="cover_project_name" class="form-control" id="cover_project_name"
                                                  rows="3">{{$site_setting->cover_project_name or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 15 and Maximum 25 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cover_project_title">@lang('messages.Project Title')</label>
                                        <textarea name="cover_project_title" class="form-control"
                                                  id="cover_project_title"
                                                  rows="3">{{$site_setting->cover_project_title or null}}</textarea>
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
                                        <label for="cover_project_desc">@lang('messages.Project Description')</label>
                                        <textarea name="cover_project_desc" id="cover_project_desc" rows="10"
                                                  class="form-control">{{$site_setting->cover_project_desc or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 100 and Maximum 200 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cover_project_image">@lang('messages.Project Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->cover_project_image))
                                                    <img src="{{asset($site_setting->cover_project_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="cover_project_image" class="form-control"
                                                       name="cover_project_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size: 554X426px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="section-heading">Home Feature</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cta_title_1">@lang('messages.Feature 1')</label>
                                        <textarea name="cta_title_1" class="form-control" id="cta_title_1"
                                                  rows="3">{{$site_setting->cta_title_1 or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 15 and Maximum 25 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cta_message_1">@lang('messages.Feature 1 Sort Description')</label>
                                        <textarea name="cta_message_1" class="form-control" id="cta_message_1"
                                                  rows="3">{{$site_setting->cta_message_1 or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 35 and Maximum 60 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cta_title_2">@lang('messages.Feature 2')</label>
                                        <textarea name="cta_title_2" class="form-control" id="cta_title_2"
                                                  rows="3">{{$site_setting->cta_title_2 or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 15 and Maximum 25 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cta_message_2">@lang('messages.Feature 2 Sort Description')</label>
                                        <textarea name="cta_message_2" class="form-control" id="cta_message_2"
                                                  rows="3">{{$site_setting->cta_message_2 or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 35 and Maximum 60 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cta_title_3">@lang('messages.Feature 3')</label>
                                        <textarea name="cta_title_3" class="form-control" id="cta_title_3"
                                                  rows="3">{{$site_setting->cta_title_3 or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 15 and Maximum 25 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cta_message_3">@lang('messages.Feature 3 Sort Description')</label>
                                        <textarea name="cta_message_3" class="form-control" id="cta_message_3"
                                                  rows="3">{{$site_setting->cta_message_3 or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 35 and Maximum 60 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <h4 class="section-heading">Home Help Us Section </h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="help_us_image">@lang('messages.Help Us Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->help_us_image))
                                                    <img src="{{asset($site_setting->help_us_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="help_us_image" class="form-control"
                                                       name="help_us_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size: 461X391px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="help_us_video">@lang('messages.Help Us Video Link')</label>
                                        <input type="url" name="help_us_video" class="form-control" id="help_us_video"
                                               value="{{$site_setting->help_us_video or null}}"/>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Enter a valid video url
                                            </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <h4 class="section-heading">Home Volunteer Section </h4>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="home_volunteer_desc">@lang('messages.Home Volunteer Description')</label>
                                        <textarea name="home_volunteer_desc" class="form-control" id="home_volunteer_desc"
                                                  rows="3">{{$site_setting->home_volunteer_desc or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 150 and Maximum 200 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="home_volunteer_image">@lang('messages.Home Volunteer Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->home_volunteer_image))
                                                    <img src="{{asset($site_setting->home_volunteer_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="home_volunteer_image" class="form-control"
                                                       name="home_volunteer_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size: 828X545px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <h4 class="section-heading">Home Our Mission Section </h4>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="home_mission_desc">@lang('messages.Home Mission Description')</label>
                                        <textarea name="home_mission_desc" class="form-control" id="home_mission_desc"
                                                  rows="5">{{$site_setting->home_mission_desc or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 500 and Maximum 800 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="home_mission_food">@lang('messages.Home Mission Food')</label>
                                        <textarea name="home_mission_food" class="form-control" id="home_mission_food"
                                                  rows="3">{{$site_setting->home_mission_food or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 70 and Maximum 80 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="home_mission_education">@lang('messages.Home Mission Education')</label>
                                        <textarea name="home_mission_education" class="form-control" id="home_mission_education"
                                                  rows="3">{{$site_setting->home_mission_education or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 70 and Maximum 80 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="home_mission_treatment">@lang('messages.Home Mission Treatment')</label>
                                        <textarea name="home_mission_treatment" class="form-control" id="home_mission_treatment"
                                                  rows="3">{{$site_setting->home_mission_treatment or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 70 and Maximum 80 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <h4 class="section-heading">Home Subscribe us Section</h4>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subscribe_image">@lang('messages.Subscribe Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->subscribe_image))
                                                    <img src="{{asset($site_setting->subscribe_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="subscribe_image" class="form-control"
                                                       name="subscribe_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size: 564X275px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--About setting--}}
                    <div id="menu1" class="tab-pane fade"><br>

                        <div id="about-tab-wrapper" style="padding: 10px 0 25px 0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_title">@lang('messages.About Title')</label>
                                        <textarea name="about_title" id="about_title" rows="2"
                                                  class="form-control">{{$site_setting->about_title or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_sub_title">@lang('messages.About Sub Title')</label>
                                        <textarea name="about_sub_title" id="about_sub_title" rows="2"
                                                  class="form-control">{{$site_setting->about_sub_title or null}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_short_brief">@lang('messages.About Short Description')</label>
                                        <textarea name="about_short_brief" id="about_short_brief" rows="10"
                                                  class="form-control">{{$site_setting->about_short_brief or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="our_story">@lang('messages.Our Story')</label>
                                        <textarea name="our_story" id="our_story" rows="10"
                                                  class="form-control">{{$site_setting->our_story or null}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_vision_image">@lang('messages.About Vision & Mission Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->about_vision_image))
                                                    <img src="{{asset($site_setting->about_vision_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="about_vision_image" class="form-control"
                                                       name="about_vision_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:80X70px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_story_image">@lang('messages.About Story Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->about_story_image))
                                                    <img src="{{asset($site_setting->about_story_image)}}"
                                                         alt="About Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="about_story_image" class="form-control"
                                                       name="about_story_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:80X70px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="vission">@lang('messages.Vision')</label>
                                        <textarea name="vission" id="vission" rows="10"
                                                  class="form-control">{{$site_setting->vission or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mission">@lang('messages.Mission')</label>
                                        <textarea name="mission" id="mission" rows="10"
                                                  class="form-control">{{$site_setting->mission or null}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="where_we_work">@lang('messages.Where We Work')</label>
                                        <textarea name="where_we_work" id="where_we_work" rows="10"
                                                  class="form-control">{{$site_setting->where_we_work or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_work_image">@lang('messages.About Work Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->about_work_image))
                                                    <img src="{{asset($site_setting->about_work_image)}}"
                                                         alt="About Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="about_work_image" class="form-control"
                                                       name="about_work_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:80X70px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_video">@lang('messages.Video Link')</label>
                                        <textarea name="about_video" class="form-control" id="about_video"
                                                  rows="3">{{$site_setting->about_video or null}}</textarea>
                                        <span class="suggestion_text">
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_video_poster_image">@lang('messages.Video Poster Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->about_video_poster_image))
                                                    <img src="{{asset($site_setting->about_video_poster_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="about_video_poster_image" class="form-control"
                                                       name="about_video_poster_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:550X470px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sign_up_donor_message">@lang('messages.Sign Up Message')</label>
                                        <textarea name="sign_up_donor_message" class="form-control"
                                                  id="sign_up_donor_message"
                                                  rows="3">{{$site_setting->sign_up_donor_message or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="signup_donor_image">@lang('messages.Sign Up Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->signup_donor_image))
                                                    <img src="{{asset($site_setting->signup_donor_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="signup_donor_image" class="form-control"
                                                       name="signup_donor_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:554X426px
                                </span>
                                            </div>
                                        </div>
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

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logo">@lang('messages.Site Logo')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->logo))
                                                    <img src="{{asset($site_setting->logo)}}" alt="About Image"
                                                         width="80px"
                                                         height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="logo" class="form-control" name="logo"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:283X65px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="favicon">@lang('messages.Site Favicon')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->favicon))
                                                    <img src="{{asset($site_setting->favicon)}}" alt="About Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
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
                            </div>
                            <div class="row">
                                <h4 class="section-heading">Header Image</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_background_image">@lang('messages.About Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->about_background_image))
                                                    <img src="{{asset($site_setting->about_background_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="about_background_image" class="form-control"
                                                       name="about_background_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:1920X390px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_background_image">@lang('messages.Contact Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->contact_background_image))
                                                    <img src="{{asset($site_setting->contact_background_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="contact_background_image" class="form-control"
                                                       name="contact_background_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:1920X390px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gallery_background_image">@lang('messages.Gallery Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->gallery_background_image))
                                                    <img src="{{asset($site_setting->gallery_background_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="gallery_background_image" class="form-control"
                                                       name="gallery_background_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="video_banner_image">@lang('messages.Video Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->video_banner_image))
                                                    <img src="{{asset($site_setting->video_banner_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="video_banner_image" class="form-control"
                                                       name="video_banner_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:1920X390px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="press_banner_image">@lang('messages.Press Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->press_banner_image))
                                                    <img src="{{asset($site_setting->press_banner_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="press_banner_image" class="form-control"
                                                       name="press_banner_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:1920X390px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="faq_background_image">@lang('messages.FAQ Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->faq_background_image))
                                                    <img src="{{asset($site_setting->faq_background_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="faq_background_image" class="form-control"
                                                       name="faq_background_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:1920X390px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bank_info_banner_image">@lang('messages.Bank Info Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->bank_info_banner_image))
                                                    <img src="{{asset($site_setting->bank_info_banner_image)}}"
                                                         alt="Bank info Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="bank_info_banner_image" class="form-control"
                                                       name="bank_info_banner_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:1920X390px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bank_info_banner_image">@lang('messages.Branch Info Header Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->branch_info_banner_image))
                                                    <img src="{{asset($site_setting->branch_info_banner_image)}}"
                                                         alt="Bank info Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="branch_info_banner_image" class="form-control"
                                                       name="branch_info_banner_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:1920X390px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="campaign_banner_image">@lang('messages.Campaign banner image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->campaign_banner_image))
                                                    <img src="{{asset($site_setting->campaign_banner_image)}}"
                                                         alt="Bank info Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="campaign_banner_image" class="form-control"
                                                       name="campaign_banner_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:1920X390px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="campaign_details_banner_image">@lang('messages.Campaign details banner image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->campaign_details_banner_image))
                                                    <img src="{{asset($site_setting->campaign_details_banner_image)}}"
                                                         alt="Bank info Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="campaign_details_banner_image" class="form-control"
                                                       name="campaign_details_banner_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:1920X390px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <h4 class="section-heading">SignIn and SignUp Page Image</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sign_in_image">@lang('messages.SignIn Focus Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->sign_in_image))
                                                    <img src="{{asset($site_setting->sign_in_image)}}" alt="About Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="sign_in_image" class="form-control"
                                                       name="sign_in_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:292X350px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sign_up_image">@lang('messages.SignUp Focus Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->sign_up_image))
                                                    <img src="{{asset($site_setting->sign_up_image)}}" alt="About Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="sign_up_image" class="form-control"
                                                       name="sign_up_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:294X314px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--donation and volunteer page image--}}
                            <div class="row">
                                <h4 class="section-heading">Volunteer and Donation page</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="donation_form_bg_image">@lang('messages.Donation page background')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->donation_form_bg_image))
                                                    <img src="{{asset($site_setting->donation_form_bg_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="donation_form_bg_image" class="form-control"
                                                       name="donation_form_bg_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:1920X850px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="volunteers_form_bg_image">@lang('messages.Volunteers page background')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->volunteers_form_bg_image))
                                                    <img src="{{asset($site_setting->volunteers_form_bg_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="volunteers_form_bg_image" class="form-control"
                                                       name="volunteers_form_bg_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:1920X850px
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
                                <h4 class="section-heading">Donate Page</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="donate_video_link">@lang('messages.Donate Video Link')</label>
                                        <textarea name="donate_video_link" class="form-control" id="donate_video_link"
                                                  rows="2">{{$site_setting->donate_video_link or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="signup_donor_image">@lang('messages.Donate Video Poster Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->donate_poster_image))
                                                    <img src="{{asset($site_setting->donate_poster_image)}}"
                                                         alt="About Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image"
                                                         width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="donate_poster_image" class="form-control"
                                                       name="donate_poster_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:550X470px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

