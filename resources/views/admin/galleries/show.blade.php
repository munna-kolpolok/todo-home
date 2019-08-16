@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Gallery"))
@section("contentheader_description", trans("messages.Gallery Image Details"))
@section("section", trans("messages.Gallery"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Gallery Image Details"))

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
                <h3 class="text-center">Gallery Info</h3>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tr>
                                <th >@lang('messages.Gallery Image')</th>
                                <td style="">
                                    @if(!is_null($galleries->gallery_image))
                                       <img src="{{asset($galleries->gallery_image)}}" alt="Image" width="150px"
                                             height="100px"> 
                                    @else
                                        <img src="{{asset('uploads/students/default/default.png')}}" alt="No Image" width="250px"
                                             height="200px">
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Website')</th>
                                <td>{{$galleries->website_id==1? "Bidyanondo":"One Taka Ahar"}}</td>
                            </tr>
                            <tr>
                                <th >@lang('messages.Gallery Category')</th>
                                <td>{{ $galleries->gallery_category->name or null }}</td>
                                <td></td>
                            </tr>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
