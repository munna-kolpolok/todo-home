@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Setting Languages"))
@section("contentheader_description", trans("messages.Setting Languages listing"))
@section("section", trans("messages.Setting Languages"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Setting Languages listing"))

@section("headerElems")
    @la_access("setting_languages", "create")

    <a {{--data-toggle="modal" data-target="#LangModal" --}}href="{{ url(config('laraadmin.adminRoute') . '/setting_languages/create') }}"
       class="btn btn-success btn-sm pull-right"> @lang("messages.Add Setting in Language")</a>
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
                    <th>Language</th>
                    <th>Mission Title</th>
                    <th>Vision Title</th>
                    <th>Intro Title</th>
                    <th>Home Video Title</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($site_setting_trns as $key=>$value)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$value->language->name or null}}</td>
                        <td>{{$value->mission_title or null}}</td>
                        <td>{{$value->vision_title or null}}</td>
                        <td>{{$value->intro_title or null}}</td>
                        <td>{{$value->home_video_title or null}}</td>
                        <td style="min-width: 80px!important;">
                            <a href="{{url(config('laraadmin.adminRoute').'/setting_languages/'.$value->id.'/edit')}}"
                                    class="btn btn-success btn-xs" data-toggle="tooltip" title="View Details"
                                    style="display:inline;padding:2px 5px 3px 5px;"> <i class="fa fa-eye">  </i></a>
                            @la_access("setting_languages", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/setting_languages/'.$value->id.'/edit')}}"
                                    class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                                    style="display:inline;padding:2px 5px 3px 5px;"> <i class="fa fa-edit">  </i></a>
                            @endla_access
                            @la_access("setting_languages", "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.setting_languages.destroy', $value->id], 'method' => 'delete', 'style'=>'display:inline'])}}
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

    <!-- Lang modal start -->
    <div class="modal fade" id="LangModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"> &times; </span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Select Language</h4>
                </div>
                {{--{!! Form::open(['action' => 'Admin\Save_Refugee\SiteSettingTranlationsController@createLang', 'id' => 'project-lan-form']) !!}--}}

                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{--<label for="lang">@lang("messages.Language")<span
                                                class="la-required"> * </span>:</label>--}}

                                    <select class="form-control select2" rel="select2" required="1" name="lang"
                                            id="">
                                        @foreach($languages as $language)
                                            {{--<option value="en">@lang("messages.English")</option>--}}
                                            <option value="{{ $language->code }}">{{ $language->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.Close')</button>
                    {{--<button type="button" class="btn btn-success" onclick="add_lan()">@lang('messages.Save')</button>--}}
                    {!! Form::submit( Lang::get('messages.Add Content'), ['class'=>'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- modal end -->

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
    });
</script>
@endpush

