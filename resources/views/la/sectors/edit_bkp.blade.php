@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/sectors') }}">@lang('messages.Sector')</a> :
@endsection
@section("contentheader_description", $sector->$view_col)
@section("section", trans("messages.Sectors"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sectors'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Sectors Edit : ".$sector->$view_col)

@section("main-content")

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
        <div class="box-header">

        </div>
        <div class="box-body">
            <div class="row">

                {!! Form::model($sector, ['route' => [config('laraadmin.adminRoute') . '.sectors.update', $sector->id ], 'method'=>'PUT', 'id' => 'sector-edit-form']) !!}
                {{--@ la_form($module) --}}


                @la_edit_input($module, 'website_id')
                @la_edit_input($module, 'name')
                @la_edit_input($module, 'bn_name')
                @la_edit_input($module, 'project_id')
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="status">Status <span
                                    class="la-required">*</span></label>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control select2" name="is_show" id="is_show">
                            <option @if($sector->is_show == 1) selected @endif value="1">Active</option>
                            <option @if($sector->is_show == 0) selected @endif value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a
                                class="btn btn-default"
                                href="{{ url(config('laraadmin.adminRoute') . '/sectors') }}">@lang('messages.Cancel')</a>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(function () {
        $("#sector-edit-form").validate({});
    });
</script>
@endpush
