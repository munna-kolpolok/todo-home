@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/sr_project_story') }}">@lang('messages.Project Story')</a> :
@endsection
@section("section", trans("messages.Project"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sr_project_story'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", trans("messages.Edit Project Story"))

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


    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{ session()->get('message') }}</strong>
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
        {{ Form::open( array('url' => config('laraadmin.adminRoute').'/sr_project_story/'.$sr_project_story->id, 'method'=>'PATCH','files'=>true, 'id' => 'project-edit-form'))}}
        <div class="box-body">
            <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sr_project_id">@lang('messages.Project') <span
                                        class="la-required">*</span></label>
                            <select class="form-control" rel="select2" required="1" name="sr_project_id"
                                    id="sr_project_id" disabled>
                                <?php echo $projectOptions;?>
                            </select>
                            <input type="hidden" name="test">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="media_type">@lang('messages.Media Type') <span
                                        class="la-required">*</span></label>
                            <select class="form-control" name="media_type" id="media_type" required disabled>
                                <option selected value="1">Image</option>
                                <option value="2">Video</option>
                            </select>
                        </div>
                    </div>
                    @if(!empty($sr_project_story->video_link))
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="image">Video Link<span class="la-required">*</span></label>
                                    <input type="url" class="form-control video_link" name="video_link"
                                           placeholder="Enter Valid Url"
                                           value="{{$sr_project_story->video_link or null}}" required>
                                    <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        Enter Valid Url
                                </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="no_of_image">@lang('messages.Number Of Image') <span
                                            class="la-required">*</span></label>
                                <select class="form-control" name="no_of_image" id="no_of_image"
                                        onchange="addedNoOfUpload()" required disabled>
                                    <option selected value="1">1</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>
                        @forelse($sr_project_story->projectStoryImages as $image)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="images">Select Image</label>
                                    <input type="file" class="form-control" name="images[]">
                                    <span class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size: 540X370px</span>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <img src="{{asset($image->image)}}" alt="Image" class="img-responsive"
                                         style="margin-top: 25px">
                                </div>
                            </div>
                        @empty
                            <p>No Image available</p>
                        @endforelse
                    @endif
                </div>
                <div class="row" id="">
                    <div class="col-md-12">
                        <div class="form-group" style="text-align: center; padding-top: 10px;">
                            {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute') .'/sr_project_story') }}">@lang('messages.Cancel')</a>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}

                <div class="row" id="translation">
                    <h3 style="background-color: lightgray; text-align: center; padding: 5px;">Project Story Details
                        <a data-toggle="modal" data-target="#AddLanModal" class="btn btn-success btn-sm  pull-right">
                            <i class="fa fa-language" aria-hidden="true"></i>
                            @lang("messages.Add Story Language Content")
                        </a>
                    </h3>

                    <div class="box-body">
                        <table id="example1" class="table table-bordered">
                            <thead>
                            <tr class="success">
                                <th>Serial</th>
                                <th>Language</th>
                                <th>Project Name</th>
                                <th>Story Title</th>
                                <th>Story Description</th>
                                <th>Action @la_access("Sr_Project_Stories", "create")

                                    @endla_access
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($sr_project_story->projectStoryTranslations as $key=>$value)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$value->storyLanguage->name or null}}</td>
                                    <td>{{$projectName or null}}</td>
                                    <td>{{$value->title or null}}</td>
                                    <td>{{$value->description or null}}</td>
                                    <td style="min-width: 80px!important;">
                                        @la_access("Sr_Project_Stories", "edit")
                                        <a data-toggle="modal" data-target="#EditLanModal"
                                           onclick="getStoryTraslationValue({{$value->id}})"
                                           class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                                           style="display:inline;padding:2px 5px 3px 5px;"> <i class="fa fa-edit"> </i></a>
                                        @endla_access
                                        @la_access("Sr_Project_Stories", "delete")
                                        {{Form::open(['route' => [config('laraadmin.adminRoute') . '.sr_project_story_translation.destroy', $value->id], 'method' => 'delete', 'style'=>'display:inline'])}}
                                        <button class="btn btn-danger btn-xs" type="submit" data-toggle="tooltip"
                                                title="Delete"
                                                onclick="return confirm('Are you sure to delete this entry?')"><i
                                                    class="fa fa-times" title="Delete"></i></button>
                                        {{Form::close()}}
                                        @endla_access


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
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Add Project Story Details in
                        Language</h4>
                </div>
                {!! Form::open(['action' => 'Admin\Save_Refugee\ProjectStoryTranslationController@store', 'id' => 'project-lan-form']) !!}

                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" value="{{$sr_project_story->id}}" name="sr_project_story_id">
                                    <label for="lang">@lang("messages.Language")<span
                                                class="la-required"> * </span>:</label>

                                    <select class="form-control select2" rel="select2" required="1" name="lng"
                                            id="">
                                        <?php echo $languageOptions;?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">@lang('messages.Project Story Title') <span
                                                class="la-required">*</span></label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 80-100 for better looking
                                         </span>
                                    <input type="text" class="form-control "
                                           name="title" placeholder="@lang('messages.Enter Project Story Title')"
                                           value="{{old('title')}}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">@lang('messages.Project Story Description') <span
                                                class="la-required">*</span></label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 180-200 for better looking
                                         </span>
                                    <textarea type="text" class="form-control up_title"
                                              name="description"
                                              placeholder="@lang('messages.Enter Project Story Description')"
                                              required rows="3">{{old('description')}}</textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.Close')</button>
                    {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {{--Edit modal--}}
    <div class="modal fade" id="EditLanModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"> &times; </span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Add Project Story Details in
                        Language</h4>
                </div>
                {{ Form::open( array('url' => '', 'files'=>true, 'method'=>'PATCH', 'id' => 'language-edit-form'))}}

                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" value="{{$sr_project_story->id}}" name="sr_project_story_id">
                                    <label for="lang">@lang("messages.Language")<span
                                                class="la-required"> * </span>:</label>

                                    <select class="form-control select2" rel="select2" required="1" name="lng"
                                            id="current-lang-option" disabled>
                                        <?php echo $languageOptionsWithEnglish;?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">@lang('messages.Project Story Title') <span
                                                class="la-required">*</span></label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 80-100 for better looking
                                         </span>
                                    <input type="text" class="form-control "
                                           name="title" placeholder="@lang('messages.Enter Project Story Title')"
                                           id="current-story-title" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">@lang('messages.Project Story Description') <span
                                                class="la-required">*</span></label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 180-200 for better looking
                                         </span>
                                    <textarea type="text" class="form-control up_title"
                                              name="description"
                                              placeholder="@lang('messages.Enter Project Story Description')"
                                              id="current-story-description"
                                              required rows="3"></textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.Close')</button>
                    {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- modal end -->

@endsection
@push('styles')
{{--<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>--}}
<link href="{{ asset('la-assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('scripts')
{{--<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>--}}
<script type="text/javascript">
    $(document).ready(function () {
        @if(session()->has('message'))
            location.reload(true);
        @endif

    });

    //selected value
    var project_id = "<?php echo $sr_project_story->sr_project_id; ?>";
    var media = "<?php echo !empty($sr_project_story->video_link) ? 2 : 1; ?>";
    var no_of_images = "<?php echo $sr_project_story->no_of_image; ?>";

    if (project_id !== '' && project_id !== 'NULL') {
        $('[name=sr_project_id]').val(project_id);
    }
    if (media !== '' && media !== 'NULL') {
        $('[name=media_type]').val(media);
    }
    if (no_of_images !== '' && no_of_images !== 'NULL') {
        $('[name=no_of_image]').val(no_of_images);
    }

    function getStoryTraslationValue(id) {
        $.ajax({
            url: "{{url('admin/get-project-story-translation')}}",
            type: 'POST',
            dataType: 'json',
            data: {
                id: id
            },
            success: function (response) {
                // console.log(response.locale);
                $('#current-story-title').val(response.title);
                $('#current-story-description').val(response.description);
                $('#current-lang-option').val(response.locale).trigger('change.select2');
                $('#language-edit-form').attr('action', "{{url('admin/sr_project_story_translation')}}" + '/' + id);
            }
        });
    }


    $(function () {
        $("#project-edit-form").validate({});
        $("#project-lan-form").validate({});

    });

</script>
@endpush
