@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/subscribers') }}">@lang('messages.Subscriber')</a> :
@endsection
@section("contentheader_description", $subscriber->$view_col)
@section("section", trans("messages.Subscribers"))
@section("section_url", url(config('laraadmin.adminRoute') . '/subscribers'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Subscribers Edit : ".$subscriber->$view_col)

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
			
				{!! Form::model($subscriber, ['route' => [config('laraadmin.adminRoute') . '.subscribers.update', $subscriber->id ], 'method'=>'PUT', 'id' => 'subscriber-edit-form']) !!}
					{{--@ la_form($module) --}}
					
					
					@la_edit_input($module, 'email')
					@la_edit_input($module, 'website_id')
					@la_edit_input($module, 'is_verified')
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/subscribers') }}">@lang('messages.Cancel')</a>
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
	$("#subscriber-edit-form").validate({
		
	});
});
</script>
@endpush
