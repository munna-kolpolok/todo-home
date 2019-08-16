@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/sr_galleries') }}">@lang('messages.Galleries')</a> :
@endsection
@section("section", trans("messages.Project Story"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sr_galleries'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Add Gallery"))

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
        {!! Form::open(['action' => 'Admin\Save_Refugee\GalleriesController@store','files'=>true, 'id' => 'gallery-add-form']) !!}
        <div class="box-body">
            <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="">
                <h4 style="background-color: lightgray; text-align: center; padding: 5px;">Gallery in
                    English</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="album_name">@lang('messages.Album Name') <span
                                        class="la-required">*</span></label>
                            <input type="text" class="form-control" id="album_name" placeholder="Enter album name" name="album_name" value="{{old('album_name')}}" required>
                        </div>
                    </div>
                    {{--<div id="added-media">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="no_of_image">@lang('messages.Number Of Image') <span
                                            class="la-required">*</span></label>
                                <select class="form-control" name="no_of_image" id="no_of_image"
                                        onload="addedNoOfUpload()" required>
                                    <option selected value="1">1</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>
                    </div>--}}
                    <div id="added-dynamic-image">
                        {{--<div class="col-md-4">
                            <div class="form-group">
                                <label for="images">Select Image <span class="la-required">*</span></label>
                                <input type="file" class="form-control" name="images[]" id="images" required>
                                <span class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size: 320X240px</span>
                            </div>
                        </div>--}}
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group" style="text-align: center">
                    {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                    <a class="btn btn-default"
                       href="{{ url(config('laraadmin.adminRoute') .'/sr_galleries') }}">@lang('messages.Cancel')</a>
                    <!-- <button class="btn btn-info pull-right" id="add-row">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Add row
                    </button> -->
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}

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

    //added 9 Fitle Input field;
    addedNoOfUpload();

    function addedNoOfUpload() {
        //const no_of_image = $('#no_of_image').val();
        const no_of_image = 9;
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


    $("#gallery-add-form").validate({});


</script>
@endpush
