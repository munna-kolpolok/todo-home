@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/site_settings') }}">@lang('messages.Site Settings')</a> :
@endsection
@section("section", trans("messages.Site Settings"))
@section("section_url", url(config('laraadmin.adminRoute') . '/site_settings'))
@section("sub_section", trans("messages.Update"))

@section("htmlheader_title", trans("messages.Site Settings"))

@section("main-content")
    <style type="text/css">
        #save_div {
            display: none;
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
            {{ Form::open( array('url' => config('laraadmin.adminRoute').'/site_settings/'.$site_setting->id, 'files'=>true, 'method'=>'PATCH', 'id' => 'site-settings-form'))}}
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
                        <a class="nav-link" data-toggle="tab" href="#menu2">Contact Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu3">Header Setting</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    {{--Home settings--}}
                    <div id="home" class="container tab-pane active"><br>
                        <div id="home-tab-wrapper" style="padding: 25px 0 25px 0">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="home_feature_1">@lang('messages.Home Feature 01')</label>
                                            <input type="text" minlength="5" maxlength="25" class="form-control" name="home_feature_1"
                                                   value="{{@isset($site_setting->home_feature_1) ? $site_setting->home_feature_1 : ''}}"
                                                   id="home_feature_1">
                                            <span style="color: green">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Home Feature Minimum 5 and Maximum 25 Character.
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="home_feature_01_description">@lang('messages.Home Feature 01 Description')</label>
                                            <input type="text"  minlength="10" maxlength="60" class="form-control" name="home_feature_01_description"
                                                   value="{{@isset($site_setting->home_feature_01_description) ? $site_setting->home_feature_01_description : ''}}"
                                                   id="home_feature_01_description">
                                            <span style="color: green">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Home Feature Description Minimum 10 and Maximum 60 Character.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="home_feature_2">@lang('messages.Home Feature 02')</label>
                                            <input type="text" class="form-control" minlength="5" maxlength="25" name="home_feature_2"
                                                   value="{{@isset($site_setting->home_feature_2) ? $site_setting->home_feature_2 : ''}}"
                                                   id="home_feature_2">
                                            <span style="color: green">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Home Feature Minimum 5 and Maximum 25 Character.
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="home_feature_02_description">@lang('messages.Home Feature 02 Description')</label>
                                            <input type="text" class="form-control" minlength="10" maxlength="60" name="home_feature_02_description"
                                                   value="{{@isset($site_setting->home_feature_02_description) ? $site_setting->home_feature_02_description : ''}}"
                                                   id="home_feature_02_description">
                                            <span style="color: green">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Home Feature Description Minimum 10 and Maximum 60 Character.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="home_feature_3">@lang('messages.Home Feature 03')</label>
                                            <input type="text" class="form-control" minlength="5" maxlength="25" name="home_feature_3"
                                                   value="{{@isset($site_setting->home_feature_3) ? $site_setting->home_feature_3 : ''}}"
                                                   id="home_feature_3">
                                            <span style="color: green">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Home Feature Minimum 5 and Maximum 25 Character.
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="home_feature_03_description">@lang('messages.Home Feature 03 Description')</label>
                                            <input type="text" class="form-control" minlength="10" maxlength="60" name="home_feature_03_description"
                                                   value="{{@isset($site_setting->home_feature_03_description) ? $site_setting->home_feature_03_description : ''}}"
                                                   id="home_feature_03_description">
                                            <span style="color: green">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Home Feature Description Minimum 10 and Maximum 60 Character.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--About setting--}}
                    <div id="menu1" class="container tab-pane fade"><br>
                        <div id="about-tab-wrapper" style="padding: 25px 0 25px 0">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="about_text">@lang('messages.About Text')</label>
                                            <textarea name="about_text" class="form-control" minlength="500" maxlength="1200" cols="40" rows="15"
                                                      id="about_text">{{@isset($site_setting->about_text) ? trim($site_setting->about_text) : ''}}</textarea>
                                            <span style="color: green">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                About Text Minimum 500 and Maximum 1200 Character.
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="per_dollar_currency">@lang('messages.About Image')</label>
                                            @if(!is_null($site_setting->about_image))
                                            <img src="{{asset($site_setting->about_image)}}" alt="About Image"
                                                 class="img-responsive">
                                            @else
                                            <img src="{{asset('uploads/products/default/default.png')}}" alt="No Image"
                                                 width="250px"
                                                 height="250px" class="img-responsive">
                                            @endif
                                            <input style="margin-top: 5px" type="file" id="about_image" name="about_image" accept="image/png,image/gif,image/jpeg,image/jpg">
                                            <span style="color: red;font-weight: bold">Image Must Be 720 X 866</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Contact Setting--}}
                    <div id="menu2" class="container tab-pane fade"><br>
                        <div id="contact-tab-wrapper" style="padding: 25px 0 25px 0">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="address">@lang('messages.Address')</label>
                                            <input type="text" class="form-control" name="address"
                                                   value="{{@isset($site_setting->address) ? $site_setting->address : ''}}"
                                                   id="address">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="tel">@lang('messages.Phone')</label>
                                            <input type="text" class="form-control" name="tel"
                                                   value="{{@isset($site_setting->tel) ? $site_setting->tel : ''}}"
                                                   id="tel">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="tel_after_office">@lang('messages.Phone After Office')</label>
                                            <input type="text" class="form-control" name="tel_after_office"
                                                   value="{{@isset($site_setting->tel_after_office) ? $site_setting->tel_after_office : ''}}"
                                                   id="tel_after_office">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="email">@lang('messages.Email')</label>
                                            <input type="email" class="form-control" name="email"
                                                   value="{{@isset($site_setting->email) ? $site_setting->email : ''}}"
                                                   id="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="facebook_link">@lang('messages.Facebook URL')</label>
                                            <input type="url" class="form-control" name="facebook_link" value="{{@isset($site_setting->facebook_link) ? $site_setting->facebook_link : ''}}"
                                                   id="facebook_link" placeholder="https://www.facebook.com/account">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="twitter_link">@lang('messages.Twitter URL')</label>
                                            <input type="url" class="form-control" name="twitter_link" value="{{@isset($site_setting->twitter_link) ? $site_setting->twitter_link : ''}}"
                                                   id="twitter_link" placeholder="https://www.twitter.com/account">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="google_link">@lang('messages.Goggle URL')</label>
                                            <input type="url" class="form-control" name="google_link" value="{{@isset($site_setting->google_link) ? $site_setting->google_link : ''}}"
                                                   id="google_link" placeholder="https://www.google.xom/account">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="linkedin_link">@lang('messages.Instagram URL')</label>
                                            <input type="url" class="form-control" name="linkedin_link" value="{{@isset($site_setting->linkedin_link) ? $site_setting->linkedin_link : ''}}"
                                                   id="linkedin_link" placeholder="https://www.instagram.com/account">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="youtube_link">@lang('messages.Youtube URL')</label>
                                            <input type="url" class="form-control" name="youtube_link" value="{{@isset($site_setting->youtube_link) ? $site_setting->youtube_link : ''}}"
                                                   id="youtube_link" placeholder="https://www.youtube.com/account">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="instagram_link">@lang('messages.Linkedin URL')</label>
                                            <input type="url" class="form-control" name="instagram_link" value="{{@isset($site_setting->instagram_link) ? $site_setting->instagram_link : ''}}"
                                                   id="instagram_link" placeholder="https://www.linkedin.com/account">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Header Setting--}}
                    <div id="menu3" class="container tab-pane fade"><br>
                        <div id="header-tab-wrapper" style="padding: 25px 0 25px 0">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="product_banner_caption_up">@lang('messages.Product Banner Caption Up')<span class="la-required">*</span></label>
                                            <input type="text" class="form-control" minlength="5" maxlength="50" name="product_banner_caption_up"
                                                   value="{{@isset($site_setting->product_banner_caption_up) ? $site_setting->product_banner_caption_up : ''}}"
                                                   id="product_banner_caption_up" required="1">
                                            <span style="color: green">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 5 and Maximum 50 Character.
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="product_banner_caption_down">@lang('messages.Product Banner Caption Down')</label>
                                            <input type="text" class="form-control" minlength="4" maxlength="50" name="product_banner_caption_down"
                                                   value="{{@isset($site_setting->product_banner_caption_down) ? $site_setting->product_banner_caption_down : ''}}"
                                                   id="product_banner_caption_down">
                                            <span style="color: green">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 4 and Maximum 50 Character.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="currency">@lang('messages.Currency')<span
                                                        class="la-required">*</span></label>
                                            <input type="text" class="form-control" name="currency"
                                                   value="{{@isset($site_setting->currency) ? $site_setting->currency : ''}}"
                                                   id="currency" required="1">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="per_dollar_currency">@lang('messages.Per Dollar Currency')<span
                                                        class="la-required">*</span></label>
                                            <input type="number" min="0" class="form-control" name="per_dollar_currency"
                                                   value="{{@isset($site_setting->per_dollar_currency) ? $site_setting->per_dollar_currency : ''}}"
                                                   id="per_dollar_currency" required="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="delivery_charge">@lang('messages.Delivery Charge')<span
                                                        class="la-required">*</span></label>
                                            <input type="number" min="0" class="form-control" name="delivery_charge"
                                                   value="{{@isset($site_setting->delivery_charge) ? $site_setting->delivery_charge : ''}}"
                                                   id="delivery_charge" required="1">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="top_header_notice">@lang('messages.Top Header Notice')</label>
                                            <input type="text" class="form-control" minlength="10" maxlength="60" name="top_header_notice"
                                                   value="{{@isset($site_setting->top_header_notice) ? $site_setting->top_header_notice : ''}}"
                                                   id="top_header_notice">
                                            <span style="color: green">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                Minimum 10 and Maximum 60 Character.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="logo_image">@lang('messages.Logo')<span
                                                        class="la-required">*</span></label>
                                            @if(!is_null($site_setting->logo_image))
                                            <img src="{{asset($site_setting->logo_image)}}" alt="Logo Image"
                                                 class="img-responsive">
                                            @else
                                            <img src="{{asset('uploads/products/default/default.png')}}" alt="No Image"
                                                 width="250px"
                                                 height="250px" class="img-responsive">
                                            @endif
                                            <input style="margin-top: 5px" type="file" id="logo_image" name="logo_image" accept="image/png,image/gif,image/jpeg,image/jpg">
                                            <span style="color: red;font-weight: bold">Image Must Be 120 X 27</span>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="product_banner_image">@lang('messages.Banner')<span
                                                        class="la-required">*</span></label>
                                            @if(!is_null($site_setting->product_banner_image))
                                            <img src="{{asset($site_setting->product_banner_image)}}" alt="Banner Image"
                                                 class="img-responsive">
                                            @else
                                            <img src="{{asset('uploads/products/default/default.png')}}" alt="No Image"
                                                 width="250px"
                                                 height="250px" class="img-responsive">
                                            @endif
                                            <input style="margin-top: 5px" type="file" id="product_banner_image" name="product_banner_image" accept="image/png,image/gif,image/jpeg,image/jpg">
                                            <span style="color: red;font-weight: bold">Image Must Be 1920 X 239</span>
                                        </div>
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
                $(this).tab('show');
            });

        });
    </script>
    @endpush

    <script type="text/javascript">

    </script>
