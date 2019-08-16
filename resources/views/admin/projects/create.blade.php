@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/projects') }}">@lang('messages.Projects')</a> :
@endsection
@section("section", trans("messages.Projects"))
@section("section_url", url(config('laraadmin.adminRoute') . '/projects'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Add Projects"))
<?php
$start_date = old('dob');
?>
@section("main-content")
    <style type="text/css">
        #save_div {
            display: none;
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
        <div class="box-body">
            {!! Form::open(['action' => 'Admin\ProjectController@store','files'=>true, 'id' => 'student-add-form']) !!}
            <input type="hidden" name="is_project" value="1">
            <div id="payment-tab">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item active">
                        <a class="nav-link" data-toggle="tab" href="#english">English</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#bangla">Bangla</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    {{--English Content--}}
                    <div id="english" class="tab-pane active"><br>
                        <div id="home-tab-wrapper" style="padding: 25px 0 25px 0">
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="is_menu">@lang('messages.Is Menu')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="is_menu" id="is_menu">
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="parent">@lang('messages.Parent')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="parent" id="parent" rel="select2" >
                                            <option value="">Select project parent</option>
                                            @foreach ($projects as $project)
                                                <option value="{{$project->id}}">{{$project->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="project_type_id">@lang('messages.Project type')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="project_type_id" id="project_type_id"  rel="select2" >
                                            <option value="">Select project type</option>
                                            @foreach ($project_types as $project_type)
                                                <option value="{{$project_type->id}}">{{$project_type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="name">@lang('messages.Name')<span
                                                    class="la-required">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" required="1" name="name" id="name"
                                               placeholder="@lang('messages.Enter Name')" value="{{old('name')}}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="project_start_date">@lang('messages.Project Start Date')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' class="form-control" name="project_start_date" id="project_start_date"
                                                   placeholder="@lang('messages.Enter Date')"
                                                   value="@if(isset($start_date)) {{$start_date}} @else {{ App\Helpers\CommonHelper::showDateFormat(date('Y-m-d')) }} @endif"/>
                                            <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="location">@lang('messages.Location')<span
                                                    class="la-required"></span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="location" id="location"
                                               placeholder="@lang('messages.Enter location')"
                                               value="{{old('location')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="is_urgent">@lang('messages.Is Urgent')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="is_urgent" id="is_urgent">
                                            <option value="1">Yes</option>
                                            <option selected value="2">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="is_home">@lang('messages.Is Home')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="is_home" id="is_home">
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="is_show">@lang('messages.Is Show')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="is_show" id="is_show">
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="supervisor_name">@lang('messages.Supervisor name')</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <textarea type="text" class="form-control" name="supervisor_name" id="supervisor_name"
                                               placeholder="@lang('messages.Enter Supervisor name')">{{old('supervisor_name')}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="supervisor_contact_no">@lang('messages.Supervisor contact no')</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <textarea type="tex" class="form-control" name="supervisor_contact_no" id="supervisor_contact_no"
                                               placeholder="@lang('messages.Enter supervisor contact no')"> {{old('supervisor_contact_no')}}</textarea>
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
                        <textarea name="description" class="form-control" placeholder="Enter description"
                                  id="description">{{old('description')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="donation_title">@lang('messages.Donation Title')</label>
                                    </div>
                                </div>
                                <div class="col-md-11">
                                    <div class="form-group">
                        <textarea name="donation_title" class="form-control" placeholder="Enter donation title"
                                  id="donation_title">{{old('donation_title')}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="video_link">@lang('messages.Project video link')</label>
                                    </div>
                                </div>
                                <div class="col-md-11">
                                    <div class="form-group">
                        <input type="text" name="video_link" class="form-control" placeholder="Enter Project video link"
                                  id="video_link">{{old('video_link')}}
                                    </div>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="sector_add">Add to sector</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="sector_add" id="sector_add">
                                            <option value="2">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="project_image">@lang('messages.Project Image')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="file" id="project_image" name="project_image">
                                        <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg. Size: 600X442px
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="project_big_image">@lang('messages.Project Poster Image')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="file" id="project_big_image" name="project_big_image">
                                        <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg. Size: 450X500px
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                </div>
                            </div>
                        </div>

                    </div>
                    {{--Bangle Content--}}
                    <div id="bangla" class="tab-pane fade"><br>
                        <div id="home-tab-wrapper" style="padding: 25px 0 25px 0">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="bn_name">@lang('messages.Bangla Name')</label><span class="la-required"> *</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="bn_name" id="bn_name"
                                               placeholder="@lang('messages.Enter Bangla Name')"
                                               value="{{old('bn_name')}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="bn_location">@lang('messages.Location(Bangla)')<span
                                                    class="la-required"></span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="bn_location"
                                               id="bn_location"
                                               placeholder="@lang('messages.Enter Bangla location')"
                                               value="{{old('bn_location')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="bn_objective">@lang('messages.Objective Bangla')</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="bn_objective" id="bn_objective"
                                               placeholder="@lang('messages.Enter Objective Bangla')"
                                               value="{{old('bn_objective')}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="bn_achievement">@lang('messages.Achievement Bangla')<span
                                                    class="la-required"></span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="bn_achievement"
                                               id="bn_achievement"
                                               placeholder="@lang('messages.Enter Achievement Bangla')"
                                               value="{{old('bn_achievement')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="bn_description">@lang('messages.Description(Bangla)')</label>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                        <textarea name="bn_description" class="form-control" placeholder="Enter Bangla description"
                                  id="bn_description">{{old('bn_description')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="bn_donation_title">@lang('messages.Donation Title(Bangla)')</label>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                        <textarea name="bn_donation_title" class="form-control" placeholder="Enter Bangla donation title"
                                  id="bn_donation_title">{{old('bn_donation_title')}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute') .'/projects') }}">@lang('messages.Cancel')</a>
                        </div>
                    </div>
                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(function () {
        $("#student-add-form").validate({});
        $(".nav-tabs a").click(function () {
            $(this).tab('show');
        });

    });


</script>
@endpush
