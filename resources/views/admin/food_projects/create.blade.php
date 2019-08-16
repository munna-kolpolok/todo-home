@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/food_projects') }}">@lang('messages.Food Projects')</a> :
@endsection
@section("section", trans("messages.Food Projects"))
@section("section_url", url(config('laraadmin.adminRoute') . '/food_projects'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Add Food Projects"))

@section("main-content")
    <?php
    $json_arr=Array();
    foreach ($food_items as $item) {
        $json_arr[$item->id]=$item->name;
    }
    $json_data=json_encode($json_arr);
    //echo $json_data; die;
    ?>
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
        {!! Form::open(['action' => 'Admin\Foods_ProjectsController@store','files'=>true, 'id' => 'foodProject-add-form']) !!}
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
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Project Name" value="{{old('name')}}" required>
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
                                    <input type="text" name="bn_name" class="form-control" id="bn_name" placeholder="Enter Project Name Bangla" value="{{old('bn_name')}}" required>
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
                                    <textarea type="text" class="form-control" name="description" id="description" placeholder="Enter Description"  required>{{old('description')}}</textarea>
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
                                    <textarea type="text" class="form-control" name="bn_description" id="bn_description" placeholder="Enter Description Bangla"  required>{{old('bn_description')}}</textarea>
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
                                    <input type="number" class="form-control" name="min_no_unit" id="min_no_unit" placeholder="Enter Min Number Of Unit" value="{{old('min_no_unit')}}" required>
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
                                <input type="file" class="form-control image" name="image" required>
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
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
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
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
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
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sector_add">Add to sector</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control" name="sector_add" id="sector_add">
                                    <option value="2">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="food_menu">@lang('messages.Food Menu')<span
                                            class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control" name="food_menu" id="food_menu">
                                    <option value="1">Regular food item</option>
                                    <option value="0">Custom food item </option>
                                </select>
                            </div>
                        </div>

                        <div id="food_items_row" style="display: none;">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="food_item_id">@lang('messages.Food Items') <span
                                                class="la-required">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control food_item_ids" name="food_item_ids[]" id="food_item_ids[]" data-placeholder="Select Foods Item" title="Select food item" rel="select2" data-live-search="true" multiple required>
                                        <option value=""></option>
                                        @foreach($food_items as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row" id="press-submit-wrapper">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" id="total_row" value="1">
                            {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
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

        $("#foodProject-add-form").validate({});
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
