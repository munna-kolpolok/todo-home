@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/faqs') }}">@lang('messages.FAQ')</a> :
@endsection
@section("contentheader_description", $faq->$view_col)
@section("section", trans("messages.FAQs"))
@section("section_url", url(config('laraadmin.adminRoute') . '/faqs'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "FAQs Edit : ".$faq->$view_col)

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
			
				{!! Form::model($faq, ['route' => [config('laraadmin.adminRoute') . '.faqs.update', $faq->id ], 'method'=>'PUT', 'id' => 'faq-edit-form']) !!}
					{{--@ la_form($module) --}}
					
					
					@la_edit_input($module, 'website_id')
					@la_edit_input($module, 'question')
					@la_edit_input($module, 'bn_question')
					@la_edit_input($module, 'answer')
					@la_edit_input($module, 'bn_answer')
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/faqs') }}">@lang('messages.Cancel')</a>
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
	$("#faq-edit-form").validate({
		
	});
});
</script>
@endpush
