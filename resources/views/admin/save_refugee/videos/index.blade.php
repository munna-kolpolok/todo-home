@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Videos"))
@section("contentheader_description", trans("messages.Videos listing"))
@section("section", trans("messages.Videos"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Videos listing"))

@section("headerElems")
    @la_access('Sr Videos', "create")
    <a data-toggle="modal" data-target="#AddModal"
       class="btn btn-success btn-sm  pull-right">  @lang("messages.Add Video")</a>

    {{-- <a href="{{ url(config('laraadmin.adminRoute') . '/sr_project_objectives/create') }}"
        class="btn btn-success btn-sm pull-right"> @lang("messages.Add Project Sliders")</a>--}}
    @endla_access
@endsection

@section("main-content")

    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{ session()->get('message') }}</strong>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
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
            <table id="example1" class="table table-bordered">
                <thead>
                <tr class="success">
                    <th>Serial</th>
                    <th style="min-width: 150px">Thambnail Image</th>
                    <th>Video Link</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($values as $key=>$value)
                    <tr>
                        <td>{{++$key}}</td>
                        <td style="vertical-align: middle;" align="center">
                            <img src="{{asset($value->image)}}" alt="image"
                                 style="margin: 0 auto; height: 40px; width: 80px;">
                        </td>
                        <td><a href="{{$value->video_link or null}}" target="_blank">{{$value->video_link or null}}</a>
                        </td>

                        <td style="min-width: 80px!important;">
                            <input type="hidden" id="img_{{$value->id}}" value="{{asset($value->image)}}">
                            @la_access('Sr Videos', "edit")
                            <a data-toggle="modal" data-target="#video-edit-modal"
                               onclick="getVideo({{$value->id}})"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"> <i class="fa fa-edit"> </i></a>
                            @endla_access
                            @la_access('Sr Videos', "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.sr_video.destroy', $value->id], 'method' => 'delete', 'style'=>'display:inline'])}}
                            <button class="btn btn-danger btn-xs" type="submit" data-toggle="tooltip" title="Delete"
                                    onclick="return confirm('Are you sure to delete this entry?')"><i
                                        class="fa fa-times" title="Delete"> </i></button>
                            {{Form::close()}}
                            @endla_access


                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- modal start -->
    <div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"> &times; </span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Add Video</h4>
                </div>
                {!! Form::open(['action' => 'Admin\Save_Refugee\VideosController@store', 'files'=>true, 'id' => 'video-add-form']) !!}

                <div class="modal-body">
                    <div class="box-body">

                        <div class="row">

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="image">@lang('messages.Video Thumbnail Image')<span
                                                class="la-required">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <div style="margin-top: 0" class="media">
                                        <div class="media-body image">
                                            <input type="file" id="" class="form-control image" name="image"
                                                   accept="image/png,image/jpeg,image/jpg" required>
                                         <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                          aria-hidden="true"></i>
                                             Type: jpeg,jpg,png. Size:  375X257px
                                         </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="video_link">@lang('messages.Video Link') <span
                                                class="la-required">*</span>:</label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Enter a valid URL
                                         </span>
                                    <input type="url" class="form-control "
                                           name="video_link"
                                           placeholder="@lang('messages.Enter Video Link URL')"
                                           required value="{{old('video_link')}}">
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.Close')</button>
                    {{--<button type="button" class="btn btn-success" onclick="add_lan()">@lang('messages.Save')</button>--}}
                    {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- modal end -->

    <!-- Edit modal start -->
    <div class="modal fade" id="video-edit-modal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"> &times; </span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Edit Video</h4>
                </div>

                {{ Form::open( array('url' => '', 'method'=>'PATCH', 'files'=>true, 'id' => 'video-edit-form'))}}

                <div class="modal-body">
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="image">@lang('messages.Video Thumbnail Image')<span
                                            class="la-required">*</span></label>

                                <div class="media-body">
                                    <input type="file" id="" class="form-control image" name="image"
                                           accept="image/png,image/jpeg,image/jpg">
                                         <span class="suggestion_text"><i class="fa fa-hand-o-right"
                                                                          aria-hidden="true"></i>
                                             Type: jpeg,jpg,png. Size:  375X257px
                                         </span>
                                </div>

                                <div class="media-left" id="slider_img" style="margin-left:15px; ">

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="video_link">@lang('messages.Video Link') <span
                                            class="la-required">*</span>:</label><span class="suggestion_text"><i
                                            class="fa fa-hand-o-right" aria-hidden="true"> </i>  Enter a valid URL
                                         </span>
                                <input type="url" class="form-control "
                                       name="video_link" id="video_link_edit"
                                       placeholder="@lang('messages.Enter Video Link URL')"
                                       required value="{{old('video_link')}}">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.Close')</button>
                    {{--<button type="button" class="btn btn-success" onclick="add_lan()">@lang('messages.Save')</button>--}}
                    {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!--Edit  modal end -->

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
    $(function () {
        $('#example1').DataTable({
            responsive: false,
            stateSave: true,
            columnDefs: [{orderable: false, targets: [-1]}]
        });
        $("#video-add-form").validate({});
        $("#video-edit-form").validate({});
    });

    function getVideo(val) {
        var video_id = val;
        /*Edit  modal value set*/

        $.ajax({
            type: "POST",
            url: "{{url('admin/get-video')}}",
            data: {id: video_id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (data) {
                var img_url = $('#img_' + video_id).val();
                var v_id = data.id;

                $('#slider_img').html("<img src='" + img_url + "'  style='margin: 0px 10px  auto; height: 50px; width: 100px;'  />");
                $('#video_link_edit').val(data.video_link);
                $('#video-edit-form').attr('action', "{{url('/admin/sr_video')}}" + '/' + v_id);


            }
        });
    }

</script>
@endpush
