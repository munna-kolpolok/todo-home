@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/person_nos') }}">@lang('messages.Person No')</a> :
@endsection
@section("contentheader_description", $person_no->$view_col)
@section("section", trans("messages.Person Nos"))
@section("section_url", url(config('laraadmin.adminRoute') . '/person_nos'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Person Nos Edit : ".$person_no->$view_col)

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
			
				{!! Form::model($person_no, ['route' => [config('laraadmin.adminRoute') . '.person_nos.update', $person_no->id ], 'method'=>'PUT', 'id' => 'person_no-edit-form']) !!}
					{{--@ la_form($module) --}}
					
					
					@la_edit_input($module, 'person_no')
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/person_nos') }}">@lang('messages.Cancel')</a>
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
	$("#person_no-edit-form").validate({
		
	});
});
</script>
@endpush
