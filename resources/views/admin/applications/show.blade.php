@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Applications"))
@section("contentheader_description", trans("messages.Applications Details"))
@section("section", trans("messages.Applications"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Applications Details"))

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
            <div>
                <h3 class="text-center">Application Info</h3>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tr>
                                <th>@lang('messages.Wedding Card Image')</th>
                                <td>
                                    @if(!is_null($applications->card_image))
                                        <img src="{{asset($applications->card_image)}}" alt="Image" width="150px"
                                             height="100px">
                                    @else
                                        <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="250px"
                                             height="200px">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Groom Image')</th>
                                <td>
                                    @if(!is_null($applications->groom_image))
                                        <img src="{{asset($applications->groom_image)}}" alt="Image" width="150px"
                                             height="100px">
                                    @else
                                        <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="250px"
                                             height="200px">
                                    @endif
                                </td>
                            </tr >
                            <tr>
                                <th>@lang('messages.Bride Image')</th>
                                <td>
                                    @if(!is_null($applications->bride_image))
                                        <img src="{{asset($applications->bride_image)}}" alt="Image" width="150px"
                                             height="100px">
                                    @else
                                        <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="250px"
                                             height="200px">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Wedding Date')</th>
                                <td class="success">{{ $applications->marriage_date or null }}</td>
                            </tr>

                            <tr>
                                <th>@lang('messages.Wedding Reception Time')</th>
                                <td class="success">{{ $applications->ceremony_period or null }}</td>
                            </tr>

                            <tr>
                                <th>@lang('messages.Groom Name')</th>
                                <td>{{ $applications->groom_name or null }}</td>
                            </tr>
                            <tr>
                                <th>Groom Name (Bangla)</th>
                                <td>{{$applications->bn_groom_name or null}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Groom Email')</th>
                                <td>{{ $applications->groom_email or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Bride Name')</th>
                                <td>{{ $applications->bride_name or null }}</td>
                            </tr>
                            <tr>
                                <th>Bride Name (Bangla)</th>
                                <td>{{$applications->bn_bride_name or null}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Bride Email')</th>
                                <td>{{ $applications->bride_email or null }}</td>
                            </tr>

                            <tr>
                                <th>Marriage Venue</th>
                                <td>{{$applications->marriage_venue or null}}</td>
                            </tr>
                            <tr>
                                <th>Marriage Venue (Bangla)</th>
                                <td>{{$applications->bn_marriage_venue or null}}</td>
                            </tr>

                            <tr>
                                <th>Message</th>
                                <td>{{$applications->message or null}}</td>
                            </tr>
                            <tr>
                                <th>Message (Bangla)</th>
                                <td>{{$applications->bn_message or null}}</td>
                            </tr>
                            
                            <tr>
                                <th>@lang('messages.Contact No')</th>
                                <td>{{ $applications->contact_no or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.In Favor')</th>
                                <td class="success">{{ ($applications->profile == 1) ? "Groom" : "Bride" }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Verified Status')</th>
                                <td class="success">{{ ($applications->is_verified == 1) ? "Verified" : "Not Verified" }}</td>
                            </tr>
                            <tr>
                                <th>Website Show Status</th>
                                <td>{{ ($applications->is_show == 1) ? "Showing" : "Not Showing" }}</td>
                            </tr>
                            <tr>
                                <th>Created IP Address</th>
                                <td>{{ $applications->created_ip_address or null }}</td>
                            </tr>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
