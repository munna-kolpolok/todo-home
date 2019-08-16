@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/presses') }}">@lang('messages.Campaigns')</a> :
@endsection
@section("section", trans("messages.Campaigns"))
@section("section_url", url(config('laraadmin.adminRoute') . '/campaigns'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Add Campaign"))

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
        {!! Form::open(['action' => 'Admin\CampaignController@store','files'=>true, 'id' => 'campaign-add-form']) !!}
        <div class="box-body">
            <div style="border: 1px solid #eeeeee; padding: 20px; margin: 10px 0;box-shadow: 0 0px 0 2px rgba(0,0,0,.2)"
                 class="press_wrapper">
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="website_id">@lang('messages.Website')<span class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="website_id" id="website_id" required>
                                @foreach($websites as $website)
                                    <option value="{{$website->id}}">{{$website->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="date">@lang('messages.Campaign Date')</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class='input-group date' id='datetimepicker1'>
                                <input type='text' class="form-control" name="date"
                                       id="published_date"
                                       placeholder="@lang('messages.Enter Date')"
                                       value="{{ App\Helpers\CommonHelper::showDateFormat(date('Y-m-d')) }}"/>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="title">@lang('messages.Title')<span class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control" id="title" placeholder="Enter title" name="title"
                                   required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="bn_title">@lang('messages.Title(Bangla)')</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control" name="bn_title"
                                   placeholder="@lang('messages.Enter bangla title')">
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="is_home">@lang('messages.Is Home')<span class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="is_home" id="is_home" required>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="is_show">@lang('messages.Is Show')<span class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="is_show" id="is_show" required>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
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
                            <textarea name="description" class="form-control "
                                      placeholder="Enter description in English" rows="5">{{old('description')}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="description">@lang('messages.Description Bangla')</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <textarea name="bn_description" class="form-control"
                                      placeholder="Enter description in Bangla" rows="5">{{old('bn_description')}}</textarea>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="cover_image">@lang('messages.Cover Image')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <input type="file" class="form-control" name="cover_image" required>
                            <span class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg. Size:480X538px
                                </span>
                        </div>
                    </div>
                </div>
                <div class="row" id="press-submit-wrapper">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" id="total_row" value="1">
                            {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute') .'/campaigns') }}">@lang('messages.Cancel')</a>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>


@endsection

@push('scripts')
<script type="text/javascript">
$('#campaign-add-form').validate();

</script>
@endpush
