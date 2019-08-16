@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/sr_projects') }}">@lang('messages.Project')</a> :
@endsection
@section("section", trans("messages.Project"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sr_projects'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", trans("messages.Edit Project"))

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
        {{ Form::open( array('url' => config('laraadmin.adminRoute').'/sr_projects/'.$project->id, 'method'=>'PATCH','files' => true,
           'id' => 'project-edit-form'))}}

        <div class="box-body">
            <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="up_title">@lang('messages.Project Target') <span
                                        class="la-required">*</span></label>
                            <input type="number" class="form-control up_title" name="target"
                                   placeholder="@lang('messages.Enter Project Target')" value="{{$project->target}}"
                                   required>
                                <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Must be a number.
                                </span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="project_image">@lang('messages.Project Image')</label>

                            <div style="margin-top: 0" class="media">
                                <div class="media-left">
                                    @if(!is_null($project->project_image))
                                        <img src="{{asset($project->project_image)}}" alt="Project image"
                                             width="80px" height="40px">
                                    @else
                                        <img src="{{asset('uploads/default/profile_image.png')}}"
                                             alt="No Image" width="80px" height="40px">
                                    @endif
                                </div>
                                <div class="media-body">
                                    <input type="file" id="project_image" class="form-control" name="project_image"
                                           accept="image/png,image/gif,image/jpeg,image/jpg">
                                                 <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                                  aria-hidden="true"></i> Size:320X240px, Type:jpeg,jpg
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="image">@lang('messages.Video Link') <span class="la-required">*</span></label>

                            <div class="form-group">
                                <input type="url" class="form-control video_link" name="video_link"
                                       placeholder="@lang('messages.Enter Valid Url')"
                                       value="{{$project->video_link}}" required>
                                     <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                         @lang('messages.Enter Valid Url')
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="is_menu">@lang('messages.Menu')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="is_menu" id="is_menu" required>
                                <option value="1" {{$project->is_menu==1?'selected':''}}>Yes</option>
                                <option value="2" {{$project->is_menu==2?'selected':''}}>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="is_home">@lang('messages.Home')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="is_home" id="is_home" required>
                                <option value="1" {{$project->is_home==1?'selected':''}}>Yes</option>
                                <option value="2" {{$project->is_home==2?'selected':''}}>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="is_show">@lang('messages.Show')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="is_show" id="is_show" required>
                                <option value="1" {{$project->is_show==1?'selected':''}}>Yes</option>
                                <option value="2" {{$project->is_show==2?'selected':''}}>No</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row" id="">
                    <div class="col-md-12">
                        <div class="form-group" style="text-align: center; padding-top: 10px;">
                            {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-warning']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute') .'/sr_projects') }}">@lang('messages.Cancel')</a>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}

                <div class="row">
                    <h3 style="background-color: lightgray; text-align: center; padding: 5px;">Project Details
                        <a data-toggle="modal" data-target="#AddLanModal"
                           class="btn btn-success btn-sm  pull-right">  @lang("messages.Add Translation")</a></h3>

                    <div class="box-body">
                        <table id="example1" class="table table-bordered">
                            <thead>
                            <tr class="success">
                                <th>Serial</th>
                                <th>Language</th>
                                <th>Project Name</th>
                                <th>Projects Title</th>
                                <th>Projects Sub-Title</th>
                                <th>Projects Description</th>
                                <th>Action @la_access("Sr_Projects", "create")

                                    @endla_access
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($project_transtaltion as $key=>$value)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$value->project_language->name or null}}</td>
                                    <td>{{$value->name or null}}</td>
                                    <td>{{$value->title or null}}</td>
                                    <td>{{$value->subtitle or null}}</td>
                                    <td>{{$value->description or null}}</td>

                                    <td style="min-width: 80px!important;">
                                        {{--<a href="{{ url(config('laraadmin.adminRoute') .'/sr_projects/'.$value->id) }}"
                                           class="btn btn-success btn-xs" data-toggle="tooltip" title="Details"
                                           style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i> </a>--}}
                                        @la_access("Sr_Projects", "edit")

                                        <a data-toggle="modal" data-target="#edit-project-lang-modal"
                                           onclick="getProjecLang({{$value->id}})"
                                           class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                                           style="display:inline;padding:2px 5px 3px 5px;"> <i
                                                    class="fa fa-edit"> </i></a>
                                        @endla_access
                                        {{--@la_access("Sr_Projects", "delete")
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
    <div class="modal fade" id="AddLanModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"> &times; </span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Add Project Details in Language</h4>
                </div>
                {!! Form::open(['action' => 'Admin\Save_Refugee\ProjectsTrnaslationController@store', 'id' => 'project-lan-form']) !!}

                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" value="{{$project->id}}" name="sr_project_id">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">@lang("messages.Project Name")<span
                                                class="la-required"> * </span>:</label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 25
                                         </span>

                                    <input type="text" class="form-control " id="name"
                                           placeholder="@lang("messages.Enter project Name")" name="name"
                                           required="1">

                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">@lang("messages.Project Title")<span
                                                class="la-required"> * </span>:</label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 80-100 for better looking
                                         </span>

                                    <input type="text" class="form-control " id="title"
                                           placeholder="@lang("messages.Enter Project Title")" name="title"
                                           required="1">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="subtitle">@lang("messages.Project Sub-Title")<span
                                                class="la-required"> * </span>:</label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 180-200 for better looking
                                         </span>

                                    <input type="text" class="form-control " id="subtitle"
                                           placeholder="@lang("messages.Enter Project Sub-Title")" name="subtitle"
                                           required="1">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="description">@lang('messages.Project Description') <span
                                                class="la-required">*</span>:</label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 500-600 for better looking
                                         </span>
                                <textarea type="text" class="form-control up_title"
                                          name="description"
                                          placeholder="@lang('messages.Enter Project Description')"
                                          required rows="5">{{old('description')}}</textarea>

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
    @include('admin.save_refugee.projects.common_project_language_edit_modal')
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

        $("#project-edit-form").validate({});
        $("#project-lan-form").validate({});

    });

    /*   $(function () {
     $('#example1').DataTable({
     responsive: false,
     stateSave: true,
     columnDefs: [{orderable: false, targets: [-1]}]
     });
     });*/
</script>
@endpush
