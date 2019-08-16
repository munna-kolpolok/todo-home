@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/sr_projects') }}">@lang('messages.Project Story')</a> :
@endsection
@section("section", trans("messages.Project Story"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sr_projects'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Add Project Story"))

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
        {!! Form::open(['action' => 'Admin\Save_Refugee\ProjectsStoryController@store','files'=>true, 'id' => 'projects-add-form']) !!}
        <div class="box-body">
            <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sr_project_id">@lang('messages.Project') <span
                                        class="la-required">*</span></label>
                            <select class="form-control" rel="select2" required="1" name="sr_project_id"
                                    id="sr_project_id">
                                <?php echo $projectOptions;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="media_type">@lang('messages.Media Type') <span
                                        class="la-required">*</span></label>
                            <select class="form-control" name="media_type" id="media_type" required>
                                <option selected value="1">Image</option>
                                <option value="2">Video</option>
                            </select>
                        </div>
                    </div>
                    <div id="added-media">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="no_of_image">@lang('messages.Number Of Image') <span
                                            class="la-required">*</span></label>
                                <select class="form-control" name="no_of_image" id="no_of_image"
                                        onchange="addedNoOfUpload()" required>
                                    <option selected value="1">1</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="added-dynamic-image">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="images">Select Image <span class="la-required">*</span></label>
                                <input type="file" class="form-control" name="images[]" id="images" required>
                                <span class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size: 540X370px</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <h4 style="background-color: lightgray; text-align: center; padding: 5px;">Project Stories Details in
                    English</h4>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title">@lang('messages.Project Story Title') <span
                                    class="la-required">*</span></label><span class="suggestion_text"><i
                                    class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 80-100 for better looking
                                         </span>
                        <input type="text" class="form-control "
                               name="title" placeholder="@lang('messages.Enter Project Story Title in English')"
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
                                  placeholder="@lang('messages.Enter Project Story Description in English')"
                                  required rows="3">{{old('description')}}</textarea>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group" style="text-align: center">
                    {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                    <a class="btn btn-default"
                       href="{{ url(config('laraadmin.adminRoute') .'/sr_projects') }}">@lang('messages.Cancel')</a>
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
    $('#media_type').on('change', function (e) {
        var media_content = $('#added-media');
        const added_dynamic_image = $('#added-dynamic-image');
        const media_value = e.target.value;
        var html = '';
        if (media_value == 1) {
            html = `<div class="col-md-4">
                               <div class="form-group">
                                   <label for="no_of_image">Number Of Image<span class="la-required">*</span></label>
                                   <select class="form-control" name="no_of_image" id="no_of_image" onchange="addedNoOfUpload()" required>
                                       <option selected value="1">1</option>
                                       <option  value="3">3</option>
                                       <option  value="4">4</option>
                                   </select>
                               </div>
                           </div>
                           `;
            $(added_dynamic_image).html(createDynamicFileUploadField(1));
        } else {
            $(added_dynamic_image).empty();
            html = `<div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="image">Video Link<span class="la-required">*</span></label>
                                    <input type="url" class="form-control video_link" name="video_link" placeholder="Enter Valid Url" required>
                                    <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        Enter Valid Url
                                </span>
                                </div>
                            </div>
                        </div>`
        }
        $(media_content).empty();
        $(media_content).html(html);
    });

    function addedNoOfUpload() {
        const no_of_image = $('#no_of_image').val();
        const added_dynamic_image = $('#added-dynamic-image');
        $(added_dynamic_image).empty();
        $(added_dynamic_image).html(createDynamicFileUploadField(no_of_image));
    }

    function createDynamicFileUploadField(numberOfField) {
        var field = '';
        for (i = 0; i < numberOfField; i++) {
            field += ` <div class="col-md-4">
                                <div class="form-group">
                                    <label for="images">Select Image <span class="la-required">*</span></label>
                                    <input type="file" class="form-control" name="images[]" id="images" required>
                                    <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size: 540X370px</span>
                                </div>
                            </div>`
        }
        return field;
    }


    $("#projects-add-form").validate({});


</script>
@endpush
