@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Project Objectives"))
@section("contentheader_description", trans("messages.Project Objectives listing"))
@section("section", trans("messages.Project Objectives"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Projects listing"))

@section("headerElems")
    @la_access("Sr_Project_Objectives", "create")
    <a data-toggle="modal" data-target="#AddModal"
       class="btn btn-success btn-sm  pull-right">  @lang("messages.Add Project Objective")</a>

   {{-- <a href="{{ url(config('laraadmin.adminRoute') . '/sr_project_objectives/create') }}"
       class="btn btn-success btn-sm pull-right"> @lang("messages.Add Project Sliders")</a>--}}
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
                    <th>Language</th>
                    <th style="min-width: 150px">Project Name</th>
                    <th>Project objective</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($values as $key=>$value)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$value->project_language->name or null}}</td>
                        <td>{{$value->sr_project_objective->sr_project_translation->name or null}}</td>
                        <td>{{$value->objective or null}}</td>

                        <td style="min-width: 80px!important;">

                            @la_access("Sr_Project_Objectives", "edit")
                            <a data-toggle="modal" data-target="#edit-project-obj-modal"
                               onclick="getObjData({{$value->id}})"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"> <i class="fa fa-edit"> </i></a>
                            @endla_access
                            @la_access("Sr_Project_Objectives", "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.sr_project_objectives.destroy', $value->id], 'method' => 'delete', 'style'=>'display:inline'])}}
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
    <div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"> &times; </span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Add Project Objective in Language</h4>
                </div>
                {!! Form::open(['action' => 'Admin\Save_Refugee\ProjectObjectivesController@store', 'id' => 'project-obj-form']) !!}

                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sr_project_id">@lang("messages.Project")<span
                                                class="la-required"> * </span>:</label>

                                    <select class="form-control select2" rel="select2" required="1" name="sr_project_id"
                                            id="">
                                        @foreach($projects as $project)
                                            {{--<option value="en">@lang("messages.English")</option>--}}
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">
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

                        </div>


                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="objective">@lang('messages.Project Objective') <span
                                                class="la-required">*</span>:</label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 150 for better looking
                                         </span>
                                <textarea type="text" class="form-control up_title"
                                          name="objective"
                                          placeholder="@lang('messages.Enter Project Objective')"
                                          required rows="5">{{old('objective')}}</textarea>

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
    @include('admin.save_refugee.project_objectives.common_project_objective_edit_modal')
            <!-- Edit Language modal end -->
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
        $("#project-obj-form").validate({});
    });
</script>
@endpush
