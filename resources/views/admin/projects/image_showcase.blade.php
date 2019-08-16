@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/projects') }}">@lang('messages.Projects')</a> :
@endsection
@section("contentheader_description", trans("messages.Projects Image Listing"))
@section("section", trans("messages.Projects"))
@section("section_url", url(config('laraadmin.adminRoute') . '/projects'))
@section("sub_section", trans("messages.Images"))
@section("htmlheader_title", trans("messages.Projects Image Listing"))

@section("headerElems")

@endsection

@section("main-content")
<style>
    .suggestion_text{
        color:green;
        font-size: 12px;
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
        <!--<div class="box-header"></div>-->
        <div class="box-body">
            {{ Form::open( array('url' => action('Admin\ProjectController@updateImage', $project->id), 'files'=>true,'method'=>'post') ) }}
           
            <div style="margin-bottom: 20px" class="row">
                <div class="col-md-4">
                    <div class="image-wrapper text-center">
                        @if(!is_null($project->project_image))
                            <img src="{{asset($project->project_image)}}" alt="{{$project->name}}" width="250px"
                                 height="200px">
                        @else
                            <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="250px"
                                 height="200px">
                        @endif
                        <h4 class="text-success">@lang('messages.Project Image')</h4>
                        <input style="margin-left: 77px" type="file" id="project_image" name="project_image">
                        <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg. Size: 600X442px
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="image-wrapper text-center">
                        @if(!is_null($project->project_big_image))
                            <img src="{{asset($project->project_big_image)}}" alt="{{$project->name}}" width="250px"
                                 height="200px">
                        @else
                            <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="250px"
                                 height="200px">
                        @endif
                        <h4 class="text-success">@lang('messages.Project Poster Image')</h4>
                        <input style="margin-left: 77px" type="file" id="project_big_image" name="project_big_image">
                        <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg. Size: 450X500px
                        </span>
                    </div>
                </div>
                <div class="col-md-4">

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-success" value="Submit">
                    <a class="btn btn-default"
                       href="{{ url(config('laraadmin.adminRoute') . '/projects') }}">@lang('messages.Cancel')</a>
                </div>


            </div>
            {{ Form::close() }}
        </div>


        @endsection

        @push('scripts')
        <script>

        </script>
    @endpush
