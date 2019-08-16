@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Sliders"))
@section("contentheader_description", trans("messages.Sliders listing"))
@section("section", trans("messages.Sliders"))
@section("sub_section", trans("messages.Sliders"))
@section("htmlheader_title", trans("messages.Sliders listing"))

@section("headerElems")
    @la_access("Sliders", "create")
    <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">@lang("messages.Add Slider")</button>
    @endla_access
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

    @if(Session::has('seccess_msg'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{ Session::get('seccess_msg') }}</strong>
        </div>
    @endif


    <div class="box box-success">
        <!--<div class="box-header"></div>-->
        <div class="box-body">
            <table id="example1" class="table table-bordered">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Image</th>
                    <th>Caption UP</th>
                    <th>Caption Down</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sliders as $key => $slider)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>
                            <img src="{{asset($slider->image)}}" alt="{{$slider->caption_up}}" width="200px" height="150px">
                        </td>
                        <td>{{$slider->caption_up or null}}</td>
                        <td>{{ $slider->caption_down or null }}</td>

                        <td>
                            <a href="{{url(config('laraadmin.adminRoute').'/sliders/'.$slider->id.'/edit')}}"
                               class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i
                                        class="fa fa-edit" title="Edit"></i></a>

                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.sliders.destroy', $slider->id], 'method' => 'delete', 'style'=>'display:inline'])}}
                            <button class="btn btn-danger btn-xs" type="submit"
                                    onclick="return confirm('Are you sure to delete this entry?')"><i
                                        class="fa fa-times" title="Delete"></i></button>
                            {{Form::close()}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    @la_access("Sliders", "create")
    <div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">@lang("messages.Add Slider")</h4>
                </div>
                {!! Form::open(['action' => 'Shop\SlideSettingController@store', 'files' => 'true', 'id' => 'slide-add-form']) !!}
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="caption_up">Caption UP<span class="la-required">*</span>:</label>
                            <input type="text" class="form-control" minlength="5" maxlength="20" name="caption_up" id="caption_up" placeholder="Enter Caption UP Text" required>
                        </div>
                        <div class="form-group">
                            <label for="caption_down">Caption Down<span class="la-required">*</span>:</label>
                            <input type="text" class="form-control" minlength="5" maxlength="25" name="caption_down" id="caption_down" placeholder="Enter Caption Down Text" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Slide Image<span class="la-required">*</span>:</label>
                            <input style="margin-top: 5px" type="file" id="image" name="image" required>
                            <span style="color: red;font-weight: bold">Image Dimension Must Be 1349 X 570</span><br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.Close')</button>
                    {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @endla_access


@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
    $('#example1').DataTable( {
        responsive: false,
        columnDefs: [ { orderable: false, targets: [-1] }]
    } );

    $(function () {
        $('#slide-add-form').validate();
    })
</script>
@endpush
