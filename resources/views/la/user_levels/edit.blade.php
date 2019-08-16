@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/user_levels') }}">@lang('messages.User Level')</a> :
@endsection
@section("contentheader_description", $user_level->$view_col)
@section("section", trans("messages.User Levels"))
@section("section_url", url(config('laraadmin.adminRoute') . '/user_levels'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "User Levels Edit : ".$user_level->$view_col)

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
			
				{!! Form::model($user_level, ['route' => [config('laraadmin.adminRoute') . '.user_levels.update', $user_level->id ], 'method'=>'PUT', 'id' => 'user_level-edit-form']) !!}
					{{--@ la_form($module) --}}
					
					
					@la_edit_input($module, 'name')
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <button class="btn btn-default"><a href="{{ url(config('laraadmin.adminRoute') . '/user_levels') }}">@lang('messages.Cancel')</a></button>
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
	$("#user_level-edit-form").validate({
		
	});
});
</script>
@endpush
