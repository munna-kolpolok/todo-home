@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/religions') }}">@lang('messages.Religion')</a> :
@endsection
@section("contentheader_description", $religion->$view_col)
@section("section", trans("messages.Religions"))
@section("section_url", url(config('laraadmin.adminRoute') . '/religions'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Religions Edit : ".$religion->$view_col)

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
			
				{!! Form::model($religion, ['route' => [config('laraadmin.adminRoute') . '.religions.update', $religion->id ], 'method'=>'PUT', 'id' => 'religion-edit-form']) !!}
					{{--@ la_form($module) --}}
					
					
					@la_edit_input($module, 'religion_name')
					@la_edit_input($module, 'religion_bn_name')
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/religions') }}">@lang('messages.Cancel')</a>
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
	$("#religion-edit-form").validate({
		
	});
});
</script>
@endpush
