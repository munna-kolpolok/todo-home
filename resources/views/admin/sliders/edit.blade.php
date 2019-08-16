@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/sliders') }}">@lang('messages.Slider')</a> :
@endsection
@section("section", trans("messages.Slider"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sliders'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", trans("messages.Edit Slider"))

@section("main-content")
    <style type="text/css">
        #save_div {
            display: none;
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

    <div class="box box-success">
        {!! Form::model($sliders, ['route' => [config('laraadmin.adminRoute') . '.sliders.update', $sliders->id ],'method' =>'PUT','files' => true,'role'=>"form"]) !!}

        <div class="box-body">
                <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="Sliders_wrapper">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="up_title">@lang('messages.Slider Title') (English) <span class="la-required">*</span></label>
                                <input type="text" minlength="10" maxlength="50" class="form-control up_title" name="up_title" value="{{$sliders->up_title or null}}" placeholder="@lang('messages.Slider Title')"  required>
                                <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Minimum 10 and Maximum 50 Character.
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bn_up_title">@lang('messages.Slider Title') (Bengali)</label>
                                <input type="text"  minlength="10" maxlength="50" class="form-control bn_up_title" placeholder="@lang('messages.Slider Title')" name="bn_up_title" value="{{$sliders->bn_up_title or null}}" >
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
                                <label for="down_title">@lang('messages.Slider Sub-Title') (English) <span class="la-required">*</span></label>
                                <input type="text" minlength="10" maxlength="100" class="form-control down_title" name="down_title" value="{{$sliders->down_title or null}}" placeholder="@lang('messages.Slider Sub-Title')" required>
                                <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Minimum 10 and Maximum 100 Character.
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bn_down_title">@lang('messages.Slider Sub-Title') (Bengali)</label>
                                <input type="text"  minlength="10" maxlength="100" class="form-control bn_down_title" placeholder="@lang('messages.Slider Sub-Title')" name="bn_down_title" value="{{$sliders->bn_down_title or null}}">
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
                                <label for="message">@lang('messages.Slider Message') (English) <span class="la-required">*</span></label>
                                <textarea class="form-control message" minlength="50" maxlength="400" placeholder="@lang('messages.Slider Message')" name="message" required>{{$sliders->message or null}}</textarea>
                                <span class="suggestion_text"> 
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Minimum 50 and Maximum 400 Character.
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bn_message">@lang('messages.Slider Message') (Bengali)</label>
                                <textarea type="text" class="form-control bn_message" minlength="50" maxlength="400" placeholder="@lang('messages.Slider Message')" name="bn_message">{{$sliders->bn_message or null}}</textarea>
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
                                <label for="type">@lang('messages.Slider Type') <span class="la-required">*</span></label>
                                <select class="form-control type" name="type" required="">
                                <?php
                                     $slider_types = array(1=>"Donate",2=>"Scholarship",3=>"Sign in",4=>"Volunteer",5=>"Rohinga camp" );
                                        foreach ($slider_types as $key => $value) {?>
                                            <option value="<?= $key ?>" <?= $key==$sliders->type? "selected": "" ?>><?= $value ?></option>
                                         <?php }
                                ?>
                                </select>
                                <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Minimum 150 and Maximum 180 Character.
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">@lang('messages.Slider Image') <span class="la-required">*</span></label>
                                <div style="margin-top: 0" class="media">
                                    <div class="media-left">
                                        @if(!is_null($sliders->image))
                                       <a ><img src="{{asset($sliders->image)}}" alt="Image" width="90px"
                                             height="50px"></a> 
                                    @else
                                        <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="50px"
                                             height="30px">
                                    @endif
                                    </div>
                                    <div class="media-body slider_image">
                                        <input type="file" id="" class="form-control image" name="image" accept="image/png,image/gif,image/jpeg,image/jpg">
                                         <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size: 1920X870px
                                         </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Slider Status</label>
                                <select class="form-control type" name="status" >
                                    <option value="1" {{$sliders->status==1? "selected":"" }}>Active</option>
                                    <option value="2" {{$sliders->status==2? "selected":"" }}>Inactive</option>
                                </select>

                            </div>
                        </div>
                    </div>
                  
                </div>
                <div class="row" id="sliders-submit-wrapper">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute') .'/sliders') }}">@lang('messages.Cancel')</a>
                            <!-- <button class="btn btn-info pull-right" id="add-row">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add row
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>


@endsection

@push('scripts')

@endpush
