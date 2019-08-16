@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/gallery_categories') }}">@lang('messages.Gallery Category')</a> :
@endsection
@section("contentheader_description", $gallery_category->$view_col)
@section("section", trans("messages.Gallery Categories"))
@section("section_url", url(config('laraadmin.adminRoute') . '/gallery_categories'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Gallery Categories Edit : ".$gallery_category->$view_col)

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
			
				{!! Form::model($gallery_category, ['route' => [config('laraadmin.adminRoute') . '.gallery_categories.update', $gallery_category->id ], 'method'=>'PUT', 'id' => 'gallery_category-edit-form']) !!}
					{{--@ la_form($module) --}}
					
					
					@la_edit_input($module, 'website_id')
					@la_edit_input($module, 'name')
					@la_edit_input($module, 'bn_name')
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/gallery_categories') }}">@lang('messages.Cancel')</a>
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
	$("#gallery_category-edit-form").validate({
		
	});
});
</script>
@endpush
