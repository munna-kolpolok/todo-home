@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/sr_settings') }}">@lang('messages.Sr Site Settings')</a> :
@endsection
@section("section", trans("messages.Sr Site Settings"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sr_settings'))
@section("sub_section", trans("messages.Update"))

@section("htmlheader_title", trans("messages.Sr Site Settings"))

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
        .sr-bg-color{
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

    <?php //print_r($groups); die(); ?>
    <div class="box box-success">
        <div class="box-body">
            {{ Form::open( array('url' => config('laraadmin.adminRoute').'/sr_settings/'.$site_setting->id, 'files'=>true, 'method'=>'PATCH', 'id' => 'site-settings-form'))}}
            <div id="payment-tab">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item active">
                        <a class="nav-link" data-toggle="tab" href="#home" >Content Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu2">Images Settings</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    {{--Content settings--}}
                    <div id="home" class="tab-pane active"><br>

                        <div id="home-tab-wrapper" style="padding: 10px 0 25px 0">
                            <div class="row">
                                <h4 class="section-heading sr-bg-color">System Settings</h4>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="min_donation_amount">Min Donation Amount</label>
                                        <input type="number" name="min_donation_amount" class="form-control"
                                               id="min_donation_amount"
                                               value="{{$site_setting->min_donation_amount or null}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Must Be a number Only.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="max_donation_amount">Max Donation Amount</label>
                                        <input type="number" name="max_donation_amount" class="form-control"
                                               id="max_donation_amount"
                                               value="{{$site_setting->max_donation_amount or null}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Must Be a number Only.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_email">Contact Email </label>
                                        <input type="email" name="contact_email" class="form-control" id="contact_email"
                                               value="{{$site_setting->contact_email or null}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Email Only.
                                            </span>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_no">Contact No </label>
                                        <input type="text" name="contact_no" class="form-control"
                                               id="contact_no"
                                               value="{{$site_setting->contact_no or null}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Enter a valid contact No
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="meal_served_no">Meal Served No</label>
                                        <input type="number" name="meal_served_no" class="form-control"
                                               id="meal_served_no"
                                               value="{{$site_setting->meal_served_no or null}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Must Be a number Only.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="global_work_no">Global Work No  </label>
                                        <input type="number" name="global_work_no" class="form-control" id="global_work_no"
                                               value="{{$site_setting->global_work_no or null}}">
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Must Be a number Only.
                                            </span>
                                    </div>
                                </div>

                            </div>
                            <br>
                            <div class="row">
                                <h4 class="section-heading sr-bg-color">Media Content Link</h4>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="home_video_link">Home Video Link</label>
                                        <input type="text" name="home_video_link" class="form-control" id="home_video_link" value="{{$site_setting->home_video_link or null}}" />
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Enter a valid URL
                                            </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mission_video">Mission Video Link</label>
                                        <input type="text" name="mission_video" class="form-control" id="mission_video" value="{{$site_setting->mission_video or null}}" />
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Enter a valid URL
                                            </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="vision_video">Vision  Video Link</label>
                                        <input type="text" name="vision_video" class="form-control" id="vision_video" value="{{$site_setting->vision_video or null}}" />
                                            <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Enter a valid URL
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <h4 class="section-heading sr-bg-color" >Social Media Contact Link</h4>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <i class="fa fa-facebook-square" style="margin-right: 10px; color:#009CE4;"></i><label
                                                for="facebook_social_link"> @lang('messages.Facebook URL')</label>
                                        <input type="text" name="facebook_social_link" id="facebook_social_link" rows="1"
                                               class="form-control" value="{{$site_setting->facebook_social_link or null}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <i class="fa fa-google-plus-circle" style="margin-right: 10px; color:#DC4E41;"></i><label
                                                for="goole_plus_social_link"> @lang('messages.Google Plus URL')</label>
                                        <input type="text" name="goole_plus_social_link" id="goole_plus_social_link" rows="1"
                                               class="form-control" value="{{$site_setting->goole_plus_social_link or null}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <i class="fa fa-twitter-square" style="margin-right: 10px;color:#009CE4;"></i><label
                                                for="twitter_social_link"> @lang('messages.Twitter URL')</label>
                                        <input type="text" name="twitter_social_link" id="twitter_social_link" rows="1"
                                               class="form-control" value="{{$site_setting->twitter_social_link or null}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <i class="fa fa-linkedin-square" style="margin-right: 10px;"></i><label
                                                for="linkdin_social_link"> @lang('messages.Linkdin URL')</label>
                                        <input type="text" name="linkdin_social_link" id="linkdin_social_link" rows="1"
                                               class="form-control" value="{{$site_setting->linkdin_social_link or null}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <i class="fa fa-youtube" style="margin-right: 10px;"></i><label
                                                for="youtube_social_link"> @lang('messages.Youtube Link')</label>
                                        <input type="text" name="youtube_social_link"  value="{{$site_setting->youtube_social_link or null}}" id="youtube_social_link"  class="form-control">
                                    </div>
                                </div>
                                {{--<div class="col-md-4">
                                    <div class="form-group">
                                        <i class="fa fa-instagram" style="margin-right: 10px; color:#B24266;"></i><label
                                                for="instagram_social_link"> @lang('messages.Instagram URL')</label>
                                        <input type="text" name="instagram_social_link" id="instagram_social_link" rows="1"
                                               class="form-control" value="{{$site_setting->instagram_social_link or null}}">
                                    </div>
                                </div>--}}
                            </div>
                        </div>
                    </div>

                    {{--Images Setting--}}
                    <div id="menu2" class="tab-pane fade"><br>

                        <div id="contact-tab-wrapper" style="padding: 10px 0 25px 0">
                            <div class="row">
                                <h4 class="section-heading sr-bg-color">Logo & Email</h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logo">@lang('messages.Site Logo')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->logo))
                                                    <img src="{{asset($site_setting->logo)}}" alt="Logo"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="logo" class="form-control" name="logo"
                                                       accept="image/png,image/jpeg,image/jpg">
                                                 <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                  aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:323X80px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email_image">Email Image</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->email_image))
                                                    <img src="{{asset($site_setting->email_image)}}" alt="Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="email_image" class="form-control" name="email_image"
                                                       accept="image/png,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i>  Size:192X19px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="section-heading sr-bg-color"> Pages Banner Image</h4>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="about_banner_image">About Banner Image</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->about_banner_image))
                                                    <img src="{{asset($site_setting->about_banner_image)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="about_banner_image" class="form-control"
                                                       name="about_banner_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png. Size:1920X500px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_banner_image">Contact Banner Image</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->contact_banner_image))
                                                    <img src="{{asset($site_setting->contact_banner_image)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="contact_banner_image" class="form-control"
                                                       name="contact_banner_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png. Size:1920X500px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gallery_banner_image">Gallery Banner Image</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->gallery_banner_image))
                                                    <img src="{{asset($site_setting->gallery_banner_image)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="gallery_banner_image" class="form-control"
                                                       name="gallery_banner_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png. Size:1920X500px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="video_banner_image">Video Banner Image</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->video_banner_image))
                                                    <img src="{{asset($site_setting->video_banner_image)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="video_banner_image" class="form-control"
                                                       name="video_banner_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png. Size:1920X500px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="transaction_banner_image">Transaction Banner Image</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->transaction_banner_image))
                                                    <img src="{{asset($site_setting->transaction_banner_image)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="transaction_banner_image" class="form-control"
                                                       name="transaction_banner_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png. Size:1920X500px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="faq_banner_image">Faqs Banner Image</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->faq_banner_image))
                                                    <img src="{{asset($site_setting->faq_banner_image)}}"
                                                         alt="Image" width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="faq_banner_image" class="form-control"
                                                       name="faq_banner_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Type: jpeg,jpg,png. Size:1920X500px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <h4 class="section-heading sr-bg-color">Background Images</h4>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="donate_background_image">Donate Background Image</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->donate_background_image))
                                                    <img src="{{asset($site_setting->donate_background_image)}}" alt="Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="donate_background_image" class="form-control"
                                                       name="donate_background_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Size:390X450px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="counter_background_image">Counter Background Image</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->counter_background_image))
                                                    <img src="{{asset($site_setting->counter_background_image)}}" alt="Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="counter_background_image" class="form-control"
                                                       name="counter_background_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Size:1920X500px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="video_background_image">Video Background Image</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->video_background_image))
                                                    <img src="{{asset($site_setting->video_background_image)}}" alt="Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="video_background_image" class="form-control"
                                                       name="video_background_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Size:1920X600px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <h4 class="section-heading sr-bg-color">Slider Images</h4>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="about_slider_1">About Slider Image 1</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->about_slider_1))
                                                    <img src="{{asset($site_setting->about_slider_1)}}" alt="Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="about_slider_1" class="form-control"
                                                       name="about_slider_1"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Size:555X330px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="about_slider_2">About Slider Image 2</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->about_slider_2))
                                                    <img src="{{asset($site_setting->about_slider_2)}}" alt="Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="about_slider_2" class="form-control"
                                                       name="about_slider_2"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Size:555X330px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="about_slider_3">About Slider Image 3</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->about_slider_3))
                                                    <img src="{{asset($site_setting->about_slider_3)}}" alt="Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="about_slider_3" class="form-control"
                                                       name="about_slider_3"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Size:555X330px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <h4 class="section-heading sr-bg-color">Mission And Vision Images</h4>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mission_image">Mission main Image</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->mission_image))
                                                    <img src="{{asset($site_setting->mission_image)}}" alt="Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="mission_image" class="form-control"
                                                       name="mission_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Size:430X240px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mission_content_image_1">Mission Content Image 1</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->mission_content_image_1))
                                                    <img src="{{asset($site_setting->mission_content_image_1)}}" alt="Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="mission_content_image_1" class="form-control"
                                                       name="mission_content_image_1"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Size:250X250px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mission_content_image_2">Mission Content Image 2</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->mission_content_image_2))
                                                    <img src="{{asset($site_setting->mission_content_image_2)}}" alt="Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="mission_content_image_2" class="form-control"
                                                       name="mission_content_image_2"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Size:250X250px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mission_content_image_3">Mission Content Image 3</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->mission_content_image_3))
                                                    <img src="{{asset($site_setting->mission_content_image_3)}}" alt="Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="mission_content_image_3" class="form-control"
                                                       name="mission_content_image_3"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Size:250X250px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mission_content_image_4">Mission Content Image 4</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->mission_content_image_4))
                                                    <img src="{{asset($site_setting->mission_content_image_4)}}" alt="Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="mission_content_image_4" class="form-control"
                                                       name="mission_content_image_4"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Size:250X250px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="vision_image">Vision Image </label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($site_setting->vision_image))
                                                    <img src="{{asset($site_setting->vision_image)}}" alt="Image"
                                                         width="80px" height="40px">
                                                @else
                                                    <img src="{{asset('uploads/default/profile_image.png')}}"
                                                         alt="No Image" width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="vision_image" class="form-control"
                                                       name="vision_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                    <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                     aria-hidden="true"></i> Size:350X300px
                                </span>
                                            </div>
                                        </div>
                                    </div>
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

