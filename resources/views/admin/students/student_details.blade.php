@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/students') }}">@lang('messages.Student Info Details')</a>
@endsection
@section("contentheader_description")
@section("section", trans("messages.Student Info Details"))
@section("section_url", url(config('laraadmin.adminRoute') . '/students'))
@section("sub_section", trans("messages.Donate"))

@section("htmlheader_title", "Student Info Details")

@section("main-content")
<style>
    .suggestion_text{
        color:green;
        font-size: 12px;
    }
</style>
    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{ session()->get('message') }}</strong>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="box box-success">

        @if(empty($student_Details_single))
            {{ Form::open(array('url' => 'admin/students/details-store', 'id' => 'donation-form', 'files'=> true)) }}
        @else
            {{ Form::open(array('url' => 'admin/students/details-update','id' => 'donation-form', 'files'=> true)) }}
        @endif
        <div class="box-body">
            <div class="col-md-12">
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                @if(!empty($student_Details_single))
                    <input type="hidden" name="student_detail_id" value="{{ $student_Details_single->id }}">
                @endif
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="topic">@lang('messages.Topic') <span class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <input class="form-control" type="text" name="topic" id="topic"
                                   placeholder="@lang('messages.Enter Topic')"
                                   value="{{$student_Details_single->topic or null}}" required>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="bn_topic">@lang('messages.Topic(Bn)')</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <input class="form-control" type="text" name="bn_topic" id="bn_topic"
                                   placeholder="@lang('messages.Enter Bangla Topic')"
                                   value="{{$student_Details_single->bn_topic or null}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="description">@lang('messages.Desc')</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <textarea class="form-control" name="description" id="description"
                                      placeholder="@lang('messages.Enter Description')">{{$student_Details_single->description or null}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="bn_description">@lang('messages.Desc Bn')</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <textarea class="form-control" name="bn_description" id="bn_description"
                                      placeholder="@lang('messages.Enter Bangla Description')">{{$student_Details_single->bn_description or null}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="dob">@lang('messages.Date')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class='input-group date' id='datetimepicker1'>
                                <input type='text' class="form-control" name="date" id="date"
                                       placeholder="@lang('messages.Enter Date')" required="1"
                                       value="@if(isset($date)) {{$date}} @else {{ App\Helpers\CommonHelper::showDateFormat(date('Y-m-d')) }} @endif"/>
                                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @if(!empty($student_Details_single))
                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="attachment"></label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            @if(!is_null($student_Details_single->attachment))
                                <img src="{{asset($student_Details_single->attachment)}}" alt="{{$student->name}}" class="img-responsive">
                            @else
                                <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" class="img-responsive">
                            @endif
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="attachment">@lang('messages.Student Attachment')</label>
                        </div>
                    </div>
                    <div class="col-md-11">
                        <div class="form-group">
                            <input type="file" class="form-control" id="attachment" name="attachment">
                            <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Maximum file size 2MB.
                            </span>
                        </div>
                    </div>
                </div>


                <div style="text-align: center;">
                    @la_access("students", "edit")
                    <a href="#" class="btn btn-success" onclick="save()">@lang('messages.Save')</a>
                    @endla_access
                    <a href="{{ url(config('laraadmin.adminRoute') . '/students') }}"
                       class="btn btn-default">@lang('messages.Cancel')</a>
                </div>
                {!! Form::close() !!}
            </div>

        </div>


    </div>

    <div class="box box-success">
        <div class="box-body">
            <table id="example1" class="table table-bordered">
                <thead>
                <tr class="success">
                    <th>@lang('messages.Serial No.')</th>
                    <th>@lang('messages.Topic')</th>
                    <th>@lang('messages.Topic(Bn)')</th>

                    <th>@lang('messages.Desc')</th>
                    <th>@lang('messages.Desc Bn')</th>

                    <th>@lang('messages.Attachment')</th>
                    <th>@lang('messages.Actions')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($student_details as $key=>$student_detail)
                    <tr>
                        <td>{{ ++$key }}</td>

                        <td>{{ $student_detail->topic or null}}</td>

                        <td>{{ $student_detail->bn_topic or null}}</td>
                        <td>{{ $student_detail->description or null}}</td>
                        <td>{{ $student_detail->bn_description or null}}</td>
                        <td>
                            @if(!is_null($student_detail->attachment))
                                <img src="{{asset($student_detail->attachment)}}" alt="{{$student->name}}" width="40px" height="40px">
                            @else
                                <img src="{{asset('uploads/students/default/default.png')}}" alt="No Image" width="40px" height="40px">
                            @endif
                        </td>
                        <td>
                            @la_access("students", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/students/details/'.$student->id.'/'.$student_detail->id)}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
                            @endla_access
                            @la_access("students", "delete")
                            {{Form::open(['url' => [config('laraadmin.adminRoute') . '/students/details/destroy/'.$student->id.'/'.$student_detail->id], 'method' => 'delete', 'style'=>'display:inline'])}}
                            <button class="btn btn-danger btn-xs" type="submit"  data-toggle="tooltip" title="Delete"
                                    onclick="return confirm('Are you sure to delete this entry?')"><i
                                        class="fa fa-times" title="Delete"></i></button>
                            {{Form::close()}}
                            @endla_access
                        </td>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">
    $(function () {
        $("#donation-form").validate({});
    });
    function save() {
        //alert('ok');
        $("#donation-form").submit();
    }

</script>
@endpush
