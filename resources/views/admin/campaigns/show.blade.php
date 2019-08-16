@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Campaigns"))
@section("contentheader_description", trans("messages.Campaign Details"))
@section("section", trans("messages.Campaigns"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Campaign Details"))

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
                <h3 class="text-center">Campaign Info</h3>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tr>
                                <th>@lang('messages.Cover Image')</th>
                                <td>
                                    @if(!is_null($campaigns->cover_image))
                                        <img src="{{asset($campaigns->cover_image)}}" alt="Image" width="150px"
                                             height="100px">
                                    @else
                                        <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="250px"
                                             height="200px">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Title')</th>
                                <td>{{ $campaigns->title or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Title(Bangla)')</th>
                                <td>{{ $campaigns->bn_title or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Campaign Date')</th>
                                <td>{{ $campaigns->date or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Website')</th>
                                <td class="success">{{$campaigns->website->name or null}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Is Home')</th>
                                @if($campaigns->is_home == 1)
                                    <td class="success">Yes</td>
                                @else
                                    <td class="danger">No</td>
                                @endif
                            </tr>
                            <tr>
                                <th>@lang('messages.Is Show')</th>
                                @if($campaigns->is_show == 1)
                                    <td class="success">Yes</td>
                                @else
                                    <td class="danger">No</td>
                                @endif
                            </tr>
                            <tr>
                                <th  style="vertical-align: middle;">@lang('messages.Description')</th>
                                <td><div style="background-color: #fbfffd; padding: 10px 5px; border:1px solid lightgray; border-radius: 5px;">{{ $campaigns->description or null }}</div></td>
                            </tr>
                            <tr>
                                <th  style="vertical-align: middle;">@lang('messages.Description Bangla')</th>
                                <td><div style="background-color: #fbfffd; padding: 10px 5px; border:1px solid lightgray; border-radius: 5px;">{{ $campaigns->bn_description or null }}</div></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
