@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/categories') }}">@lang('messages.Category')</a> :
@endsection
@section("contentheader_description", $category->$view_col)
@section("section", trans("messages.Categories"))
@section("section_url", url(config('laraadmin.adminRoute') . '/categories'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Categories Edit : ".$category->$view_col)

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
	{!! Form::open(['route' => [config('laraadmin.adminRoute') . '.inventory.store_receives.update', $receive_info->id ], 'method'=>'PUT', 'id' => 'store_receive-edit-form']) !!}
	<div class="box-body">
		<div class="row">
			
			
				
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <button class="btn btn-default"><a href="{{ url(config('laraadmin.adminRoute') . '/categories') }}">@lang('messages.Cancel')</a></button>
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
	$("#category-edit-form").validate({
		
	});
});
</script>
@endpush
