@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/sr_projects') }}">@lang('messages.Project')</a> :
@endsection
@section("section", trans("messages.Project"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sr_projects'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", trans("messages.Edit Project"))

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


    @if(session()->has('seccess_msg'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{ session()->get('seccess_msg') }}</strong>
        </div>
    @endif

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
        {{ Form::open( array('url' => config('laraadmin.adminRoute').'/sr_projects_tranlation/'.$project_transtaltions->id, 'method'=>'PATCH',
           'id' => 'project-lan-edit-form'))}}

        <div class="box-body">
            <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">@lang("messages.Language")<span
                                            class="la-required"> * </span>:</label>

                                <input type="text" class="form-control " name="local" value="{{$project_transtaltions->project_language->name or null}}" disabled>
                                <input type="hidden" id="" name="id" value="{{$project_transtaltions->id}}">

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">@lang("messages.Project Name")<span
                                            class="la-required"> * </span>:</label>

                                <input type="text" class="form-control " id="name"
                                       placeholder="@lang("messages.Enter project Name")" value="{{$project_transtaltions->name or null}}" name="name"
                                       required="1">

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">@lang("messages.Project Title")<span
                                            class="la-required"> * </span>:</label>

                                <input type="text" class="form-control " id="title"
                                       placeholder="@lang("messages.Enter Project Title")" name="title"
                                       required="1" value="{{$project_transtaltions->title or null}}">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subtitle">@lang("messages.Project Sub-Title")<span
                                            class="la-required"> * </span>:</label>

                                <input type="text" class="form-control " id="subtitle"
                                       placeholder="@lang("messages.Enter Project Sub-Title")" name="subtitle"
                                       required="1" value="{{$project_transtaltions->subtitle or null}}">

                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="description">@lang('messages.Project Description') <span
                                    class="la-required">*</span></label>
                                <textarea type="text" class="form-control "
                                          name="description"
                                          placeholder="@lang('messages.Enter Project Description')"
                                          required rows="5">{{$project_transtaltions->description or null}}</textarea>

                    </div>
                <div class="row" id="">
                    <div class="col-md-12">
                        <div class="form-group" style="text-align: center; padding-top: 10px;">
                            {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-warning']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute') .'/sr_projects') }}">@lang('messages.Cancel')</a>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}

            </div>

        </div>
    </div>


@endsection
@push('styles')

@endpush

@push('scripts')
<script type="text/javascript">
    $(function () {
        $("#project-lan-edit-form").validate({});

    });

</script>
@endpush
