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
            margin:0 15px;
            color: #000;
            background-color: #eee;
            padding: 10px 0;
            text-align: center;
            margin-bottom: 10px;
        }
        .suggestion_text{
        color:green;
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
            {{ Form::open( array('url' => config('laraadmin.adminRoute').'/settings/'.$site_setting->id, 'files'=>true, 'method'=>'PATCH', 'id' => 'site-settings-form'))}}
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
                                            <label for="scholarship_title">@lang('messages.Scholarship Title Bangla')</label>
                                            <input type="hidden" name="redirect" value="1">
                                            <textarea placeholder="@lang('messages.Scholarship Title Bangla')" name="bn_scholarship_title" class="form-control" id="bn_scholarship_title" rows="3">{{$site_setting->bn_scholarship_title or null}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 30 Character.
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="scholarship_sub_title">@lang('messages.Scholarship Sub-Title Bangla')</label>
                                            <textarea name="bn_scholarship_sub_title" class="form-control" id="bn_scholarship_sub_title" rows="3">{{$site_setting->bn_scholarship_sub_title or null}}</textarea>
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

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="scholarship_message">@lang('messages.Scholarship Message Bangla')</label>
                                            <textarea name="bn_scholarship_message" class="form-control" id="bn_scholarship_message" rows="5">{{$site_setting->bn_scholarship_message or null}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 150 and Maximum 250 Character.
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h4 class="section-heading">Home Cover Project</h4>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cover_project_name">@lang('messages.Project Name Bangla')</label>
                                            <textarea name="bn_cover_project_name" class="form-control" id="bn_cover_project_name" rows="3">{{$site_setting->bn_cover_project_name or null}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 15 and Maximum 25 Character.
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cover_project_title">@lang('messages.Project Title Bangla')</label>
                                            <textarea name="bn_cover_project_title" class="form-control" id="bn_cover_project_title" rows="3">{{$site_setting->bn_cover_project_title or null}}</textarea>
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
                                            <label for="cover_project_desc">@lang('messages.Project Description Bangla')</label>
                                            <textarea name="bn_cover_project_desc" id="bn_cover_project_desc"  rows="5" class="form-control">{{$site_setting->bn_cover_project_desc or null}}</textarea>
                                            <span class="suggestion_text" >
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 100 and Maximum 200 Character.
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h4 class="section-heading">Home Feature</h4>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cta_title_1">@lang('messages.Feature 1 Bangla')</label>
                                            <textarea name="bn_cta_title_1" class="form-control" id="bn_cta_title_1" rows="3">{{$site_setting->bn_cta_title_1 or null}}</textarea>
                                            <span  class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 15 and Maximum 25 Character.
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cta_message_1">@lang('messages.Feature 1 Sort Description Bangla')</label>
                                            <textarea name="bn_cta_message_1" class="form-control" id="bn_cta_message_1" rows="3">{{$site_setting->bn_cta_message_1 or null}}</textarea>
                                            <span  class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 35 and Maximum 60 Character.
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cta_title_2">@lang('messages.Feature 2 Bangla')</label>
                                        <textarea name="bn_cta_title_2" class="form-control" id="bn_cta_title_2" rows="3">{{$site_setting->bn_cta_title_2 or null}}</textarea>
                                        <span  class="suggestion_text">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                            Minimum 15 and Maximum 25 Character.
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cta_message_2">@lang('messages.Feature 2 Sort Description Bangla')</label>
                                        <textarea name="bn_cta_message_2" class="form-control" id="bn_cta_message_2" rows="3">{{$site_setting->bn_cta_message_2 or null}}</textarea>
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
                                        <label for="cta_title_3">@lang('messages.Feature 3 Bangla')</label>
                                        <textarea name="bn_cta_title_3" class="form-control" id="bn_cta_title_3" rows="3">{{$site_setting->bn_cta_title_3 or null}}</textarea>
                                        <span class="suggestion_text">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                            Minimum 15 and Maximum 25 Character.
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cta_message_3">@lang('messages.Feature 3 Sort Description Bangla')</label>
                                        <textarea name="bn_cta_message_3" class="form-control" id="bn_cta_message_3" rows="3">{{$site_setting->bn_cta_message_3 or null}}</textarea>
                                        <span class="suggestion_text">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                            Minimum 35 and Maximum 60 Character.
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <h4 class="section-heading">Home Volunteer Section </h4>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="bn_home_volunteer_desc">@lang('messages.Home Volunteer Description Bangla')</label>
                                        <textarea name="bn_home_volunteer_desc" class="form-control" id="bn_home_volunteer_desc"
                                                  rows="3">{{$site_setting->bn_home_volunteer_desc or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 150 and Maximum 200 Character.
                                            </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <h4 class="section-heading">Home Our Mission Section </h4>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bn_home_mission_desc">@lang('messages.Home Mission Description Bangla')</label>
                                        <textarea name="bn_home_mission_desc" class="form-control" id="bn_home_mission_desc"
                                                  rows="5">{{$site_setting->bn_home_mission_desc or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 500 and Maximum 800 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bn_home_mission_food">@lang('messages.Home Mission Food Bangla')</label>
                                        <textarea name="bn_home_mission_food" class="form-control" id="bn_home_mission_food"
                                                  rows="3">{{$site_setting->bn_home_mission_food or null}}</textarea>
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
                                        <label for="bn_home_mission_education">@lang('messages.Home Mission Education Bangla')</label>
                                        <textarea name="bn_home_mission_education" class="form-control" id="bn_home_mission_education"
                                                  rows="3">{{$site_setting->bn_home_mission_education or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 70 and Maximum 80 Character.
                                            </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bn_home_mission_treatment">@lang('messages.Home Mission Treatment Bangla')</label>
                                        <textarea name="bn_home_mission_treatment" class="form-control" id="bn_home_mission_treatment"
                                                  rows="3">{{$site_setting->bn_home_mission_treatment or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 70 and Maximum 80 Character.
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bn_about_title">@lang('messages.About Title Bangla')</label>
                                        <textarea name="bn_about_title" id="bn_about_title" rows="2"
                                                  class="form-control">{{$site_setting->bn_about_title or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bn_about_sub_title">@lang('messages.About Sub Title Bangla')</label>
                                        <textarea name="bn_about_sub_title" id="bn_about_sub_title" rows="2" class="form-control">{{$site_setting->bn_about_sub_title or null}}</textarea>
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="about_short_brief">@lang('messages.About Short Description Bangla')</label>
                                            <textarea name="bn_about_short_brief" id="bn_about_short_brief" rows="4" class="form-control">{{$site_setting->bn_about_short_brief or null}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="our_story">@lang('messages.Our Story Bangla')</label>
                                            <textarea name="bn_our_story" id="bn_our_story" rows="4" class="form-control">{{$site_setting->bn_our_story or null}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vission">@lang('messages.Vision Bangla')</label>
                                            <textarea name="bn_vission" id="bn_vission" rows="4" class="form-control">{{$site_setting->bn_vission or null}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mission">@lang('messages.Mission Bangla')</label>
                                            <textarea name="bn_mission" id="bn_mission" rows="4" class="form-control">{{$site_setting->bn_mission or null}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="where_we_work">@lang('messages.Where We Work Bangla')</label>
                                            <textarea name="bn_where_we_work" id="bn_where_we_work" rows="3" class="form-control">{{$site_setting->bn_where_we_work or null}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sign_up_donor_message">@lang('messages.Sign Up Message Bangla')</label>
                                            <textarea name="bn_sign_up_donor_message" class="form-control" id="bn_sign_up_donor_message" rows="3">{{$site_setting->bn_sign_up_donor_message or null}}</textarea>
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
                                        <label for="contact_no">@lang('messages.Contact Number Bangla')</label>
                                        <textarea name="bn_contact_no" id="bn_contact_no" rows="1" class="form-control">{{$site_setting->bn_contact_no or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_address">@lang('messages.Contact Address Bangla')</label>
                                        <textarea name="bn_contact_address" id="bn_contact_address" class="form-control" rows="1">{{$site_setting->bn_contact_address or null}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <h4 class="section-heading">Social Media Contact Link</h4>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="fa fa-facebook-square" style="margin-right: 10px;"></i><label for="facebook_social_link"> @lang('messages.Facebook URL')</label>
                                        <textarea name="facebook_social_link" id="facebook_social_link" rows="1" class="form-control">{{$site_setting->facebook_social_link or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="fa fa-google-plus-circle" style="margin-right: 10px;"></i><label for="goole_plus_social_link"> @lang('messages.Google Plus URL')</label>
                                        <textarea name="goole_plus_social_link" id="goole_plus_social_link" rows="1" class="form-control">{{$site_setting->goole_plus_social_link or null}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="fa fa-twitter-square" style="margin-right: 10px;"></i><label for="twitter_social_link"> @lang('messages.Twitter URL')</label>
                                        <textarea name="twitter_social_link" id="twitter_social_link" rows="1" class="form-control">{{$site_setting->twitter_social_link or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="fa fa-instagram" style="margin-right: 10px;"></i><label for="instagram_social_link"> @lang('messages.Instagram URL')</label>
                                        <textarea name="instagram_social_link" id="instagram_social_link" rows="1" class="form-control">{{$site_setting->instagram_social_link or null}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="fa fa-linkedin-square" style="margin-right: 10px;"></i><label for="linkdin_social_link"> @lang('messages.Linkdin URL')</label>
                                        <textarea name="linkdin_social_link" id="linkdin_social_link" rows="1" class="form-control">{{$site_setting->linkdin_social_link or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>


            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!}
                    <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute')) }}">@lang('messages.Cancel')</a>
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

