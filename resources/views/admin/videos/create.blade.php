@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/videos') }}">@lang('messages.Videos')</a> :
@endsection
@section("section", trans("messages.Videos"))
@section("section_url", url(config('laraadmin.adminRoute') . '/videos'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Add Video"))
<?php

$categories_options = '';
$json_arr=Array();
foreach ($categories as $category) {
    $categories_options .= '<option value="'.$category->id.'">'.$category->name.'</option>';
    $json_arr[$category->id]=$category->name;
}
$json_data=json_encode($json_arr);



?>
@section("main-content")
    <style type="text/css">
        #save_div {
            display: none;
        }
        .suggestion_text{
        color:green;
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
        {!! Form::open(['action' => 'Admin\VideosController@store','files'=>true, 'id' => 'video-add-form']) !!}
            <div class="box-body">
                <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="video_wrapper">
                    <div class="row">
                        <input type="hidden" name="website" value="1">

                         <div class="col-md-2">
                            <div class="form-group">
                                <label for="parent">@lang('messages.Video Category')<span
                                                    class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control press-category videoRow" id="videoRow_1" name="video_category_id[]" required="">
                                   <!--  <option value="">Select Category</option> -->
                                    <?php echo $categories_options;?>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="video_link">@lang('messages.Video Link')<span
                                            class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="url" class="form-control video_link" name="video_link[]"
                                       placeholder="@lang('messages.Enter Valid Url')" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="image">@lang('messages.Video Image')<span class="la-required">*</span></label>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="file" class="form-control image" name="image[]" required>
                                <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:348X235px
                                </span>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="row" id="video-submit-wrapper">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" id="total_row" value="1">
                            {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute') .'/videos') }}">@lang('messages.Cancel')</a>
                            <button class="btn btn-info pull-right" id="add-row">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add row
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>


@endsection

@push('scripts')
<script type="text/javascript">
    $(function () {
        /*Add new row*/
        var row_count=$('#total_row').val();
        $('#add-row').on('click', function (e) {
            row_count++;
            $('.video_wrapper:first').clone().insertBefore('#video-submit-wrapper');
            $("<a style='margin-top: 8px' class='btn btn-danger btn-sm pull-right remove' onclick='removeRow(this)'>Remove</a>").insertAfter(".video_link:last");
            $('.video_link:last').val('');
            $('.image:last').val('');

            $('#total_row').val(row_count);
            $('.websiteRow:last').attr("id","websiteRow_"+row_count);
            $('.videoRow:last').attr("id","videoRow_"+row_count);

            var catOptions=JSON.parse('<?php echo $json_data;?>');
            var $el = $("#videoRow_"+row_count);
            $el.empty(); // remove old options
            $.each(catOptions, function(key,value) {
                $el.append($("<option></option>")
                        .attr("value", key).text(value));
            });

            e.preventDefault();
            //alert(row_count);
        });



        $("#video-add-form").validate({});
        $(".nav-tabs a").click(function () {
            $(this).tab('show');
        });

    });

    function removeRow(current) {
        current.parentElement.parentElement.parentElement.parentElement.remove();
    }
    function get_Cat(row_id, val) {
        //alert(val); return;
        var site_name='';
        if(val==1){
            site_name='Bidyanondo';
        }else{
            site_name='One Taka Ahar';
        }
        var row_id=row_id.split('_');
        var currnt_row_no=row_id[1];
        $.ajax({
            type:"GET",
            url: "{{url(config('laraadmin.adminRoute').'/get_video_cat_ajax/')}}",
            data: {website: site_name},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (data) {
               // alert(data); return;
                var options = $.parseJSON(data);//parse JSON
                var $cat_dropdown = $("#videoRow_"+currnt_row_no);

                //alert(data); return;
                $cat_dropdown.empty(); // remove old options
                $.each(options, function(key,value) {
                    $cat_dropdown.append($("<option></option>") .attr("value", key).text(value));
                });


            }
        });

    }

</script>
@endpush
