@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Projects Sliders"))
@section("contentheader_description", trans("messages.Projects Sliders listing"))
@section("section", trans("messages.Projects Sliders"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Projects listing"))

@section("headerElems")
    @la_access("Sr_Projects", "create")

    <a href="{{ url(config('laraadmin.adminRoute') . '/sr_project_sliders/create') }}"
       class="btn btn-success btn-sm pull-right"> @lang("messages.Add Project Sliders")</a>
    @endla_access
@endsection

@section("main-content")

    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{ session()->get('message') }}</strong>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="box box-success">
        <!--<div class="box-header"></div>-->
        <div class="box-body">
            <table id="example1" class="table table-bordered">
                <thead>
                <tr class="success">
                    <th>Serial</th>
                    <th>Project Name</th>
                    <th>Slider Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($values as $key=>$value)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$value->translation->name or null}}</td>

                        <td style="vertical-align: middle;" align="center">
                            @la_access("Sr_Projects", "edit")
                            <a data-toggle="modal" data-target="#edit-slide-modal"
                                    onclick="getSlideImage({{$value->id}})" data-toggle="tooltip" title="Edit"
                                    style="cursor: pointer;"> <img src="{{asset($value->image)}}" alt="image" style="margin: 0 auto; height: 35px; width: 50px; "></a>
                            @endla_access

                        </td>
                        <td style="min-width: 80px!important;">

                            @la_access("Sr_Projects", "edit")
                            <a {{--href="{{url(config('laraadmin.adminRoute').'/sr_project_sliders/'.$value->id.'/edit')}}"--}}
                                    data-toggle="modal" data-target="#edit-slide-modal"
                                    onclick="getSlideImage({{$value->id}})" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"> <i class="fa fa-edit">  </i></a>
                            @endla_access
                            @la_access("Sr_Projects", "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.sr_project_sliders.destroy', $value->id], 'method' => 'delete', 'style'=>'display:inline'])}}
                            <button class="btn btn-danger btn-xs" type="submit" data-toggle="tooltip" title="Delete"
                                    onclick="return confirm('Are you sure to delete this entry?')"><i
                                        class="fa fa-times" title="Delete"> </i></button>
                            {{Form::close()}}
                            @endla_access


                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- modal start -->
    <div class="modal fade" id="edit-slide-modal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"> &times; </span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Edit Project Slide Image</h4>
                </div>

                {{ Form::open( array('url' => '', 'method'=>'PATCH', 'files'=>true, 'id' => 'slide-edit-form'))}}

                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" id="project_id" name="sr_project_id">
                                    <label for="sr_project_id">@lang("messages.Project")<span
                                                class="la-required"> * </span>:</label>

                                    <select class="form-control select2" rel="select2" required="1" name=""
                                            id="sr_project_id_edit" disabled>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name or null }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="image">@lang('messages.Slider Image') <span
                                                class="la-required">*</span>:</label>
                                <input type="file" class="form-control image"
                                          name="image" accept="image/png,image/jpeg,image/jpg"
                                          required/><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>   Type: jpeg,jpg,png,gif. Size: 350X208px
                                         </span>

                                </div>
                            </div>
                            <div class="col-md-12" id="slider_img">
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
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
    $(function () {
        $('#example1').DataTable({
            responsive: false,
            stateSave: true,
            columnDefs: [{orderable: false, targets: [-1]}]
        });

        $("#slide-edit-form").validate({});
    });


    function getSlideImage(val){
        var project_slider_id=val;
        /*Edit  modal value set*/

        $.ajax({
            type:"POST",
            url: "{{url('admin/get-project-slide-image')}}",
            data: {id: project_slider_id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (data) {
                var project_slider_id=(data.id);
                $('#project_id').val(data.sr_project_id);
               // $('#slider_img').html("<img src='{{asset('')}}' />");
                $('#sr_project_id_edit').val(data.sr_project_id).trigger('change.select2');
                $('#slide-edit-form').attr('action', "{{url('/admin/sr_project_sliders')}}" + '/' + project_slider_id);


            }
        });
    }
</script>
@endpush
