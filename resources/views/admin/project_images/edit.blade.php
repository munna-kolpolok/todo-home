@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/project_images') }}">@lang('messages.Project Images')</a> :
@endsection
@section("section", trans("messages.Gallery"))
@section("section_url", url(config('laraadmin.adminRoute') . '/project_images'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", trans("messages.Edit Project Images"))

@section("main-content")
    <style type="text/css">
        #save_div {
            display: none;
        }

        .suggestion_text {
            color: green;
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
        {!! Form::model($project_images, ['route' => [config('laraadmin.adminRoute') . '.project_images.update', $project_images->id ],'method' =>'PUT','files' => true,'role'=>"form"]) !!}

        <div class="box-body">
            <div style="border: 1px solid #eeeeee; padding: 20px; margin: 10px 0;box-shadow: 0 0px 0 2px rgba(0,0,0,.2)"
                 class="vgallery_wrapper">

                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="parent">@lang('messages.Projects')<span
                                            class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <select class="form-control gallery-category" name="project_id" id="CatRow"    required>
                                    @foreach($projects as $val)
                                    <option value="{{$val->id}}" {{$project_images->project_id==$val->id? "selected":""}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image">@lang('messages.Project Images')<span
                                            class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="file" class="form-control image" name="image">
                            
                            <span class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg. Size:800X550px
                            </span>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group">
                                @if(!is_null($project_images->image))
                                    <img src="{{asset($project_images->image)}}" alt="Image" width="200px"
                                         height="138px">
                                @else
                                    <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image"
                                         width="50px" height="40px">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row" id="press-submit-wrapper">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                        <a class="btn btn-default"
                           href="{{ url(config('laraadmin.adminRoute') .'/project_images') }}">@lang('messages.Cancel')</a>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>


@endsection

@push('scripts')
<script type="text/javascript">

</script>
@endpush
