@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/meals') }}">@lang('messages.Meal')</a> :
@endsection
@section("contentheader_description", $meal->$view_col)
@section("section", trans("messages.Meals"))
@section("section_url", url(config('laraadmin.adminRoute') . '/meals'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Meals Edit : ".$meal->$view_col)

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
			
				{!! Form::model($meal, ['route' => [config('laraadmin.adminRoute') . '.meals.update', $meal->id ], 'method'=>'PUT', 'id' => 'meal-edit-form']) !!}
					{{--@ la_form($module) --}}
					
					
					@la_edit_input($module, 'name')
					@la_edit_input($module, 'bn_name')
					@la_edit_input($module, 'is_menu')
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/meals') }}">@lang('messages.Cancel')</a>
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
	$("#meal-edit-form").validate({
		
	});
});
</script>
@endpush
