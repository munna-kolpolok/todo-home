@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Videos"))
@section("contentheader_description", trans("messages.Videos Details"))
@section("section", trans("messages.Videos"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Videos Details"))

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
                <h3 class="text-center">Video Info</h3>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tr>
                                <th >@lang('messages.Video Cover Image')</th>
                                <td style="">
                                    @if(!is_null($videos->image))
                                       <a href="{{ $videos->video_link}}" target="_blank"><img src="{{asset($videos->image)}}" alt="Image" width="150px"
                                             height="100px"></a> 
                                    @else
                                        <img src="{{asset('uploads/students/default/default.png')}}" alt="No Image" width="250px"
                                             height="200px">
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Website')</th>
                                <td>{{$videos->website_id==1? "Bidyanondo":"One Taka Ahar"}}</td>
                            </tr>
                            <tr>
                                <th >@lang('messages.Video Category')</th>
                                <td>{{ $videos->video_category->name or null }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Video Link')</th>
                                <td><a href="{{ $videos->video_link}}" target="_blank">{{ $videos->video_link or null }}</a></td>
                                 <td></td>
                            </tr>
                           
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
