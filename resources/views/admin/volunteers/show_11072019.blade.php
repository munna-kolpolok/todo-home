@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Volunteers"))
@section("contentheader_description", trans("messages.Volunteers Details"))
@section("section", trans("messages.Volunteers"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Volunteers Details"))

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
               {{-- <h3 style="text-align: center; ">Volunteer Information</h3>--}}
                <div  class="{{$volunteer->volunteer==2? 'col-md-6':'col-md-12'}}">
                    <div class="image-wrapper text-center">
                        @if(!is_null($volunteer->profile_image))
                            <img src="{{asset($volunteer->profile_image)}}" alt="{{$volunteer->first_name.' '.$volunteer->last_name}}" width="200px"
                                 height="150px">
                        @else
                            <img src="{{asset('uploads/students/default/default.png')}}" alt="No Image" width="200px"
                                 height="150px">
                        @endif
                        <h4 class="text-success">@lang('messages.Volunteer Profile Image')</h4>
                    </div>
                </div>
                @if($volunteer->volunteer==2)
                <div class="col-md-6">
                        <div class="image-wrapper text-center">
                            @if(!is_null($volunteer->pasport_image))
                                <img src="{{asset($volunteer->pasport_image)}}" alt="{{$volunteer->first_name.' '.$volunteer->last_name}}" width="200px"
                                     height="150px">
                            @else
                                <img src="{{asset('uploads/students/default/default.png')}}" alt="No Image" width="250px"
                                     height="200px">
                            @endif
                            <h4 class="text-success">Volunteer Passport Image</h4>
                        </div>
                </div>
                @endif

            </div>
            <div>

                <div class="row">
                    <div class="col-md-12">
                        <h3 style="">Volunteer Information</h3>
                        <table class="table table-hover">
                            <tr>
                                <th style="width: 20%;">@lang('messages.Name')</th>
                                <td style="width: 30%;"><strong>{{$volunteer->first_name.' '.$volunteer->last_name}}</strong></td>

                                <th style="width: 20%;" >@lang('messages.Branch')</th>
                                <td style="width: 30%;" >{{ $volunteer->contact->name or null }}</td>
                            </tr>
                            <tr>

                            </tr>
                            <tr>
                                <th>@lang('messages.Email')</th>
                                <td>{{ $volunteer->email or null }}</td>
                                <th>@lang('messages.Contact No')</th>
                                <td>{{  $volunteer->contact_no or null }}</td>
                            </tr>

                            <tr>
                                <th>@lang('messages.Address')</th>
                                <td>{{ $volunteer->address or null }}</td>
                                <th>@lang('messages.interest')</th>
                                <td>{{ $volunteer->interest or null }}</td>
                            </tr>

                            <tr>
                                <th>@lang('messages.biography')</th>
                                <td ><span >{{ $volunteer->biography or null }}</span></td>
                                <th>Volunteer</th>
                                <td> @if($volunteer->volunteer==1) Bangladeshi @else International @endif </td>
                            </tr>
                            @if($volunteer->volunteer==2)
                                <tr>
                                    <th>Nationality</th>
                                    <td>{{ $volunteer->nationality or null }}</td>
                                    <th>Passport No</th>
                                    <td>{{ $volunteer->passport_no or null }}</td>
                                </tr>
                            @endif


                            <tr>
                                <th>Gender</th>
                                <td>{{ $volunteer->gender->gender_name or null }}</td>
                                <th>Date of Birth</th>
                                <td>{{ $volunteer->dob or null }}</td>
                            </tr>
                            <tr>
                                <th>Start Date</th>
                                <td>{{ $volunteer->start_date or null }}</td>
                                <th>End Date</th>
                                <td>{{ $volunteer->end_date or null }}</td>
                            </tr>

                            <tr>
                                <th>Emergency Contact</th>
                                <td>{{ $volunteer->emergency_contact_details or null }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
