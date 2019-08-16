@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/students') }}">@lang('messages.Students')</a> :
@endsection
@section("section", trans("messages.Students"))
@section("section_url", url(config('laraadmin.adminRoute') . '/students'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Add Students"))
<?php
$dateOfBirth = old('dob');
$admission_date = old('admission_date');
$departure_date = old('departure_date');
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
            {!! Form::open(['action' => 'Admin\StudentController@store','files'=>true, 'id' => 'student-add-form']) !!}
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
                            <!--Row 1 -->
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="id_card">@lang('messages.Id Card')<span
                                                    class="la-required">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" required="1" name="id_card" id="id_card"
                                               placeholder="@lang('messages.Enter student id card no')" value="{{old('id_card')}}">
                                    </div>
                                </div>
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
                                        <label for="dob">@lang('messages.Date Of Birth')<span
                                                    class="la-required">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' class="form-control" name="dob" id="dob"
                                                   placeholder="@lang('messages.Enter Date')" required="1"
                                                   value="@if(isset($dateOfBirth)) {{$dateOfBirth}}  
                                                   @endif"/>
                                            <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Row 2 -->
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="admission_date">@lang('messages.Admission Date')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' class="form-control" name="admission_date" id="admission_date"
                                                   placeholder="@lang('messages.Enter Admission Date')"
                                                   value="@if(isset($admission_date)) {{$admission_date}} @else {{ App\Helpers\CommonHelper::showDateFormat(date('Y-m-d')) }} @endif"/>
                                            <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="orphange_id">@lang('messages.Orphange')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="orphange_id" id="orphange_id">
                                            <option value="">Select Orphange</option>
                                            @foreach ($orphanges as $orphanges)
                                                <option value="{{$orphanges->id}}">{{$orphanges->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                               {{-- --}}

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="disability_id">@lang('messages.Category')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="disability_id" id="disability_id">
                                            <option value="">Select Category</option>
                                            @foreach ($disabilities as $disability)
                                                <option value="{{$disability->id}}">{{$disability->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--Row 2 new -->
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="blood_group_id ">@lang('messages.Blood Group')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="blood_group_id"  id="blood_group_id">
                                            <option value="">Select Blood Group</option>
                                            @foreach ($blood_group as $value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="gender_id">@lang('messages.Gender')<span
                                                    class="la-required">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="gender_id" required="1" id="gender_id">
                                            @foreach ($genders as $gender)
                                                <option value="{{$gender->id}}">{{$gender->gender_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="religion_id">@lang('messages.Religion')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="religion_id" id="religion_id">
                                            @foreach ($religions as $religion)
                                                <option value="{{$religion->id}}">{{$religion->religion_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <!--Row 3 -->
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="tribe_name">@lang('messages.Tribe Name')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="tribe_name"
                                               id="tribe_name"
                                               placeholder="@lang('messages.Enter Tribe Name')"
                                               value="{{old('tribe_name')}}">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="height">@lang('messages.Height')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="height" id="height"
                                               placeholder="@lang('messages.Enter Height')" value="{{old('height')}}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="weight">@lang('messages.Weight') (KG)</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="weight" id="weight"
                                               placeholder="Enter weight in kg" value="{{old('weight')}}">
                                    </div>
                                </div>
                            </div>
                            <!--Row 4 -->
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="institute">@lang('messages.Institute')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="institute" id="institute"
                                               placeholder="@lang('messages.Enter Institute Name')"
                                               value="{{old('institute')}}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="class_id">@lang('messages.Class')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="class_id" id="class_id">
                                            <option value="">Select Class</option>
                                            @foreach ($sections as $section)
                                                <option value="{{$section->id}}">{{$section->class_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="class_roll">@lang('messages.Class Roll')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="class_roll" id="class_roll"
                                               placeholder="@lang('messages.Enter Class Roll')"
                                               value="{{old('class_roll ')}}">
                                    </div>
                                </div>
                            </div>
                            <!--Row Father -->
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="is_father">@lang('messages.Is Father')<span
                                                    class="la-required">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="is_father" id="is_father" required="1">
                                            <option value="1">Present</option>
                                            <option selected value="2">Died</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="father_name">@lang('messages.Father Name')<span
                                                    class="la-required"></span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="father_name" id="father_name"
                                               placeholder="@lang('messages.Enter Father Name')"
                                               value="{{old('father_name')}}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="father_occupation">@lang('messages.Father Occupation')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="father_occupation"
                                               id="father_occupation"
                                               placeholder="@lang('messages.Enter Father Occupation')"
                                               value="{{old('father_occupation')}}">
                                    </div>
                                </div>
                            </div>
                            <!--Row Mother -->
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="is_mother">@lang('messages.Is Mother')<span
                                                    class="la-required">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="is_mother" id="is_mother" required="1">
                                            <option value="1">Present</option>
                                            <option selected value="2">Died</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="mother_name">@lang('messages.Mother Name')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="mother_name" id="mother_name"
                                               placeholder="@lang('messages.Enter Mother Name')"
                                               value="{{old('mother_name')}}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="mother_occupation">@lang('messages.Mother Occupation')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="mother_occupation"
                                               id="mother_occupation"
                                               placeholder="@lang('messages.Enter Mother Occupation')"
                                               value="{{old('mother_occupation')}}">
                                    </div>
                                </div>
                            </div>
                            <!--Row Gurdian -->
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="gurdian_name">@lang('messages.Gurdian Name')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="gurdian_name" id="gurdian_name"
                                               placeholder="@lang('messages.Enter Gurdian Name')"
                                               value="{{old('gurdian_name')}}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="gurdian_relation">@lang('messages.Gurdian Relation')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="gurdian_relation" id="gurdian_relation"
                                               placeholder="@lang('messages.Enter Gurdian Relation')"
                                               value="{{old('gurdian_relation')}}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="siblings">@lang('messages.Siblings')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="siblings"
                                               id="siblings"
                                               placeholder="@lang('messages.Enter Siblings')"
                                               value="{{old('siblings')}}">
                                    </div>
                                </div>
                            </div>
                            <!--Row Address -->
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="present_address">@lang('messages.Present Address')</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <textarea name="present_address" class="form-control" rows="3" placeholder="Enter Present Address"
                                                  id="present_address">{{old('present_address')}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="permanent_address">@lang('messages.Permanent Address')</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <textarea name="permanent_address" class="form-control" rows="3" placeholder="Enter Permanent Address"
                                                  id="permanent_address">{{old('permanent_address')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <!--Row Biography and orphan -->
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="biography">@lang('messages.Biography')</label>
                                    </div>
                                </div>
                                <div class="col-md-11">
                                    <div class="form-group">
                        <textarea name="biography" class="form-control" rows="4" placeholder="Enter Biography"
                                  id="biography">{{old('biography')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="reason_for_orphan">@lang('messages.Reason For Orphan')</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="reason_for_orphan" id="reason_for_orphan"
                                               placeholder="@lang('messages.Enter orphan reason')"
                                               value="{{old('reason_for_orphan')}}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="contact_no ">@lang('messages.Contact No')</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type='text' class="form-control" name="contact_no" id="contact_no"
                                               placeholder="@lang('messages.Enter Contact No')" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="illness">@lang('messages.Illness')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="illness" id="illness"
                                               placeholder="@lang('messages.Enter Illness')"
                                               value="{{old('illness')}}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="student_video">@lang('messages.Video Link')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="url" class="form-control" name="student_video" id="student_video"
                                               placeholder="@lang('messages.Enter Youtube Video Link')"
                                               value="{{old('student_video')}}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="departure_date">@lang('messages.Departure Date')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' class="form-control" name="departure_date" id="departure_date"
                                                   placeholder="@lang('messages.Enter Date')" 
                                                   value="@if(isset($departure_date)) {{$departure_date}}
                                                   @endif"/>
                                            <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--Last Row-->
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="scholarship_amount">@lang('messages.Scholarship Amount')<span class="la-required">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="number" min="0" class="form-control" name="scholarship_amount" required="1"
                                               id="scholarship_amount"
                                               placeholder="@lang('messages.Enter Scholarship Amount')"
                                               value="{{old('scholarship_amount')}}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="is_scholarship">@lang('messages.Is Scholarship')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="is_scholarship" id="is_scholarship">
                                            <option value="1">Scholarship given</option>
                                            <option value="2" selected>Scholarship not given</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="is_website">@lang('messages.Is Website')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control" name="is_website" id="is_website">
                                            <option value="1">Show in website</option>
                                            <option value="2" selected>Not show in website</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <!--Image Row start-->
                            <!-- <div class="row">
                                <div class="col-md-1">&nbsp;</div>
                                <div class="col-md-11">
                                    <div class="image-suggestion">
                                        <ul style="list-style: none;background: #10cfbd;padding: 12px; color: #fff">
                                            <li>
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                <span>
                                    Image must be type jpeg,jpg,png,gif and maximum size 10000KB.
                                </span>
                                            </li>
                                            <li>
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                                <span>
                                    Image Background color white and dimension 720 x 960 for better look your site.
                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="student_image">@lang('messages.Student Image')<span class="la-required">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="file" id="student_image" name="student_image" required="1">
                                        <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size: 360X300px
                                        </span>
                                    </div>
                                </div>
                                {{-- 
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="student_smile_image">@lang('messages.Student Smile Image')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="file" id="student_smile_image" name="student_smile_image">
                                        <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size: 360X253px
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="student_poster_image">@lang('messages.Student Poster Image')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="file" id="student_poster_image" name="student_poster_image">
                                        <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size: 750X461px
                                        </span>
                                    </div>
                                </div>
                                --}}
                            </div>
                            <!--Image Row end-->
                        </div>

                    </div>
                    {{--Bangle Content--}}
                    <div id="bangla" class="tab-pane fade"><br>
                        <div id="home-tab-wrapper" style="padding: 25px 0 25px 0">
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="bn_name">@lang('messages.Bangla Name')<span class="la-required">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="bn_name" id="bn_name"
                                               placeholder="@lang('messages.Enter Bangla Name')"
                                               value="{{old('bn_name')}}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="bn_father_name">@lang('messages.Father Name(Bangla)')<span
                                                    class="la-required"></span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="bn_father_name"
                                               id="bn_father_name"
                                               placeholder="@lang('messages.Enter Father Bangla Name')"
                                               value="{{old('bn_father_name')}}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="bn_mother_name">@lang('messages.Mother Name(Bangla)')<span
                                                    class="la-required"></span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="bn_mother_name"
                                               id="bn_mother_name"
                                               placeholder="@lang('messages.Enter Mother Bangla Name')"
                                               value="{{old('bn_mother_name')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="bn_institute">@lang('messages.Institute Name(Bangla)')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="bn_institute"
                                               id="bn_institute"
                                               placeholder="@lang('messages.Enter Institute Bangla Name')"
                                               value="{{old('bn_institute')}}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="bn_father_occupation">@lang('messages.Father Occupation(Bangla)')
                                            <span
                                                    class="la-required"></span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="bn_father_occupation"
                                               id="bn_father_occupation"
                                               placeholder="@lang('messages.Enter Bangla Father Occupation Name')"
                                               value="{{old('bn_father_occupation')}}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="bn_mother_occupation">@lang('messages.Mother Occupation(Bangla)')
                                            <span
                                                    class="la-required"></span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="bn_mother_occupation"
                                               id="bn_mother_occupation"
                                               placeholder="@lang('messages.Enter Bangla Mother Occupation Name')"
                                               value="{{old('bn_mother_occupation')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="bn_gurdian_name">@lang('messages.Gurdian Name(Bangla)')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="bn_gurdian_name"
                                               id="bn_gurdian_name"
                                               placeholder="@lang('messages.Enter Bangla Gurdian Name')"
                                               value="{{old('bn_gurdian_name')}}">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="bn_gurdian_relation">@lang('messages.Gurdian Relation(Bangla)')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="bn_gurdian_relation"
                                               id="bn_gurdian_relation"
                                               placeholder="@lang('messages.Enter Bangla Gurdian Relation')"
                                               value="{{old('bn_gurdian_relation')}}">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="bn_tribe_name">@lang('messages.Tribe Name(Bangla)')</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="bn_tribe_name"
                                               id="bn_tribe_name"
                                               placeholder="@lang('messages.Enter Bangla Tribe Name')"
                                               value="{{old('bn_tribe_name')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="bn_present_address">@lang('messages.Present Address(Bangla)')</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                        <textarea name="bn_present_address" class="form-control" placeholder="Enter Bangla Present Address"
                                  id="bn_present_address">{{old('bn_present_address')}}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="bn_permanent_address">@lang('messages.Permanent Address (Bangla)')</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                        <textarea name="bn_permanent_address" class="form-control" placeholder="Enter Bangla Permanent Address"
                                  id="bn_permanent_address">{{old('bn_permanent_address')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="bn_biography">@lang('messages.Biography(Bangla)')</label>
                                    </div>
                                </div>
                                <div class="col-md-11">
                                    <div class="form-group">
                        <textarea name="bn_biography" class="form-control" placeholder="Enter Bangla Biography"
                                  id="bn_biography">{{old('bn_biography')}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="bn_reason_for_orphan">@lang('messages.Reason For Orphan(Bn)')</label>
                                    </div>
                                </div>
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="bn_reason_for_orphan" id="bn_reason_for_orphan"
                                               placeholder="@lang('messages.Enter orphan reason bangla')"
                                               value="{{old('bn_reason_for_orphan')}}">
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>





                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute') .'/students') }}">@lang('messages.Cancel')</a>
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
        $("#student-add-form").validate({

        });
        $(".nav-tabs a").click(function () {
            $(this).tab('show');
        });

    });


</script>
@endpush
