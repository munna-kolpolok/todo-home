@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/latest_news') }}">@lang('messages.Latest News')</a> :
@endsection
@section("contentheader_description", $latest_news->$view_col)
@section("section", trans("messages.Latest News"))
@section("section_url", url(config('laraadmin.adminRoute') . '/latest_news'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Latest News Edit : ".$latest_news->$view_col)

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

                {!! Form::model($latest_news, ['route' => [config('laraadmin.adminRoute') . '.latest_news.update', $latest_news->id ], 'method'=>'PUT', 'id' => 'latest_news-edit-form']) !!}
                {{--@ la_form($module) --}}


                @la_edit_input($module, 'website_id')
                @la_edit_input($module, 'news')
                @la_edit_input($module, 'bn_news')
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="status">Status <span
                                    class="la-required">*</span></label>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control select2" name="status" id="status">
                            <option @if($latest_news->status == 1) selected @endif value="1">Active</option>
                            <option @if($latest_news->status == 0) selected @endif value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a
                                class="btn btn-default"
                                href="{{ url(config('laraadmin.adminRoute') . '/latest_news') }}">@lang('messages.Cancel')</a>
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
        $("#latest_news-edit-form").validate({});
    });
</script>
@endpush
