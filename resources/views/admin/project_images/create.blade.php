@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/galleries') }}">@lang('messages.Project Images')</a> :
@endsection
@section("section", trans("messages.Project Images"))
@section("section_url", url(config('laraadmin.adminRoute') . '/project_images'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Add Project Images"))
<?php

$projects_options = '';
$json_arr = Array();
foreach ($projects as $project) {
    $projects_options .= '<option value="' . $project->id . '">' . $project->name . '</option>';
    $json_arr[$project->id] = $project->name;
}
$json_data = json_encode($json_arr);

?>
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
        {!! Form::open(['action' => 'Admin\ProjectImagesController@store','files'=>true, 'id' => 'images-add-form']) !!}
        <div class="box-body">
            <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="gallery_wrapper">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for=" gallery-category">@lang('messages.Projects')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control gallery-category CatRow" name="project_id"
                                    id="CatRow_1" required>
                                <?php echo $projects_options;?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="image">@lang('messages.Project Images')<span class="la-required">*</span></label>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="file" class="form-control image" name="images[]" id="gallery-photo-add"
                                   multiple required>
                            <span class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg. Size:800X550px
                               </span>
                        </div>
                    </div>
                </div>
                <div class="row row-centered">
                    <div class="col-md-10 col-centered">
                        <div id="image-preview"></div>
                    </div>
                </div>
            </div>
            <div class="row" id="video-submit-wrapper">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="hidden" id="total_row" value="1">
                        {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                        <a class="btn btn-default"
                           href="{{ url(config('laraadmin.adminRoute') .'/project_images') }}">@lang('messages.Cancel')</a>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>


@endsection

@push('styles')
<style>
    .row-centered {
        text-align: center;
    }

    .col-centered {
        display: inline-grid;
        float: none;
        /* reset the text-align */
        text-align: left;
        /* inline-block space fix */
        margin-right: -4px;
        text-align: center;
        padding: 0;
    }

    .single-image {
        width: 120px;
        height: 100px;
        display: inline;
        padding: 10px;
    }
</style>
@endpush


@push('scripts')
<script type="text/javascript">
    /*Multiple image brows after show*/
    $(function () {
        //validation added
        $("#images-add-form").validate();

        var imagesPreview = function (input, placeToInsertImagePreview) {
            if (input.files) {
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $($.parseHTML('<img class="single-image">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    };
                    reader.readAsDataURL(input.files[i]);
                }
            }

        };

        $('#gallery-photo-add').on('change', function () {
            imagesPreview(this, 'div#image-preview');
        });
    });



</script>
@endpush
