@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/site_settings') }}">@lang('messages.Site Settings')</a> :
@endsection
@section("section", trans("messages.Site Settings"))
@section("section_url", url(config('laraadmin.adminRoute') . '/site_settings'))
@section("sub_section", trans("messages.Update"))

@section("htmlheader_title", trans("messages.Site Settings"))

@section("main-content")
    <style type="text/css">
        #save_div {
            display: none;
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

    @if(Session::has('seccess_msg'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{ Session::get('seccess_msg') }}</strong>
        </div>
    @endif

    <?php //print_r($groups); die(); ?>
    <div class="box box-success">
        <div class="box-body">
            {{ Form::open( array('url' => config('laraadmin.adminRoute').'/sliders/'.$slider->id, 'files'=>true, 'method'=>'PATCH', 'id' => 'slide-settings-form'))}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="caption_up">@lang('messages.Caption Up')<span class="la-required">*</span></label>
                        <input type="text" class="form-control" minlength="5" maxlength="20" name="caption_up" id="caption_up" value="{{$slider->caption_up}}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="caption_down">@lang('messages.Caption Down')<span class="la-required">*</span></label>
                        <input type="text" class="form-control" minlength="5" maxlength="25" name="caption_down" id="caption_down" value="{{$slider->caption_down}}" required>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        @if(!is_null($slider->image))
                        <img src="{{asset($slider->image)}}" alt="Slider Image" width="250px" height="250px">
                        @endif
                        <input style="margin-top: 5px" type="file" id="image" name="image" accept="image/png,image/gif,image/jpeg,image/jpg">
                        <span style="color: red;font-weight: bold">Image Dimension Must Be 1349 X 570</span><br>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!}
                    <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/sliders') }}">@lang('messages.Cancel')</a>
                </div>
            </div>
            {{ Form::close() }}

        </div>
    </div>
    @endsection


    @push('scripts')
    <script>
        $(function () {
            $("#slide-settings-form").validate({});
        });
    </script>
    @endpush

    <script type="text/javascript">

    </script>
