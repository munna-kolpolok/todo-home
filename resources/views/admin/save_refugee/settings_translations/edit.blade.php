@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/setting_languages') }}">@lang('messages.Sr Site Settings')</a> :
    {{-- Language
    <select name="" id="">
        <option value="">1</option>
    </select>--}}
@endsection
@section("section", trans("messages.Sr Site Settings"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sr_settings'))
@section("sub_section", trans("messages.Update"))

@section("htmlheader_title", trans("messages.Sr Site Settings"))

@section("main-content")
    <style type="text/css">

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

        .sr-bg-color {
            background-color: #E5F8FBB3 !important;
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
    @if(count($languages)>0)
        <div class="box box-success">
            <div class="box-body">
               {{-- {!! Form::open(['action' => 'Admin\Save_Refugee\SiteSettingTranlationsController@store', 'id' => 'site-settings-form']) !!}--}}
                {{ Form::open( array('url' => config('laraadmin.adminRoute').'/setting_languages/'.$sr_setting_trns->id, 'files'=>true, 'method'=>'PATCH', 'id' => 'site-settings-form'))}}
                <div id="payment-tab">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-justified">
                        <li class="nav-item active">
                            <a class="nav-link" data-toggle="tab" href="#home">Home Content</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu2">About Content</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu3">Mission Content </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu4">Vision Content</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#others">Others Content</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->

                    <div class="tab-content">
                        {{--Home settings--}}
                        <div id="home" class="tab-pane active"><br>

                            <div id="home-tab-wrapper" style="padding: 10px 0 25px 0">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="hidden" name="sr_setting_id" value="1">
                                            <label for="lang">Select Language</label>
                                            <select name="locale" class="form-controll" id="" rel="select2" disabled>
                                                @foreach($languages as $language)
                                                    <option value="{{ $language->code }}" @if($sr_setting_trns->locale==$language->code) selected @endif >{{ $language->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    {{-- <h4 class="section-heading sr-bg-color">Slider Section</h4>--}}

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="whome_donate">Whome Donate</label>
                                        <textarea type="text" name="whome_donate" class="form-control"
                                                  id="whome_donate" rows="3"
                                                  placeholder="Enter Whome donate">{{$sr_setting_trns->whome_donate}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Max Character 100 for better looking
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="why_donate">Why Donate</label>
                                        <textarea type="text" name="why_donate" class="form-control"
                                                  id="why_donate" rows="3" placeholder="Enter Whome donate">{{$sr_setting_trns->why_donate}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Max Character 100 for better looking
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="how_donate">How Donate</label>
                                        <textarea type="text" name="how_donate" class="form-control"
                                                  id="how_donate" rows="3" placeholder="Enter How donate">{{$sr_setting_trns->how_donate}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Max Character 100 for better looking
                                            </span>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="intro_title"> Introdution Title </label>
                                            <input type="text" name="intro_title" class="form-control"
                                                   id="intro_title" placeholder="Enter Introdution Title"
                                                   value="{{$sr_setting_trns->intro_title}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 30 for better looking
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="intro_description"> Introdution Desctiption </label>
                                        <textarea type="text" name="intro_description" class="form-control"
                                                  id="intro_description" placeholder="Enter Introdution Desctiption"
                                                  rows="3">{{$sr_setting_trns->intro_description}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 1200 for better looking
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="home_project_short_desc"> Home Project Sort Desctiption </label>
                                        <textarea type="text" name="home_project_short_desc" class="form-control"
                                                  id="home_project_short_desc"
                                                  placeholder="Enter Home Project Sort Desctiption "
                                                  rows="3">{{$sr_setting_trns->home_project_short_desc}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 220-250 for better looking
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="home_video_title"> Home Video Title </label>
                                            <input type="text" name="home_video_title" class="form-control"
                                                   id="home_video_title" placeholder="Enter Home Video Title"
                                                   value="{{$sr_setting_trns->home_video_title}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 20-30 for better looking
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="home_video_subtitle"> Home Video Sub Title </label>
                                            <input type="text" name="home_video_subtitle" class="form-control"
                                                   id="home_video_subtitle" placeholder="Enter Home Video Sub Title"
                                                   value="{{$sr_setting_trns->home_video_subtitle}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 150-200 for better looking
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="home_work_short_desc"> Home Work Sort Desctiption </label>
                                        <textarea type="text" name="home_work_short_desc" class="form-control"
                                                  id="home_work_short_desc"
                                                  placeholder="Enter Home Work Sort Desctiption "
                                                  rows="1">{{$sr_setting_trns->home_work_short_desc}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 30 for better looking
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="work_food_desc">Work Food Description</label>
                                        <textarea type="text" name="work_food_desc" class="form-control"
                                                  id="work_food_desc" rows="3"
                                                  placeholder="Enter Work Food Description">{{$sr_setting_trns->work_food_desc}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Max Character 100 for better looking
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="work_edu_desc">Work Education Description</label>
                                        <textarea type="text" name="work_edu_desc" class="form-control"
                                                  id="work_edu_desc" rows="3"
                                                  placeholder="Enter Work Education Description">{{$sr_setting_trns->work_edu_desc}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Max Character 100 for better looking
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="work_shelter_desc">Work Shelter Description</label>
                                        <textarea type="text" name="work_shelter_desc" class="form-control"
                                                  id="work_shelter_desc" rows="3"
                                                  placeholder="Enter Work Shelter Description">{{$sr_setting_trns->work_shelter_desc}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Max Character 100 for better looking
                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="work_medical_desc">Work Medical Description</label>
                                        <textarea type="text" name="work_medical_desc" class="form-control"
                                                  id="work_medical_desc" rows="3"
                                                  placeholder="Enter Work Medical Description">{{$sr_setting_trns->work_medical_desc}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Max Character 100 for better looking
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="work_clothing_desc">Work Clothing Description</label>
                                        <textarea type="text" name="work_clothing_desc" class="form-control"
                                                  id="work_clothing_desc" rows="3"
                                                  placeholder="Enter Work Clothing Description">{{$sr_setting_trns->work_clothing_desc}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Max Character 100 for better looking
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="work_training_desc">Work Training Description</label>
                                        <textarea type="text" name="work_training_desc" class="form-control"
                                                  id="work_training_desc" rows="3"
                                                  placeholder="Enter Work Training Description">{{$sr_setting_trns->work_training_desc}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Max Character 100 for better looking
                                            </span>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="home_volunteer_message"> Home Volunteer Message </label>
                                            <input type="text" name="home_volunteer_message" class="form-control"
                                                   id="home_volunteer_message"
                                                   placeholder="Enter Home Volunteer Message"
                                                   value="{{$sr_setting_trns->home_volunteer_message}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 80 for better looking
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <br>
                            </div>
                        </div>

                        {{--About and contact--}}
                        <div id="menu2" class="tab-pane fade"><br>

                            <div id="home-tab-wrapper" style="padding: 10px 0 25px 0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="about_title"> About Section Title </label>
                                            <input type="text" name="about_title" class="form-control"
                                                   id="about_title" placeholder="Enter About Section Title"
                                                   value="{{$sr_setting_trns->about_title}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 20-30 for better looking
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="about_subtitle"> About Section Sub Title </label>
                                            <input type="text" name="about_subtitle" class="form-control"
                                                   id="about_subtitle" placeholder="Enter About Section Sub-Title"
                                                   value="{{$sr_setting_trns->about_subtitle}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 30-50 for better looking
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="about_description"> About Section Desctiption </label>
                                        <textarea type="text" name="about_description" class="form-control"
                                                  id="about_description"
                                                  placeholder="Enter About Section Desctiption "
                                                  rows="3">{{$sr_setting_trns->about_description}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 600 for better looking
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="about_who_we_are">About Who We Are</label>
                                        <textarea type="text" name="about_who_we_are" class="form-control"
                                                  id="about_who_we_are" rows="3"
                                                  placeholder="Enter About Who We Are Description">{{$sr_setting_trns->about_who_we_are}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Max Character 800 for better looking
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="about_what_we_do">About What We Do Description</label>
                                        <textarea type="text" name="about_what_we_do" class="form-control"
                                                  id="about_what_we_do" rows="3"
                                                  placeholder="Enter About What We Do Description">{{$sr_setting_trns->about_what_we_do}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Max Character 800 for better looking
                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <br>
                            </div>
                        </div>

                        {{--Mission Setting --}}
                        <div id="menu3" class="tab-pane fade"><br>

                            <div id="home-tab-wrapper" style="padding: 10px 0 25px 0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="mission_title"> Mission Page Title </label>
                                            <input type="text" name="mission_title" class="form-control"
                                                   id="mission_title" placeholder="Enter Mission Page Title"
                                                   value="{{$sr_setting_trns->mission_title}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 50 for better looking
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mission_subtitle_up"> Mission Title Up </label>
                                            <input type="text" name="mission_subtitle_up" class="form-control"
                                                   id="mission_subtitle_up" placeholder="Enter Mission Title Up"
                                                   value="{{$sr_setting_trns->mission_subtitle_up}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 60-80 for better looking
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mission_subtitle_down"> Mission Title Down </label>
                                            <input type="text" name="mission_subtitle_down" class="form-control"
                                                   id="mission_subtitle_down" placeholder="Enter Mission Title Down"
                                                   value="{{$sr_setting_trns->mission_subtitle_down}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 30-50 for better looking
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="mission_description"> Mission Desctiption </label>
                                        <textarea type="text" name="mission_description" class="form-control"
                                                  id="mission_description"
                                                  placeholder="Enter Mission Desctiption "
                                                  rows="3">{{$sr_setting_trns->mission_description}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 1000 for better looking
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mission_heading_1"> Mission Heading 1 </label>
                                            <input type="text" name="mission_heading_1" class="form-control"
                                                   id="mission_heading_1" placeholder="Enter Mission Heading 1"
                                                   value="{{$sr_setting_trns->mission_heading_1}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 100 for better looking
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mission_heading_2"> Mission Heading 2 </label>
                                            <input type="text" name="mission_heading_2" class="form-control"
                                                   id="mission_heading_2" placeholder="Enter Mission Heading 2"
                                                   value="{{$sr_setting_trns->mission_heading_2}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 100 for better looking
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mission_heading_1_desc">Heading 1 Description</label>
                                        <textarea type="text" name="mission_heading_1_desc" class="form-control"
                                                  id="mission_heading_1_desc" rows="5"
                                                  placeholder="Enter Heading 1 Description">{{$sr_setting_trns->mission_heading_1_desc}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Max Character 1000 for better looking
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mission_heading_2_desc">Heading 2 Description</label>
                                        <textarea type="text" name="mission_heading_2_desc" class="form-control"
                                                  id="mission_heading_2_desc" rows="5"
                                                  placeholder="Enter Heading 2 Description">{{$sr_setting_trns->mission_heading_2_desc}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Max Character 1000 for better looking
                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <br>
                            </div>
                        </div>

                        {{-- Vision  Setting--}}
                        <div id="menu4" class="tab-pane fade"><br>

                            <div id="home-tab-wrapper" style="padding: 10px 0 25px 0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vision_video_title"> Vision Video Title </label>
                                            <input type="text" name="vision_video_title" class="form-control"
                                                   id="vision_video_title" placeholder="Enter Vision Video Title"
                                                   value="{{$sr_setting_trns->vision_video_title}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 50 for better looking
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vision_video_subtitle_up"> Vision Video Sub Title Up </label>
                                            <input type="text" name="vision_video_subtitle_up" class="form-control"
                                                   id="vision_video_subtitle_up"
                                                   placeholder="Enter Vision Video Sub Title Up"
                                                   value="{{$sr_setting_trns->vision_video_subtitle_up}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 60-80 for better looking
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vision_video_subtitle_down"> Vision Video Subtitle Down </label>
                                            <input type="text" name="vision_video_subtitle_down" class="form-control"
                                                   id="vision_video_subtitle_down"
                                                   placeholder="Enter Vision Video Subtitle Down"
                                                   value="{{$sr_setting_trns->vision_video_subtitle_down}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 30-50 for better looking
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vision_title"> Vision Title </label>
                                            <input type="text" name="vision_title" class="form-control"
                                                   id="vision_title" placeholder="Enter Vision Title"
                                                   value="{{$sr_setting_trns->vision_title}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 50 for better looking
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vision_subtitle"> Vision Subtitle </label>
                                            <input type="text" name="vision_subtitle" class="form-control"
                                                   id="vision_subtitle" placeholder="Enter Vision Subtitle"
                                                   value="{{$sr_setting_trns->vision_subtitle}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                 Max Character 100 for better looking
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vision_description">Vision Description</label>
                                        <textarea type="text" name="vision_description" class="form-control"
                                                  id="vision_description" rows="3"
                                                  placeholder="Enter Vision Description">{{$sr_setting_trns->vision_description}}</textarea>
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Max Character 1000 for better looking
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>

                        {{-- Others  Setting--}}
                        <div id="others" class="tab-pane fade"><br>

                            <div id="home-tab-wrapper" style="padding: 10px 0 25px 0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_address">Contact Address</label>
                                        <textarea type="text" name="contact_address" class="form-control"
                                                  id="contact_address" rows="3"
                                                  placeholder="Enter Contact Address">{{$sr_setting_trns->contact_address}}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="receipt_body">Receipt Body</label>
                                        <textarea type="text" name="receipt_body" class="form-control"
                                                  id="receipt_body" rows="3"
                                                  placeholder="Enter Receipt Body">{{$sr_setting_trns->receipt_body}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group" style="text-align: center">
                            {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute')) }}">@lang('messages.Cancel')</a>
                        </div>
                    </div>
                    {{ Form::close() }}

                </div>
            </div>
        </div>
            @else
                <div class="box box-success">
                    <div class="box-body">
                        No Language available for translations !
                    </div>
                </div>
            @endif

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

