@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Students"))
@section("contentheader_description", trans("messages.Students Details"))
@section("section", trans("messages.Students"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Students Details"))

@section("headerElems")

@endsection

@section("main-content")

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
        <!--<div class="box-header"></div>-->
        <div class="box-body">
            {{--Image Suggestion--}}
            <div class="row">
                <div class="col-md-12">
                    <div class="image-wrapper text-center">
                        @if(!is_null($student->student_image))
                            <img src="{{asset($student->student_image)}}" alt="{{$student->name}}" width="250px"
                                 height="200px">
                        @else
                            <img src="{{asset('uploads/students/default/default.png')}}" alt="No Image" width="250px"
                                 height="200px">
                        @endif
                        <h4 class="text-success">@lang('messages.Student Image')</h4>
                    </div>
                </div>
                {{-- 
                <div class="col-md-4">
                    <div class="image-wrapper text-center">
                        @if(!is_null($student->student_smile_image))
                            <img src="{{asset($student->student_smile_image)}}" alt="{{$student->name}}" width="250px"
                                 height="200px">
                        @else
                            <img src="{{asset('uploads/products/default/default.png')}}" alt="No Image" width="250px"
                                 height="200px">
                        @endif
                        <h4 class="text-success">@lang('messages.Student Smile Image')</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="image-wrapper text-center">
                        @if(!is_null($student->student_poster_image))
                            <img src="{{asset($student->student_poster_image)}}" alt="{{$student->name}}" width="250px"
                                 height="200px">
                        @else
                            <img src="{{asset('uploads/products/default/default.png')}}" alt="No Image" width="250px"
                                 height="200px">
                        @endif
                            <h4 class="text-success">@lang('messages.Student Poster Image')</h4>
                    </div>
                </div>
                --}}
            </div>
            <div>
                <h3>Student Info</h3>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-hover">
                            <tr>
                                <th>@lang('messages.Name')</th>
                                <td>{{ $student->name or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Bangla Name')</th>
                                <td>{{ $student->bn_name or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Date Of Birth')</th>
                                <td>{{  $student->dob or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Scholarship Amount')</th>
                                <td>{{ $student->scholarship_amount or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Father Name(Bangla)')</th>
                                <td>{{ $student->bn_father_name or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Father Name')</th>
                                <td>{{ $student->father_name or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Mother Name')</th>
                                <td>{{ $student->mother_name or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Mother Name(Bangla)')</th>
                                <td>{{ $student->bn_mother_name or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Gender')</th>
                                <td>{{ $student->gender->gender_name or null}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Disability')</th>
                                <td>{{ $student->disability->name or null}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Class')</th>
                                <td>{{ $student->section->class_name or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Institute')</th>
                                <td>{{ $student->institute or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Institute Name(Bangla)')</th>
                                <td>{{ $student->bn_institute or null }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-hover">
                            <tr>
                                <th>@lang('messages.Height')</th>
                                <td>{{ $student->height or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Weight')</th>
                                <td>{{ $student->weight or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Religion')</th>
                                <td>{{  $student->religion->religion_name or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Tribe Name')</th>
                                <td>{{ $student->tribe_name or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Orphange')</th>
                                <td>{{ $student->orphange->name or null }}</td>
                            </tr>
                            <tr>
                                <th>Tribe Name Bangla</th>
                                <td>{{ $student->bn_tribe_name or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Is Father')</th>
                                <td>{{ $student->is_father === 1 ? 'Yes': 'No'}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Is Mother')</th>
                                <td>{{ $student->is_mother === 1 ? 'Yes' : 'No'}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Is Website')</th>
                                <td>{{ $student->is_website === 1 ? 'Yes' : 'No'}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Is Scholarship')</th>
                                <td>{{ $student->is_scholarship === 1 ? 'Yes' : 'No'}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Video Link')</th>
                                <td><a href="{{$student->student_video}}" target="_blank" title="Click to see">{{$student->student_video}} </a></td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Departure Date')</th>
                                <td>@if($student->departure_date !='0000-00-00') {{$student->departure_date}}  @endif</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
<script>

</script>
@endpush
