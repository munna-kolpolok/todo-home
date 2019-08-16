@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/genders') }}">@lang('messages.Gender')</a> :
@endsection
@section("contentheader_description", $gender->$view_col)
@section("section", trans("messages.Genders"))
@section("section_url", url(config('laraadmin.adminRoute') . '/genders'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Genders Edit : ".$gender->$view_col)

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
			
				{!! Form::model($gender, ['route' => [config('laraadmin.adminRoute') . '.genders.update', $gender->id ], 'method'=>'PUT', 'id' => 'gender-edit-form']) !!}
					{{--@ la_form($module) --}}
					
					
					@la_edit_input($module, 'gender_name')
					@la_edit_input($module, 'gender_bn_name')
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/genders') }}">@lang('messages.Cancel')</a>
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
	$("#gender-edit-form").validate({
		
	});
});
</script>
@endpush
