@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/wedding_sliders') }}">@lang('messages.Wedding Slider')</a> :
@endsection
@section("section", trans("messages.Slider"))
@section("section_url", url(config('laraadmin.adminRoute') . '/wedding_sliders'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Add Wedding Slider"))

@section("main-content")
    <style type="text/css">
        #save_div {
            display: none;
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

    <div class="box box-success">
        {!! Form::open(['action' => 'Admin\Marriage_Management\MarriageSliderController@store','files'=>true, 'id' => 'slider-add-form']) !!}
        <div class="box-body">
            <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="Sliders_wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">@lang('messages.Slider Title') (English) <span
                                        class="la-required">*</span></label>
                            <input type="text" minlength="10" maxlength="50" class="form-control title" name="title"
                                   placeholder="@lang('messages.Slider Title')" value="{{old('title')}}" required>
                            <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Minimum 10 and Maximum 50 Character.
                                </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bn_title">@lang('messages.Slider Title') (Bengali) <span
                                        class="la-required">*</span></label>
                            <input type="text" minlength="10" maxlength="50" required class="form-control bn_title"
                                   name="bn_title" placeholder="@lang('messages.Slider Title')"
                                   value="{{old('title')}}">
                            <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Minimum 10 and Maximum 50 Character.
                                </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subtitle">@lang('messages.Slider Sub-Title') (English) <span
                                        class="la-required">*</span></label>
                            <input type="text" minlength="10" maxlength="100" class="form-control subtitle"
                                   name="subtitle" placeholder="@lang('messages.Slider Sub-Title')"
                                   value="{{old('title')}}" required>
                            <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Minimum 10 and Maximum 100 Character.
                                </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bn_subtitle">@lang('messages.Slider Sub-Title') (Bengali) <span
                                        class="la-required">*</span></label>
                            <input type="text" minlength="10" maxlength="100" required class="form-control bn_subtitle"
                                   name="bn_subtitle" placeholder="@lang('messages.Slider Sub-Title')"
                                   value="{{old('title')}}">
                            <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Minimum 10 and Maximum 100 Character.
                                </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description_up">@lang('messages.Slider Up Description') (English) <span
                                        class="la-required">*</span></label>
                            <textarea class="form-control description_up" minlength="50" maxlength="400"
                                      name="description_up" required
                                      placeholder="@lang('messages.Slider Up Description')"></textarea>
                            <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Minimum 50 and Maximum 400 Character.
                                </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bn_description_up">@lang('messages.Slider Up Description') (Bengali) <span
                                        class="la-required">*</span></label>
                            <textarea class="form-control bn_description_up" required minlength="50" maxlength="400"
                                      placeholder="@lang('messages.Slider Up Description')"
                                      name="bn_description_up"></textarea>
                            <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Minimum 50 and Maximum 400 Character.
                                </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description_down">@lang('messages.Slider Down Description') (English) <span
                                        class="la-required">*</span></label>
                            <textarea class="form-control description_down" minlength="50" maxlength="400"
                                      name="description_down" required
                                      placeholder="@lang('messages.Slider Down Description')"></textarea>
                            <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Minimum 50 and Maximum 400 Character.
                                </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bn_description_down">@lang('messages.Slider Down Description') (Bengali) <span
                                        class="la-required">*</span></label>
                            <textarea class="form-control bn_description_down" required minlength="50" maxlength="400"
                                      placeholder="@lang('messages.Slider Down Description')"
                                      name="bn_description_down"></textarea>
                            <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Minimum 50 and Maximum 400 Character.
                                </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="button_label">@lang('messages.Button Label') (English) <span
                                        class="la-required">*</span></label>
                            <input class="form-control button_label"  maxlength="25" name="button_label" required
                                      placeholder="@lang('messages.Button Label')">
                            <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Maximum 25 Character.
                                </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bn_button_label">@lang('messages.Button Label') (Bengali) <span
                                        class="la-required">*</span></label>
                            <input class="form-control bn_button_label" required maxlength="15"
                                      placeholder="@lang('messages.Button Label')"
                                      name="bn_button_label">
                            <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Maximum 15 Character.
                                </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="button_link">@lang('messages.Button Link')<span
                                        class="la-required">*</span></label>
                            <input class="form-control button_link" name="button_link" required
                                   placeholder="@lang('messages.Button Link')">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="button_color">@lang('messages.Button Color')</label>
                            <select class="form-control type" name="button_color" >
                                <option value="1" selected>White</option>
                                <option value="2" >Theme Color</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="is_show">Slider Status</label>
                            <select class="form-control type" name="is_show" >
                                <option value="1" selected>Show in website</option>
                                <option value="2" >Not show in website</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="image">@lang('messages.Slider Image') <span class="la-required">*</span></label>
                            <div style="margin-top: 0" class="media">
                                <div class="media-body slider_image">
                                    <input type="file" id="photo-add" class="form-control image" name="image" accept="image/jpeg,image/jpg" required>
                                    <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg Only. Size: 1220X844px
                                         </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div id="image-preview"></div>
                    </div>
                </div>
                <div class="row" id="sliders-submit-wrapper">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute') .'/wedding_sliders') }}">@lang('messages.Cancel')</a>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>


@endsection

@push('styles')
<style>
    .single-image {
        width: 100px;
        height: 80px;
        display: inline;
        padding: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
    /*Multiple image brows after show*/
    $(function () {
        $('#slider-add-form').validate();
        var imagesPreview = function (input, placeToInsertImagePreview) {
            $(placeToInsertImagePreview).empty();
            if (input.files) {
                var filesAmount = input.files.length;
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $($.parseHTML('<img class="single-image">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    };
                    reader.readAsDataURL(input.files[i]);
                }
            }

        };

        $('#photo-add').on('change', function () {
            imagesPreview(this, 'div#image-preview');
        });
    });
</script>

@endpush
