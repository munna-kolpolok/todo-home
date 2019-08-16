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

    <div class="box box-success">
        {!! Form::model($presses, ['route' => [config('laraadmin.adminRoute') . '.presses.update', $presses->id ],'method' =>'PUT','files' => true,'role'=>"form"]) !!}

        <div class="box-body">
            <div style="border: 1px solid #eeeeee; padding: 20px; margin: 10px 0;box-shadow: 0 0px 0 2px rgba(0,0,0,.2)"
                 class="press_wrapper">
                <div class="row">
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
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="parent">@lang('messages.Category')</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control press-category" name="press_category_id" required>
                                <?php
                                $category_options = App\Models\Common_Model::common_dropdown('press_categories', 'id', 'name', $presses->press_category_id, 'Category');
                                echo $category_options;
                                ?>
                            </select>
                        </div>
                    </div>

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
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="is_video">@lang('messages.Is Video')</label>
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="file" class="form-control image" name="image">
                             <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:431X554px
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            @if(!is_null($presses->image))
                                <img src="{{asset($presses->image)}}" alt="Image" width="80px"
                                     height="70px">
                            @else
                                <img src="{{asset('uploads/students/default/default.png')}}" alt="No Image" width="50px"
                                     height="40px">
                            @endif
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="description">@lang('messages.Description')</label>
                        </div>
                    </div>
                    <div class="col-md-11">
                        <div class="form-group">
                            <textarea name="description" class="form-control description"
                                      placeholder="Enter description" required>{{$presses->description or null}}</textarea>
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

@endpush
