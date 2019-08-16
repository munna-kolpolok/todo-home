@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/sr_galleries') }}">@lang('messages.Galleries')</a> :
@endsection
@section("section", trans("messages.Project"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sr_galleries'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", trans("messages.Edit Gallery"))

@section("main-content")
    <style type="text/css">
        #save_div {
            display: none;
        }

        .suggestion_text {
            color: green;
            font-size: 12px;
        }

        label.error {
            position: absolute !important;
            top: 74px;
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
        {{ Form::open( array('url' => config('laraadmin.adminRoute').'/sr_galleries/'.$gallery->id, 'method'=>'PATCH','files'=>true, 'id' => 'project-edit-form'))}}
        <div class="box-body">
            <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="album_name">@lang('messages.Album Name') <span
                                        class="la-required">*</span></label>
                            <input type="text" class="form-control" id="album_name" name="album_name"
                                   value="{{$gallery->englishGallery->album_name}}" required>
                        </div>
                    </div>
                    @forelse($gallery->gallery_images as $image)
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
                </div>
                <div class="row" id="">
                    <div class="col-md-12">
                        <div class="form-group" style="text-align: center; padding-top: 10px;">
                            {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute') .'/sr_galleries') }}">@lang('messages.Cancel')</a>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}

                <div class="row" id="translation">
                    <h3 style="background-color: lightgray; text-align: center; padding: 5px;">Gallery Details
                        <a data-toggle="modal" data-target="#AddLanModal" class="btn btn-success btn-sm  pull-right">
                            <i class="fa fa-language" aria-hidden="true"></i>
                            @lang("messages.Add Gallery Language Content")
                        </a>
                    </h3>

                    <div class="box-body">
                        <table id="example1" class="table table-bordered">
                            <thead>
                            <tr class="success">
                                <th>Serial</th>
                                <th>Language</th>
                                <th>Album Name</th>
                                <th>Action @la_access("Sr_Galleries", "create")

                                    @endla_access
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($gallery->galleriesTranslations as $key=>$value)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$value->galleryLanguage->name or null}}</td>
                                    <td>{{$value->album_name or null}}</td>
                                    <td style="min-width: 80px!important;">
                                        @la_access("Sr_Galleries", "edit")
                                        <a data-toggle="modal" data-target="#EditLanModal"
                                           onclick="getGalleryTraslationValue({{$value->id}})"
                                           class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                                           style="display:inline;padding:2px 5px 3px 5px;"> <i class="fa fa-edit"> </i></a>
                                        @endla_access
                                        @la_access("Sr_Galleries", "delete")
                                        {{Form::open(['route' => [config('laraadmin.adminRoute') . '.sr_galleries_translation.destroy', $value->id], 'method' => 'delete', 'style'=>'display:inline'])}}
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
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Add Gallery Language Content</h4>
                </div>
                {!! Form::open(['action' => 'Admin\Save_Refugee\GalleryTranslationsController@store', 'id' => 'gallery-lan-form']) !!}

                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" value="{{$gallery->id}}" name="sr_gallery_id">
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
                                    <label for="title">@lang('messages.Album Name') <span
                                                class="la-required">*</span></label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 80-100 for better looking
                                         </span>
                                    <input type="text" class="form-control "
                                           name="album_name" placeholder="@lang('messages.Enter Album Name')"
                                           value="{{old('album_name')}}" required>
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
                                    <input type="hidden" value="{{$gallery->id}}" name="sr_gallery_id">
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
                                    <label for="title">@lang('messages.Album Name') <span
                                                class="la-required">*</span></label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 80-100 for better looking
                                         </span>
                                    <input type="text" class="form-control "
                                           name="album_name" id="current_album_name" placeholder="@lang('messages.Enter Album Name')" required>
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
    var project_id = "<?php echo $gallery->sr_project_id; ?>";
    var media = "<?php echo !empty($gallery->video_link) ? 2 : 1; ?>";
    var no_of_images = "<?php echo $gallery->no_of_image; ?>";

    if (project_id !== '' && project_id !== 'NULL') {
        $('[name=sr_project_id]').val(project_id);
    }
    if (media !== '' && media !== 'NULL') {
        $('[name=media_type]').val(media);
    }
    if (no_of_images !== '' && no_of_images !== 'NULL') {
        $('[name=no_of_image]').val(no_of_images);
    }

    function getGalleryTraslationValue(id) {
        $.ajax({
            url: "{{url('admin/get-gallery-translation')}}",
            type: 'POST',
            dataType: 'json',
            data: {
                id: id
            },
            success: function (response) {
                $('#current_album_name').val(response.album_name);
                $('#current-lang-option').val(response.locale).trigger('change.select2');
                $('#language-edit-form').attr('action', "{{url('admin/sr_galleries_translation')}}" + '/' + id);
            }
        });
    }


    $(function () {
        $("#project-edit-form").validate({});
        $("#gallery-lan-form").validate({});

    });

</script>
@endpush
