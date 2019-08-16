@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/wedding_settings') }}">@lang('messages.Marriage Settings')</a> :
@endsection
@section("section", trans("messages.Marriage Settings"))
@section("section_url", url(config('laraadmin.adminRoute') . '/wedding_settings'))
@section("sub_section", trans("messages.Update"))

@section("htmlheader_title", trans("messages.Marriage Settings"))

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
            {{ Form::open( array('url' => config('laraadmin.adminRoute').'/wedding_settings/'.$marriage_setting->id, 'files'=>true, 'method'=>'PATCH', 'id' => 'site-settings-form'))}}
            <div id="payment-tab">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item active">
                        <a class="nav-link" data-toggle="tab" href="#menu1">About Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu2">Images</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu3">Contact & Social Info</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    {{--About setting--}}
                    <div id="menu1" class="tab-pane active"><br>
                        <div id="about-tab-wrapper" style="padding: 10px 0 25px 0">
                            <div class="row">
                                <h4 class="section-heading">Organization</h4>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="organization_name">@lang('messages.Organization Name')</label>
                                        <textarea name="organization_name" class="form-control" id="organization_name"
                                                  rows="3">{{$marriage_setting->organization_name or null}}</textarea>
                                        <span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 30 Character.
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_vision_image">@lang('messages.Logo')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($marriage_setting->logo))
                                                <img src="{{asset($marriage_setting->logo)}}"
                                                     alt="Logo" width="80px" height="40px">
                                                @else
                                                <img src="{{asset('site-assets/images/profile/profile.jpg')}}"
                                                     alt="No Image"
                                                     width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="logo" class="form-control"
                                                       name="logo"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:283X65px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="section-heading">About</h4>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_title">@lang('messages.About Title')</label>
                                        <textarea name="about_title" id="about_title" rows="2"
                                                  class="form-control">{{$marriage_setting->about_title or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bn_about_title">@lang('messages.About Title(Bangla)')</label>
                                        <textarea name="bn_about_title" id="bn_about_title" rows="2"
                                                  class="form-control">{{$marriage_setting->bn_about_title or null}}</textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_short_brief">@lang('messages.About Short Brif')</label>
                                        <textarea name="about_short_brief" id="about_short_brief" rows="2"
                                                  class="form-control">{{$marriage_setting->about_short_brief or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bn_about_short_brief">@lang('messages.About Short Brif(Bangla)')</label>
                                        <textarea name="bn_about_short_brief" id="bn_about_short_brief" rows="2"
                                                  class="form-control">{{$marriage_setting->bn_about_short_brief or null}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_who_we_are">@lang('messages.Who We Are')</label>
                                        <textarea name="about_who_we_are" id="about_who_we_are" rows="2"
                                                  class="form-control">{{$marriage_setting->about_who_we_are or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bn_about_who_we_are">@lang('messages.Who We Are(Bangla)')</label>
                                        <textarea name="bn_about_who_we_are" id="bn_about_who_we_are" rows="2"
                                                  class="form-control">{{$marriage_setting->bn_about_who_we_are or null}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_what_we_do">@lang('messages.What We Do')</label>
                                        <textarea name="about_what_we_do" id="about_what_we_do" rows="2"
                                                  class="form-control">{{$marriage_setting->about_what_we_do or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bn_about_what_we_do">@lang('messages.What We Do(Bangla)')</label>
                                        <textarea name="bn_about_what_we_do" id="bn_about_what_we_do" rows="2"
                                                  class="form-control">{{$marriage_setting->bn_about_what_we_do or null}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Images Setting--}}
                    <div id="menu2" class="tab-pane fade"><br>

                        <div id="contact-tab-wrapper" style="padding: 10px 0 25px 0">
                            <div class="row">
                                <h4 class="section-heading">Header Image</h4>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_background_image">@lang('messages.About Header Image')</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($marriage_setting->about_banner_image))
                                                <img src="{{asset($marriage_setting->about_banner_image)}}"
                                                     alt="About Image" width="80px" height="40px">
                                                @else
                                                <img src="{{asset('site-assets/images/profile/profile.jpg')}}"
                                                     alt="No Image"
                                                     width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="about_banner_image" class="form-control"
                                                       name="about_banner_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:1920X500px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_banner_image">@lang('messages.Contact Header Image')</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($marriage_setting->contact_banner_image))
                                                <img src="{{asset($marriage_setting->contact_banner_image)}}"
                                                     alt="About Image" width="80px" height="40px">
                                                @else
                                                <img src="{{asset('site-assets/images/profile/profile.jpg')}}"
                                                     alt="No Image"
                                                     width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="contact_banner_image" class="form-control"
                                                       name="contact_banner_image"
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
                                        <label for="faq_banner_image">@lang('messages.Faq Header Image')</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($marriage_setting->faq_banner_image))
                                                <img src="{{asset($marriage_setting->faq_banner_image)}}"
                                                     alt="Bank info Image" width="80px" height="40px">
                                                @else
                                                <img src="{{asset('site-assets/images/profile/profile.jpg')}}"
                                                     alt="No Image"
                                                     width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="faq_banner_image" class="form-control"
                                                       name="faq_banner_image"
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
                                        <label for="campaign_details_banner_image">@lang('messages.Payment Header image')</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($marriage_setting->payment_banner_image))
                                                <img src="{{asset($marriage_setting->payment_banner_image)}}"
                                                     alt="Bank info Image" width="80px" height="40px">
                                                @else
                                                <img src="{{asset('site-assets/images/profile/profile.jpg')}}"
                                                     alt="No Image"
                                                     width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="payment_banner_image"
                                                       class="form-control"
                                                       name="payment_banner_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:1920X500px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <h4 class="section-heading">Other Image</h4>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_big_image">@lang('messages.About Big Image')</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($marriage_setting->about_big_image))
                                                <img src="{{asset($marriage_setting->about_big_image)}}" alt="About Image"
                                                     width="80px" height="40px">
                                                @else
                                                <img src="{{asset('site-assets/images/profile/profile.jpg')}}"
                                                     alt="No Image"
                                                     width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="about_big_image" class="form-control"
                                                       name="about_big_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:275X335px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_small_up_image">@lang('messages.About Up Image')</label>

                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($marriage_setting->about_small_up_image))
                                                <img src="{{asset($marriage_setting->about_small_up_image)}}" alt="About Image"
                                                     width="80px" height="40px">
                                                @else
                                                <img src="{{asset('site-assets/images/profile/profile.jpg')}}"
                                                     alt="No Image"
                                                     width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="about_small_up_image" class="form-control"
                                                       name="about_small_up_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:280X156px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_small_down_image">@lang('messages.About Down Image')</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($marriage_setting->about_small_down_image))
                                                <img src="{{asset($marriage_setting->about_small_down_image)}}" alt="About Image"
                                                     width="80px" height="40px">
                                                @else
                                                <img src="{{asset('site-assets/images/profile/profile.jpg')}}"
                                                     alt="No Image"
                                                     width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="about_small_down_image" class="form-control"
                                                       name="about_small_down_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:280X156px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apply_form_bg_image">@lang('messages.Register Background Image')</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($marriage_setting->apply_form_bg_image))
                                                <img src="{{asset($marriage_setting->apply_form_bg_image)}}" alt="About Image"
                                                     width="80px" height="40px">
                                                @else
                                                <img src="{{asset('site-assets/images/profile/profile.jpg')}}"
                                                     alt="No Image"
                                                     width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="apply_form_bg_image" class="form-control"
                                                       name="apply_form_bg_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:1920X850px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_email_image">@lang('messages.Contact Email Image')</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($marriage_setting->contact_email_image))
                                                <img src="{{asset($marriage_setting->contact_email_image)}}" alt="About Image"
                                                     width="80px" height="40px">
                                                @else
                                                <img src="{{asset('site-assets/images/profile/profile.jpg')}}"
                                                     alt="No Image"
                                                     width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="contact_email_image" class="form-control"
                                                       name="contact_email_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:152X19px
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_slider_image">@lang('messages.Contact Slider Image')</label>
                                        <div style="margin-top: 0" class="media">
                                            <div class="media-left">
                                                @if(!is_null($marriage_setting->contact_slider_image))
                                                <img src="{{asset($marriage_setting->contact_slider_image)}}" alt="About Image"
                                                     width="80px" height="40px">
                                                @else
                                                <img src="{{asset('site-assets/images/profile/profile.jpg')}}"
                                                     alt="No Image"
                                                     width="80px" height="40px">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <input type="file" id="contact_slider_image" class="form-control"
                                                       name="contact_slider_image"
                                                       accept="image/png,image/gif,image/jpeg,image/jpg">
                                                <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                 aria-hidden="true"></i> Type: jpeg,jpg. Size:1220X844px
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_address">@lang('messages.Contact Address')</label>
                                        <textarea name="contact_address" class="form-control" id="contact_address"
                                                  rows="2">{{$marriage_setting->contact_address or null}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bn_contact_address">@lang('messages.Contact Address(Bangla)')</label>
                                        <textarea name="bn_contact_address" class="form-control" id="bn_contact_address"
                                                  rows="2">{{$marriage_setting->bn_contact_address or null}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_no">@lang('messages.Contact No')</label>
                                        <input type="text" id="contact_no" name="contact_no" class="form-control" value="{{$marriage_setting->contact_no}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bn_contact_no">@lang('messages.Contact No(Bangla)')</label>
                                        <input type="text" id="bn_contact_no" name="bn_contact_no" class="form-control" value="{{$marriage_setting->bn_contact_no}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_email">@lang('messages.Contact Email')</label>
                                        <input type="email" id="contact_email" name="contact_email" class="form-control" value="{{$marriage_setting->contact_email}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="facebook_social_link">@lang('messages.Facebook Link')</label>
                                        <input type="url" id="facebook_social_link" name="facebook_social_link" class="form-control" value="{{$marriage_setting->facebook_social_link}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="goole_plus_social_link">@lang('messages.Google Plus Link')</label>
                                        <input type="url" id="goole_plus_social_link" name="goole_plus_social_link" class="form-control" value="{{$marriage_setting->goole_plus_social_link	}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="twitter_social_link">@lang('messages.Twitter Link')</label>
                                        <input type="url" id="twitter_social_link" name="twitter_social_link" class="form-control" value="{{$marriage_setting->twitter_social_link}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="instagram_social_link">@lang('messages.Instagram Link')</label>
                                        <input type="url" id="instagram_social_link" name="instagram_social_link" class="form-control" value="{{$marriage_setting->instagram_social_link}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="linkdin_social_link">@lang('messages.Linkdin Link')</label>
                                        <input type="url" id="linkdin_social_link" name="linkdin_social_link" class="form-control" value="{{$marriage_setting->linkdin_social_link}}">
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

