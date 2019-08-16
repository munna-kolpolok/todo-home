@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/classes') }}">@lang('messages.Class')</a> :
@endsection
@section("contentheader_description", $class->$view_col)
@section("section", trans("messages.Classes"))
@section("section_url", url(config('laraadmin.adminRoute') . '/classes'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Classes Edit : ".$class->$view_col)

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
			
				{!! Form::model($class, ['route' => [config('laraadmin.adminRoute') . '.classes.update', $class->id ], 'method'=>'PUT', 'id' => 'class-edit-form']) !!}
					{{--@ la_form($module) --}}
					
					
					@la_edit_input($module, 'class_name')
					@la_edit_input($module, 'class_bn_name')
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <button class="btn btn-default"><a href="{{ url(config('laraadmin.adminRoute') . '/classes') }}">@lang('messages.Cancel')</a></button>
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
	$("#class-edit-form").validate({
		
	});
});
</script>
@endpush
