@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/food_projects') }}">@lang('messages.Food Projects')</a> :
@endsection
@section("section", trans("messages.Food Projects"))
@section("section_url", url(config('laraadmin.adminRoute') . '/food_projects'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", trans("messages.Edit Food Projects"))

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
    <?php
    $json_arr=Array();
    foreach ($food_items as $item) {
        $json_arr[$item->id]=$item->name;
    }
    $json_data=json_encode($json_arr);
    ?>

    <div class="box box-success">
        {!! Form::model($food_projects, ['route' => [config('laraadmin.adminRoute') . '.food_projects.update', $food_projects->id ],'method' =>'PUT','files' => true,'role'=>"form", 'id' => 'foodProject-edit-form']) !!}

        <div class="box-body">
            <div style="border: 1px solid #eeeeee; padding: 20px; margin: 10px 0;box-shadow: 0 0px 0 2px rgba(0,0,0,.2)" class="press_wrapper">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="name">@lang('messages.Project Name')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Project Name"
                                       value="{{$food_projects->name}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="parent">@lang('messages.Project Name BN')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-group">
                                <input type="text" name="bn_name" class="form-control" id="bn_name" placeholder="Enter Project Name Bangla" value="{{$food_projects->bn_name}}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="description">@lang('messages.Description')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-group">
                                <textarea type="text" class="form-control" name="description" id="description" placeholder="Enter Description"  required>{{$food_projects->description}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="bn_description">@lang('messages.Description BN')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-group">
                                <textarea type="text" class="form-control" name="bn_description" id="bn_description" placeholder="Enter Description Bangla"  required>{{$food_projects->bn_description}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="min_no_unit">@lang('messages.Number Of Unit')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-group">
                                <input type="number" class="form-control" name="min_no_unit" id="min_no_unit" placeholder="Enter Min Number Of Unit" value="{{$food_projects->min_no_unit}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="image">@lang('messages.Image')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="file" class="form-control image" name="image">
                            @if(!is_null($food_projects->image))
                                <img src="{{asset($food_projects->image)}}" alt="Image" width="50px"
                                     height="40px">
                            @else
                                <img src="{{asset('uploads/students/default/default.png')}}" alt="No Image" width="50px"
                                     height="40px">
                            @endif
                                <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:310X200px
                                </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="is_home">@lang('messages.Home')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="is_home" id="is_home">
                                <option @if($food_projects->is_home ==1) selected @endif value="1">Yes</option>
                                <option @if($food_projects->is_home ==0) selected @endif value="0">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="is_menu">@lang('messages.Menu')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="is_menu" id="is_menu">
                                <option @if($food_projects->is_menu ==1) selected @endif value="1">Yes</option>
                                <option @if($food_projects->is_menu ==0) selected @endif value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="is_show">@lang('messages.Show') <span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="is_show" id="is_show">
                                <option @if($food_projects->is_show ==1) selected @endif value="1">Yes</option>
                                <option @if($food_projects->is_show ==0) selected @endif value="0">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="food_menu">@lang('messages.Food Menu')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control " name="food_menu" id="food_menu">
                                <option @if($food_projects->food_menu ==1) selected @endif value="1">Regular food item</option>
                                <option @if($food_projects->food_menu==0) selected @endif value="0">Custom food item</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" id="food_items_row" style="@if($food_projects->food_menu==1) display: none @endif ">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="food_item_id">@lang('messages.Food Items') <span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-10">

                        <div class="form-group">
                            <select class="form-control food_item_ids" name="food_item_ids[]" id="food_item_ids[]" data-placeholder="Select Foods" title="Select food item" rel="select2" data-live-search="true" multiple required>
                                <option value=""></option>

                                @foreach($food_items as $item)
                                    <?php $selected="";$ss="";?>
                                    @foreach($selected_food_items as $item_id)
                                        @if($item_id->food_item_id==$item->id )
                                                <?php $selected=" selected"; $ss=$item_id->food_item_id?>
                                        @endif
                                    @endforeach
                                        <option  value="{{$item->id}}" {{$selected}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row" id="press-submit-wrapper">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="hidden" id="total_row" value="1">
                        {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!}
                        <a class="btn btn-default"
                           href="{{ url(config('laraadmin.adminRoute') .'/food_projects') }}">@lang('messages.Cancel')</a>

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

        $("#foodProject-edit-form").validate({});
    });

    $('#food_menu').on('change',function(){
        var food_menu_id=$(this).val();
        if(food_menu_id==0){
            $('#food_items_row').show();
            var FoodItems=JSON.parse('<?php echo $json_data;?>');
            var $el = $(".food_item_ids");
            $el.empty(); // remove old options
            $.each(FoodItems, function(key,value) {
                $el.append($("<option></option>")
                        .attr("value", key).text(value));
            });

            $("#is_home").val(0);
            $('#is_home').prop('disabled','disabled');
        }else{
            $('.food_item_ids').empty(); // remove old options
            $('#food_items_row').hide();

            $("#is_home").val();
            $('#is_home').prop('disabled','');
        }

    })


</script>
@endpush
