@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/sr_project_sliders') }}">@lang('messages.Project Sliders')</a> :
@endsection
@section("section", trans("messages.Project Sliders"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sr_project_sliders'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Add Project Sliders"))

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
        {!! Form::open(['action' => 'Admin\Save_Refugee\ProjectSlidersController@store','files'=>true, 'id' => 'projects-add-form']) !!}
        <div class="box-body">
            <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="sr_project_id">Select Project <span
                                        class="la-required"> *</span></label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="sr_project_id" id="sr_project_id" required rel="select2">
                                @foreach($projects as $project)
                                    <option value="{{$project->id}}">{{$project->translation->name or null}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" style="text-align: center;">

                            <div id="drop_zone" class="drop-zone">

                                <p class="title">Drop Slider Image here</p>

                                <div class="preview-container"></div>
                                 <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png Size: 350X208px
                                        </span>
                            </div>
                            <input id="file_input" {{--accept="image/*"--}} type="file" required multiple=""
                                   name="image[]">
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" style="text-align: center">
                        {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                        <a class="btn btn-default"
                           href="{{ url(config('laraadmin.adminRoute') .'/sr_project_sliders') }}">@lang('messages.Cancel')</a>
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

@push('styles')
<link href="{{ asset('la-assets/css/smartuploader.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script type="text/javascript" src="{{ asset('la-assets/plugins/smartuploader/jquery.smartuploader.js') }}"></script>
<script type="text/javascript">
    $(function () {

        $("#projects-add-form").validate({});
        $(".nav-tabs a").click(function () {
            $(this).tab('show');
        });

    });

    /*Multiple img upload*/
    var result = $("#file_input").withDropZone("#drop_zone", {

        action: function (fileIndex) {
            // you can change your file
            // for example:
            var convertTo;
            var extension;
            if (this.files[fileIndex].type === "image/png") {
                convertTo = {
                    mimeType: "image/jpeg",
                    maxWidth: 150,
                    maxHeight: 150,
                };
                extension = ".jpg";
            }
            else {
                convertTo = null;
                extension = null;
            }

            return {
                name: "image",
                rename: function (filenameWithoutExt, ext, fileIndex) {
                    return filenameWithoutExt + (extension || ext)
                },
                params: {
                    preview: true,
                    convertTo: convertTo,
                }
            }
        },
        ifWrongFile: "show",
        wrapperForInvalidFile: function (fileIndex) {
            return `<
            div
            style = "margin: 20px 0; color: red;" > File
            :
            "${this.files[fileIndex].name}"
            doesn
            't support</div>`
        },
    });

    /*Multiple img upload*/

</script>
@endpush
