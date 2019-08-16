@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/sr_sliders') }}">@lang('messages.Sliders')</a> :
@endsection
@section("section", trans("messages.Sliders"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sr_sliders'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Add Sliders"))

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
        {!! Form::open(['action' => 'Admin\Save_Refugee\SlidersController@store','files'=>true, 'id' => 'slider-add-form']) !!}
        <div class="box-body">
            <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="content_align">@lang('messages.Slider Align')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="content_align" id="content_align" required>
                                <option value="1">Left Align</option>
                                <option value="2">Right Align</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="type">Slider Type<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="type" id="type" required onchange="checkTypeFunc(this.value)">
                                <option value="1">Project</option>
                                <option value="2">Volunteer</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row" >
                    <div style="" id="project_select">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sr_project_id">@lang('messages.Select Project')<span
                                            class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control" name="sr_project_id" id="sr_project_id" required>
                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}">{{$project->name or null}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="image">@lang('messages.Slider Image')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="file" id="" class="form-control image" name="image"
                                   accept="image/png,image/jpeg,image/jpg" required>
                                         <span class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size: 1920X1280px
                                         </span>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <h4 style="background-color: lightgray; text-align: center; padding: 5px;">Slider Details in English</h4>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title"> Title<span
                                        class="la-required">*</span></label> <span class="suggestion_text"><i
                                        class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 25 for better looking
                                         </span>
                            <input type="text" class="form-control title"
                                   name="title" placeholder="Enter Title in English"
                                   value="{{old('title')}}" required>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sub_title">Sub Title<span
                                        class="la-required">*</span></label><span class="suggestion_text"><i
                                        class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 80-100 for better looking
                                         </span>
                            <input type="text" class="form-control "
                                   name="sub_title" placeholder="Enter Sub Title in English"
                                   value="{{old('sub_title')}}" required>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description_up">Description Up <span
                                        class="la-required">*</span></label><span class="suggestion_text"><i
                                        class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 180-200 for better looking
                                         </span>
                                <textarea type="text" class="form-control "
                                          name="description_up"
                                          placeholder="Enter Description Up in English"
                                          required rows="3">{{old('description_up')}}</textarea>

                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description_down">Description Down <span
                                        class="la-required">*</span></label><span class="suggestion_text"><i
                                        class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 500-600 for better looking
                                         </span>
                                <textarea type="text" class="form-control "
                                          name="description_down"
                                          placeholder="Enter Description Down in English"
                                          required rows="3">{{old('description_down')}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" style="text-align: center">
                        {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                        <a class="btn btn-default"
                           href="{{ url(config('laraadmin.adminRoute') .'/sr_sliders') }}">@lang('messages.Cancel')</a>
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
<script type="text/javascript">
    $(function () {

        $("#slider-add-form").validate({});
        $(".nav-tabs a").click(function () {
            $(this).tab('show');
        });

    });


    /*Project type check*/
    function checkTypeFunc(val) {
        if (val == 2) {

            $('#project_select').hide();
            //$('#sr_project_id').val('');

        } else {
            $('#project_select').show();

        }
    }


</script>
@endpush
