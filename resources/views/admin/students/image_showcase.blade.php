@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/students') }}">@lang('messages.Student')</a> :
@endsection
@section("contentheader_description", trans("messages.Students Image Listing"))
@section("section", trans("messages.Students"))
@section("section_url", url(config('laraadmin.adminRoute') . '/students'))
@section("sub_section", trans("messages.Images"))
@section("htmlheader_title", trans("messages.Students Image Listing"))

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
            {{ Form::open( array('url' => action('Admin\StudentController@updateImage', $student->id), 'files'=>true,'method'=>'post') ) }}
            
            <div style="margin-bottom: 20px" class="row">
                <div class="col-md-4">
                    <div class="image-wrapper text-center">
                        @if(!is_null($student->student_image))
                            <img src="{{asset($student->student_image)}}" alt="{{$student->name}}" width="250px"
                                 height="200px">
                        @else
                            <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="250px"
                                 height="200px">
                        @endif
                        <h4 class="text-success">{{ $student->name }}-{{ $student->id_card }}</h4>
                        <input style="margin-left: 77px" type="file" id="student_image" name="student_image">
                        <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size: 360X300px
                        </span>
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
                        <input style="margin-left: 77px" type="file" id="student_smile_image" name="student_smile_image">
                        <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size: 360X253px
                        </span>
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
                        <input style="margin-left: 77px" type="file" id="student_poster_image" name="student_poster_image">
                        <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size: 750X461px
                        </span>
                    </div>
                </div>
                --}}
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-success" value="Submit">
                    <a class="btn btn-default"
                       href="{{ url(config('laraadmin.adminRoute') . '/students') }}">@lang('messages.Cancel')</a>
                </div>


            </div>
            {{ Form::close() }}
        </div>


        @endsection

        @push('scripts')
        <script>

        </script>
    @endpush
