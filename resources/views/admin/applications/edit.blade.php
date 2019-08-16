@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/applications') }}">@lang('messages.Applications')</a> :
@endsection
@section("section", trans("messages.Slider"))
@section("section_url", url(config('laraadmin.adminRoute') . '/applications'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Edit Applications"))

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
        {!! Form::model($applications, ['route' => [config('laraadmin.adminRoute') . '.applications.update', $applications->id ],'method' =>'PUT','files' => true,'role'=>"form"]) !!}
        <div class="box-body">
            <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="Sliders_wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">@lang('messages.Groom Name')<span
                                        class="la-required">*</span></label>
                            <input name="groom_name" id="groom_name" type="text"
                                   placeholder="@lang('messages.Enter Groom Name')" required
                                   class="form-control" value="{{$applications->groom_name or null}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bn_groom_name">@lang('messages.Enter Groom Name(Bangla)')<span
                                        class="la-required">*</span></label>
                            <input name="bn_groom_name" id="bn_groom_name" type="text"
                                   placeholder="@lang('messages.Enter Groom Name(Bangla)')" required
                                   class="form-control" value="{{$applications->bn_groom_name or null}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bride_name">@lang('messages.Bride Name')<span
                                        class="la-required">*</span></label>
                            <input name="bride_name" id="bride_name" type="text"
                                   placeholder="@lang('messages.Enter Bride Name')" required
                                   class="form-control" value="{{$applications->bride_name or null}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bn_bride_name">@lang('messages.Enter Bride Name(Bangla)')<span
                                        class="la-required">*</span></label>
                            <input name="bn_bride_name" id="bn_bride_name" type="text"
                                   placeholder="@lang('messages.Enter Bride Name(Bangla)')" required
                                   class="form-control" value="{{$applications->bn_bride_name or null}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="groom_email">@lang('messages.Groom Email')<span
                                        class="la-required">*</span></label>
                            <input name="groom_email" id="groom_email"
                                   class="form-control" type="email" required
                                   placeholder="@lang('messages.Enter Groom Email')" value="{{$applications->groom_email or null}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bride_email">@lang('messages.Bride Email')<span
                                        class="la-required">*</span></label>
                            <input name="bride_email" id="bride_email"
                                   class="form-control" type="email" required
                                   placeholder="@lang('messages.Enter Bride Email')" value="{{$applications->bride_email or null}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="marriage_venue">@lang('messages.Venu')<span
                                        class="la-required">*</span></label>
                            <input name="marriage_venue" id="marriage_venue"
                                   class="form-control"  required type="text"
                                   placeholder="@lang('messages.Enter Venue Name')" value="{{$applications->marriage_venue or null}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bn_marriage_venue">@lang('messages.Venue(Bangla)')<span
                                        class="la-required">*</span></label>
                            <input name="bn_marriage_venue" id="bn_marriage_venue"
                                   class="form-control"  required type="text"
                                   placeholder="@lang('messages.Enter Venue Name(Bangla)')" value="{{$applications->bn_marriage_venue or null}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="marriage_venue">@lang('messages.Wedding Date')<span
                                        class="la-required">*</span></label>
                            <div class='input-group date' id='datetimepicker1'>
                                <input type='text' name="marriage_date"
                                       placeholder="@lang('messages.Enter Wedding Date')" required
                                       class="form-control" value="@if(isset($marriage_date)) {{$marriage_date}} @else {{ App\Helpers\CommonHelper::showDateFormat(date('Y-m-d')) }} @endif"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>@lang('messages.Reception Time')
                                <span class="la-required">*</span>
                            </label>
                            <div class='input-group' id='from'>
                                <input type='text' placeholder="@lang('messages.From')" name="from" required class="form-control" value="{{$start or null}}" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class='input-group' id='to'>
                                <input type='text'  placeholder="@lang('messages.To')" name="to" required class="form-control" value="{{$end or null}}" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('messages.Message')
                                <small class="mendatory">*</small>
                            </label>
                            <textarea name="message" id="message" class="form-control required" rows="3"
                                      placeholder="@lang('messages.Enter Message')">{{$applications->message or null}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('messages.Message(Bangla)')
                                <small class="mendatory">*</small>
                            </label>
                            <textarea name="bn_message" id="bn_message" class="form-control required" rows="3"
                                      placeholder="@lang('messages.Enter Message(Bangla)')">{{$applications->bn_message or null}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>@lang('messages.Contact No')
                                <small class="mendatory">*</small>
                            </label>
                            <input name="contact_no" id="contact_no" type="text"
                                   placeholder="@lang('messages.Enter Contact No')" required
                                   class="form-control" value="{{$applications->contact_no or null}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>@lang('messages.In favor')
                                <small class="mendatory">*</small>
                            </label>
                            <select name="profile" class="form-control required">
                                <option value="1" {{$applications->profile==1? "selected":"" }}>Groom</option>
                                <option value="2" {{$applications->profile==2? "selected":"" }}>Bride</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('messages.Groom Image')<small class="mendatory">*</small></label>
                            <input name="groom_image" class="file form-control" type="file"
                                   data-show-upload="false" data-show-caption="true">
                            <small class="suggestion">@lang('messages.Type: jpeg,jpg Size: 270X270px')</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                       <div class="form-group">
                           @if(!is_null($applications->groom_image))
                               <a ><img src="{{asset($applications->groom_image)}}" alt="Image" width="90px"
                                        height="90px"></a>
                           @else
                               <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="90px"
                                    height="90px">
                           @endif
                       </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('messages.Bride Image')<small class="mendatory">*</small></label>
                            <input name="bride_image" class="file form-control" type="file"
                                   data-show-upload="false" data-show-caption="true">
                            <small class="suggestion">@lang('messages.Type: jpeg,jpg Size: 270X270px')</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        @if(!is_null($applications->bride_image))
                            <a ><img src="{{asset($applications->bride_image)}}" alt="Image" width="90px"
                                     height="90px"></a>
                        @else
                            <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="90px"
                                 height="90px">
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('messages.Invitation Card Image')<small class="mendatory">*</small></label>
                            <input name="card_image" class="file form-control" type="file"
                                   data-show-upload="false" data-show-caption="true">
                            <small class="suggestion">@lang('messages.Type: jpeg,jpg Size: 440X643px')</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        @if(!is_null($applications->card_image))
                            <a ><img src="{{asset($applications->card_image)}}" alt="Image" width="90px"
                                     height="90px"></a>
                        @else
                            <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="90px"
                                 height="90px">
                        @endif
                    </div>
                </div>
                <div class="row" id="sliders-submit-wrapper">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute') .'/applications') }}">@lang('messages.Cancel')</a>
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
        $('#from, #to').datetimepicker({
            format: 'LT'
        });

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
