@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/presses') }}">@lang('messages.Presses')</a> :
@endsection
@section("section", trans("messages.Presses"))
@section("section_url", url(config('laraadmin.adminRoute') . '/presses'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", trans("messages.Edit Presses"))

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
$categories_options = '';
foreach ($categories as $category) {
    $categories_options .= '<option value="'.$category->id.'">'.$category->name.'</option>';
}
?>
    <div class="box box-success">
        {!! Form::model($presses, ['route' => [config('laraadmin.adminRoute') . '.presses.update', $presses->id ],'method' =>'PUT','files' => true,'role'=>"form"]) !!}

        <div class="box-body">
            <div style="border: 1px solid #eeeeee; padding: 20px; margin: 10px 0;box-shadow: 0 0px 0 2px rgba(0,0,0,.2)"
                 class="press_wrapper">
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="website">@lang('messages.Website')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-group">
                                <select class="form-control websiteRow" name="website"  id="websiteRow" onchange="get_PressCat(this.id,this.value)">
                                    <option value="1" {{$presses->website==1?  "selected": ""}}>Bidyanondo</option>
                                    <option value="2" {{$presses->website==2?  "selected": ""}}>One Taka Ahar</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="parent">@lang('messages.Category')</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control press-category" name="press_category_id" id="pressRow" required>
                                <option value="{{$presses->press_category_id}}">{{$presses->press_category->name}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="published_date">@lang('messages.Published Date')</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class='input-group date' id='datetimepicker1'>
                                <input type='text' class="form-control" name="published_date"
                                       id="published_date"
                                       placeholder="@lang('messages.Enter Date')"
                                       value="@if(isset($published_date)) {{$published_date}} @else {{ App\Helpers\CommonHelper::showDateFormat(date('Y-m-d')) }} @endif"
                                       required/>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="press_link">@lang('messages.Link')<span
                                        class="la-required"></span></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="url" class="form-control press_link" name="press_link"
                                   placeholder="@lang('messages.Enter Valid Url')"
                                   value="{{$presses->press_link or null}}" required>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="is_video">@lang('messages.Video')</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="is_video" id="is_video" required>
                                <option @if($presses->is_video ==1) selected @endif value="1">Yes</option>
                                <option @if($presses->is_video ==0) selected @endif value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="image">@lang('messages.Press Image')</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                            @if(!is_null($presses->image))
                                <img src="{{asset($presses->image)}}" alt="Image" width="50px"
                                     height="40px">
                            @else
                                <img src="{{asset('uploads/students/default/default.png')}}" alt="No Image" width="50px"
                                     height="40px">
                            @endif
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="file" class="form-control image" name="image">
                             <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:431X554px
                            </span>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="description">@lang('messages.Description')</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <textarea name="description" class="form-control description" rows="5"
                                      placeholder="Enter description" required>{{$presses->description or null}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="description">@lang('messages.Description Bangla')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <textarea name="bn_description"  class="form-control bn_description" placeholder="Enter description in Bangla"  rows="5" required>{{$presses->bn_description or null}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="press-submit-wrapper">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                        <a class="btn btn-default"
                           href="{{ url(config('laraadmin.adminRoute') .'/presses') }}">@lang('messages.Cancel')</a>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>


@endsection

@push('scripts')
<script type="text/javascript">

    function get_PressCat(row_id, val) {
        //alert(val); return;
        var site_name='';
        if(val==1){
            site_name='Bidyanondo';
        }else{
            site_name='One Taka Ahar';
        }

        $.ajax({
            type:"GET",
            url: "{{url(config('laraadmin.adminRoute').'/get_press_cat_ajax/')}}",
            data: {website: site_name},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (data) {
                var options = $.parseJSON(data);//parse JSON
                var $cat_dropdown = $("#pressRow");

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
