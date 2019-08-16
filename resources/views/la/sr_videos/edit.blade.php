@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/sr_videos') }}">@lang('messages.Sr Video')</a> :
@endsection
@section("contentheader_description", $sr_video->$view_col)
@section("section", trans("messages.Sr Videos"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sr_videos'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Sr Videos Edit : ".$sr_video->$view_col)

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
			
				{!! Form::model($sr_video, ['route' => [config('laraadmin.adminRoute') . '.sr_videos.update', $sr_video->id ], 'method'=>'PUT', 'id' => 'sr_video-edit-form']) !!}
					{{--@ la_form($module) --}}
					
					
					@la_edit_input($module, 'video_link')
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/sr_videos') }}">@lang('messages.Cancel')</a>
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
	$("#sr_video-edit-form").validate({
		
	});
});
</script>
@endpush
