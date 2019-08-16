@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/galleries') }}">@lang('messages.Gallery')</a> :
@endsection
@section("section", trans("messages.Gallery"))
@section("section_url", url(config('laraadmin.adminRoute') . '/galleries'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Add Gallery"))
<?php

$categories_options = '';
$json_arr = Array();
foreach ($categories as $category) {
    $categories_options .= '<option value="' . $category->id . '">' . $category->name . '</option>';
    $json_arr[$category->id] = $category->name;
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
        {!! Form::open(['action' => 'Admin\GalleryController@store','files'=>true, 'id' => 'video-add-form']) !!}
        <div class="box-body">
            <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="gallery_wrapper">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for=" gallery-category">@lang('messages.Category')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control gallery-category CatRow" name="gallery_category_id"
                                    id="CatRow_1" required>
                                <?php echo $categories_options;?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="image">@lang('messages.Gallery Image')<span class="la-required">*</span></label>

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
                           href="{{ url(config('laraadmin.adminRoute') .'/galleries') }}">@lang('messages.Cancel')</a>
                        {{--<button class="btn btn-info pull-right" id="add-row">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            Add row
                        </button>--}}
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

    $(function () {
        /*Add new row*/
        var row_count = $('#total_row').val();
        $('#add-row').on('click', function (e) {
            row_count++;
            $('.gallery_wrapper:first').clone().insertBefore('#video-submit-wrapper');
            $("<a style='margin-top: 8px' class='btn btn-danger btn-sm pull-right remove' onclick='removeRow(this)'>Remove</a>").insertAfter(".image:last");
            $('.image:last').val('');

            e.preventDefault();

            $('.websiteRow:last').attr("id", "websiteRow_" + row_count);
            $('.CatRow:last').attr("id", "CatRow_" + row_count);

            var catOptions = JSON.parse('<?php echo $json_data;?>');
            var $el = $("#CatRow_" + row_count);
            $el.empty(); // remove old options
            $.each(catOptions, function (key, value) {
                $el.append($("<option></option>")
                    .attr("value", key).text(value));
            });
        });


        $("#video-add-form").validate({});
        $(".nav-tabs a").click(function () {
            $(this).tab('show');
        });

    });

    function removeRow(current) {
        current.parentElement.parentElement.parentElement.parentElement.remove();
    }


</script>
@endpush
