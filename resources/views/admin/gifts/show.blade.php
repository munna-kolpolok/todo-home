@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Gifts"))
@section("contentheader_description", trans("messages.Gifts Details"))
@section("section", trans("messages.Gifts"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Gifts Details"))

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
                <h3 class="text-center">Gift Info</h3>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tr>
                                <th>@lang('messages.Gift Image')</th>
                                <td>
                                    @if(!is_null($gifts->image))
                                        <img src="{{asset($gifts->image)}}" alt="Image" width="150px"
                                             height="100px">
                                    @else
                                        <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="250px"
                                             height="200px">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Name')</th>
                                <td>{{ $gifts->name or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Name (Bangla)')</th>
                                <td>{{$gifts->bn_name or null}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Price')</th>
                                <td class="success">{{ $gifts->price or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Order')</th>
                                <td>{{ $gifts->serial_no }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
