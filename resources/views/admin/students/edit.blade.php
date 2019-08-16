@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/students') }}">@lang('messages.Students')</a> :
@endsection
@section("section", trans("messages.Students"))
@section("section_url", url(config('laraadmin.adminRoute') . '/students'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", trans("messages.Edit Students"))

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
            {{ Form::open( array('url' => config('laraadmin.adminRoute').'/students/'.$student->id, 'method'=>'PATCH',
            'id' => 'student-edit-form'))}}
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
                                               placeholder="@lang('messages.Enter student id card no')" value="{{$student->id_card}}">
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
                                               placeholder="@lang('messages.Enter Name')" value="{{$student->name}}">
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
                                                   value="@if(isset($birth_day)) {{$birth_day}} @else {{ App\Helpers\CommonHelper::showDateFormat(date('Y-m-d')) }} @endif"/>
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
                                                   value="@if(isset($admissionDate)) {{$admissionDate}} @else {{ App\Helpers\CommonHelper::showDateFormat(date('Y-m-d')) }} @endif"/>
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
                                            <?php
                                            $orphanges_options = App\Models\Common_Model::common_dropdown('orphanges', 'id', 'name', $student->orphange_id, 'Orphange');
                                            echo $orphanges_options;
                                            ?>
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
                                            <?php
                                            $desaibility_options = App\Models\Common_Model::common_dropdown('disabilities', 'id', 'name', $student->disability_id, 'Category');
                                            echo $desaibility_options;
                                            ?>
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
                                            <?php
                                            $blood_group_options = App\Models\Common_Model::common_dropdown('blood_groups', 'id', 'name', $student->blood_group_id, 'Blood Group');
                                            echo $blood_group_options;
                                            ?>
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
                                            <?php
                                            $gender_options = App\Models\Common_Model::common_dropdown('genders', 'id', 'gender_name', $student->gender_id, 'Gender');
                                            echo $gender_options;
                                            ?>
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
                                            <?php
                                            $religion_options = App\Models\Common_Model::common_dropdown('religions', 'id', 'religion_name', $student->religion_id, 'Religion');
                                            echo $religion_options;
                                            ?>
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
                                               value="{{$student->tribe_name}}">
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
                                               placeholder="@lang('messages.Enter Height')" value="{{$student->height}}">
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
                                               placeholder="Enter weight in kg" value="{{$student->weight}}">
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
                                               value="{{$student->institute}}">
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
                                            <?php
                                            $class_options = App\Models\Common_Model::common_dropdown('sections', 'id', 'class_name', $student->class_id, 'Class');
                                            echo $class_options;
                                            ?>
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
                                               value="{{$student->class_roll}}">
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
                                            <option @if($student->is_father ==1) selected @endif value="1">Yes</option>
                                            <option @if($student->is_father ==2) selected @endif value="2">No</option>
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
                                               value="{{$student->father_name}}">
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
                                               value="{{$student->father_occupation}}">
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
                                            <option @if($student->is_mother ==1) selected @endif value="1">Yes</option>
                                            <option @if($student->is_mother ==2) selected @endif value="2">No</option>
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
                                               value="{{$student->mother_name}}">
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
                                               value="{{$student->mother_occupation}}">
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
                                               value="{{$student->gurdian_name}}">
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
                                               value="{{$student->gurdian_relation}}">
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
                                               value="{{$student->siblings}}">
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
                                                  id="present_address">{{$student->present_address}}</textarea>
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
                                                  id="permanent_address">{{$student->permanent_address}}</textarea>
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
                                  id="biography">{{$student->biography}}</textarea>
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
                                               value="{{$student->reason_for_orphan}}">
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
                                               placeholder="@lang('messages.Enter Contact No')" value="{{$student->contact_no}}" >
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
                                               value="{{$student->illness}}">
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
                                               value="{{$student->student_video}}">
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
                                                   value="@if(isset($departureDate)) {{$departureDate}}  @endif"/>
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
                                               value="{{$student->scholarship_amount}}">
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
                                            <option value="">Select a option</option>
                                            <option @if($student->is_scholarship ==1) selected @endif value="1">Scholarship given
                                            </option>
                                            <option @if($student->is_scholarship ==2) selected @endif value="2">Scholarship not given
                                            </option>
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
                                            <option value="">Select a option</option>
                                            <option @if($student->is_website ==1) selected @endif value="1">Show in website</option>
                                            <option @if($student->is_website ==2) selected @endif value="2">Not show in website</option>
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
                                               value="{{$student->bn_name}}">
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
                                               value="{{$student->bn_father_name}}">
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
                                               value="{{$student->bn_mother_name}}">
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
                                               value="{{$student->bn_institute}}">
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
                                               value="{{$student->bn_father_occupation}}">
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
                                               value="{{$student->bn_mother_occupation}}">
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
                                               value="{{$student->bn_gurdian_name}}">
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
                                               value="{{$student->bn_gurdian_relation}}">
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
                                               value="{{$student->bn_tribe_name}}">
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
                                  id="bn_present_address">{{$student->bn_present_address}}</textarea>
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
                                  id="bn_permanent_address">{{$student->bn_permanent_address}}</textarea>
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
                                  id="bn_biography">{{$student->bn_biography}}</textarea>
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
                                               value="{{$student->bn_reason_for_orphan}}">
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

        <script type="text/javascript">
            var urlDynamicDropDown = "{{ url(config('laraadmin.adminRoute') .'/common_dynamic_load_dropdown') }}";
        </script>
        @push('scripts')
        <script src="{{ asset('js/common_dynamic_load_dropdown.js') }}"></script>
        <script>
            $(function () {
                $("#student-add-form").validate({});
                $(".nav-tabs a").click(function () {
                    $(this).tab('show');
                });

            });
        </script>
        @endpush


        <script type="text/javascript">
            function group_child_drop_down() {
                common_dynamic_load_dropdown('group_id', 'category_id', 'categories', 'group_id', 'id', 'category_name');

                $("#sub_category_id").find("option:not(:first)").remove();
                $("#brand_id").find("option:not(:first)").remove();
            }
            function category_child_dropdown() {
                common_dynamic_load_dropdown('category_id', 'sub_category_id', 'sub_categories', 'category_id', 'id', 'sub_category_name');

                common_dynamic_load_dropdown('category_id', 'brand_id', 'brands', 'category_id', 'id', 'brand_name');

            }
        </script>
