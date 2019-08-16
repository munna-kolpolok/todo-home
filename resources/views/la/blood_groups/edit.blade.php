@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/blood_groups') }}">@lang('messages.Blood Group')</a> :
@endsection
@section("contentheader_description", $blood_group->$view_col)
@section("section", trans("messages.Blood Groups"))
@section("section_url", url(config('laraadmin.adminRoute') . '/blood_groups'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Blood Groups Edit : ".$blood_group->$view_col)

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
			
				{!! Form::model($blood_group, ['route' => [config('laraadmin.adminRoute') . '.blood_groups.update', $blood_group->id ], 'method'=>'PUT', 'id' => 'blood_group-edit-form']) !!}
					{{--@ la_form($module) --}}
					
					
					@la_edit_input($module, 'name')
					@la_edit_input($module, 'bn_name')
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/blood_groups') }}">@lang('messages.Cancel')</a>
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
	$("#blood_group-edit-form").validate({
		
	});
});
</script>
@endpush
