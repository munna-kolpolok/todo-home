@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/food_items') }}">@lang('messages.Food Item')</a> :
@endsection
@section("contentheader_description", $food_item->$view_col)
@section("section", trans("messages.Food Items"))
@section("section_url", url(config('laraadmin.adminRoute') . '/food_items'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Food Items Edit : ".$food_item->$view_col)

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
			
				{!! Form::model($food_item, ['route' => [config('laraadmin.adminRoute') . '.food_items.update', $food_item->id ], 'method'=>'PUT', 'id' => 'food_item-edit-form']) !!}
					{{--@ la_form($module) --}}
					
					
					@la_edit_input($module, 'name')
					@la_edit_input($module, 'bn_name')
					@la_edit_input($module, 'price')
					@la_edit_input($module, 'unit_id')
					@la_edit_input($module, 'food_menu')
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/food_items') }}">@lang('messages.Cancel')</a>
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
	$("#food_item-edit-form").validate({
		
	});
});
</script>
@endpush
