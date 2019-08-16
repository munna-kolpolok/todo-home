@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/sr_sliders') }}">@lang('messages.Sliders')</a> :
@endsection
@section("section", trans("messages.Sliders"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sr_sliders'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", trans("messages.Edit Sliders"))

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


    @if(session()->has('seccess_msg'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{ session()->get('seccess_msg') }}</strong>
        </div>
    @endif

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
        {{ Form::open( array('url' => config('laraadmin.adminRoute').'/sr_sliders/'.$sr_slider->id, 'method'=>'PATCH','files' => true,
           'id' => 'slider-edit-form'))}}

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
                                <option value="1" {{$sr_slider->content_align==1? "selected":""}}>Left Align</option>
                                <option value="2" {{$sr_slider->content_align==2? "selected":""}}>Right Align</option>
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
                                <option value="1" {{$sr_slider->type==1? "selected":""}}>Project</option>
                                <option value="2" {{$sr_slider->type==2? "selected":""}}>Volunteer</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row" >
                    <div style="{{$sr_slider->type==2? "display:none":""}}" id="project_select" >
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sr_project_id">@lang('messages.Select Project')<span
                                            class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control"  name="sr_project_id" id="sr_project_id" {{$sr_slider->type==2? "disabled":""}}>
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="file" id="" class="form-control image" name="image"
                                   accept="image/png,image/jpeg,image/jpg">
                                         <span class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Size: 1920X1280px
                                         </span>
                        </div>
                    </div>
                    <div class=" col-md-1">
                        @if(!is_null($sr_slider->image))
                            <img src="{{asset($sr_slider->image)}}" alt="Slider image"
                                 width="60px" height="40px">
                        @else
                            <img src="{{asset('uploads/default/profile_image.png')}}"
                                 alt="No Image" width="40px" height="40px">
                        @endif
                    </div>

                </div>

                <div class="row" >
                    <div class="col-md-12">
                        <div class="form-group" style="text-align: center; padding-top: 10px;">
                            {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute') .'/sr_sliders') }}">@lang('messages.Cancel')</a>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}

                <div class="row">
                    <h3 style="background-color: lightgray; text-align: center; padding: 5px;">Slider Details
                        <a data-toggle="modal" data-target="#AddSliderLanModal"
                           class="btn btn-success btn-sm  pull-right">  @lang("messages.Add Translation")</a></h3>

                    <div class="box-body">
                        <table id="example1" class="table table-bordered">
                            <thead>
                            <tr class="success">
                                <th>Serial</th>
                                <th>Language</th>
                                <th>Slider Title</th>
                                <th>Slider Sub-Title</th>
                                <th>Slider Description Up</th>
                                <th>Slider Description Down</th>
                                <th>Action </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($sr_slider_trns as $key=>$value)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$value->project_language->name}}</td>
                                    <td>{{$value->title}}</td>
                                    <td>{{$value->sub_title}}</td>
                                    <td>{{$value->description_up}}</td>
                                    <td>{{$value->description_down}}</td>


                                    <td style="min-width: 80px!important;">
                                        {{--<a href="{{ url(config('laraadmin.adminRoute') .'/sr_sliders/'.$value->id) }}"
                                           class="btn btn-success btn-xs" data-toggle="tooltip" title="Details"
                                           style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i> </a>--}}
                                        @la_access("sr_sliders", "edit")

                                        <a data-toggle="modal" data-target="#EditSliderLanModal"
                                           onclick="getSliderLang({{$value->id}})"
                                           class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                                           style="display:inline;padding:2px 5px 3px 5px;"> <i
                                                    class="fa fa-edit"></i></a>
                                        @endla_access
                                        {{--@la_access("sr_sliders", "delete")
                                        {{Form::open(['route' => [config('laraadmin.adminRoute') . '.sr_projects_tranlation.destroy', $value->id], 'method' => 'delete', 'style'=>'display:inline'])}}
                                        <button class="btn btn-danger btn-xs" type="submit" data-toggle="tooltip"
                                                title="Delete"
                                                onclick="return confirm('Are you sure to delete this entry?')"><i
                                                    class="fa fa-times" title="Delete"></i></button>
                                        {{Form::close()}}
                                        @endla_access--}}


                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>


            </div>

        </div>
    </div>

    <!-- modal start -->
    <div class="modal fade" id="AddSliderLanModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"> &times; </span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Add Slider Details</h4>
                </div>
                {!! Form::open(['action' => 'Admin\Save_Refugee\SlidersTrnaslationController@store', 'id' => 'slider-lan-form']) !!}

                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="sr_slider_id" value="{{$sr_slider->id}}">
                                <div class="form-group">
                                    <label for="lang">@lang("messages.Language")<span
                                                class="la-required"> * </span>:</label>

                                    <select class="form-control select2" rel="select2" required="1" name="lang"
                                            id="">
                                        @foreach($languages as $language)
                                            {{--<option value="en">@lang("messages.English")</option>--}}
                                            <option value="{{ $language->code }}">{{ $language->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">Slider Title<span
                                                class="la-required"> * </span>:</label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 25
                                         </span>

                                    <input type="text" class="form-control " id=""
                                           placeholder="Enter Slider Title" name="title"
                                           required="1">

                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sub_title">Slider Sub Title<span
                                                class="la-required"> * </span>:</label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 80-100 for better looking
                                         </span>

                                    <input type="text" class="form-control " id=""
                                           placeholder="Enter Slider Sub Title" name="sub_title"
                                           required="1">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description_up">Slider Description Up<span
                                                class="la-required"> * </span>:</label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 180-200 for better looking
                                         </span>

                                    <textarea type="text" class="form-control " id=""
                                           placeholder="Enter Slider Description Up" name="description_up"
                                           required="1">{{old('description_up')}}</textarea>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description_down">Slider Description Down<span
                                                class="la-required">*</span>:</label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 500-600 for better looking
                                         </span>
                                <textarea type="text" class="form-control"
                                          name="description_down"
                                          placeholder="Enter Slider Description Down"
                                          required >{{old('description_down')}}</textarea>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.Close')</button>
                    {{--<button type="button" class="btn btn-success" onclick="add_lan()">@lang('messages.Save')</button>--}}
                    {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- modal end -->
    <!-- Edit Language modal start -->
    @include('admin.save_refugee.sliders.common_slider_language_edit_modal')
    <!-- Edit Language modal end -->
@endsection
@push('styles')
{{--<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>--}}
<link href="{{ asset('la-assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('scripts')
{{--<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>--}}
<script type="text/javascript">
    $(function () {

        $("#slider-edit-form").validate({});
        $("#slider-lan-form").validate({});

    });

    /*   $(function () {
     $('#example1').DataTable({
     responsive: false,
     stateSave: true,
     columnDefs: [{orderable: false, targets: [-1]}]
     });
     });*/

    /*Project type check*/
    function checkTypeFunc(val) {
        if (val == 2) {
            $('#project_select').hide();
            $( "#sr_project_id" ).prop( "disabled", true );

        } else {
            $('#project_select').show();
            $( "#sr_project_id" ).prop( "disabled", false );

        }
    }
</script>
@endpush
