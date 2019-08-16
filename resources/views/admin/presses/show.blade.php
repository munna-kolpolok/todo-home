@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Presses"))
@section("contentheader_description", trans("messages.Presses Details"))
@section("section", trans("messages.Presses"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Presses Details"))

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
                <h3 class="text-center">Press Info</h3>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tr>
                                <th>@lang('messages.Press Cover Image')</th>
                                <td>
                                    @if(!is_null($presses->image))
                                        <img src="{{asset($presses->image)}}" alt="Image" width="150px"
                                             height="100px">
                                    @else
                                        <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="250px"
                                             height="200px">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Published Date')</th>
                                <td>{{ $presses->published_date or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Website')</th>
                                <td>{{$presses->website_id==1? "Bidyanondo":"One Taka Ahar"}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Category')</th>
                                <td>{{ $presses->press_category->name or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Link')</th>
                                <td>{{ $presses->press_link or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Is Video')</th>
                                <td>
                                    @if($presses->is_video == 1)
                                        <span class="panel panel-success">Yes</span>
                                        @else
                                        <span class="panel panel-danger">No</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th  style="vertical-align: middle;">@lang('messages.Description')</th>
                                <td><div style="background-color: #fbfffd; padding: 10px 5px; border:1px solid lightgray; border-radius: 5px;">{{ $presses->description or null }}</div></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
