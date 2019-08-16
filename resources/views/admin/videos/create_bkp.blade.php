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
foreach ($categories as $category) {
    $categories_options .= '<option value="'.$category->id.'">'.$category->name.'</option>';
}


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

                         <div class="col-md-1">
                            <div class="form-group">
                                <label for="parent">@lang('messages.Video Category')<span
                                                    class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control press-category" name="video_category_id[]" required="">
                                   <!--  <option value="">Select Category</option> -->
                                    <?php echo $categories_options;?>
                                </select>
                            </div>
                        </div>

                         <div class="col-md-1">
                           <div class="form-group">
                               <label for="image">@lang('messages.Video Image')<span class="la-required">*</span></label>
                              
                           </div>
                       </div>
                       <div class="col-md-3">
                           <div class="form-group">
                               <input type="file" class="form-control image" name="image[]" required>
                                <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:348X235px
                                </span>
                           </div>
                       </div>
                       

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="video_link">@lang('messages.Video Link')<span
                                            class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="url" class="form-control video_link" name="video_link[]"
                                       placeholder="@lang('messages.Enter Valid Url')"
                                       value="{{old('video_link')}}" required>
                            </div>
                        </div>
                    </div>
                  
                </div>
                <div class="row" id="video-submit-wrapper">
                    <div class="col-md-12">
                        <div class="form-group">
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
        $('#add-row').on('click', function (e) {
            $('.video_wrapper:first').clone().insertBefore('#video-submit-wrapper');
            $("<a style='margin-top: 8px' class='btn btn-danger btn-sm pull-right remove' onclick='removeRow(this)'>Remove</a>").insertAfter(".video_link:last");
            $('.video_link:last').val('');
            $('.image:last').val('');
          
            e.preventDefault();
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
