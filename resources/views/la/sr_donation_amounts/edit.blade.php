@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/sr_donation_amounts') }}">@lang('messages.Sr Donation Amount')</a> :
@endsection
@section("contentheader_description", $sr_donation_amount->$view_col)
@section("section", trans("messages.Sr Donation Amounts"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sr_donation_amounts'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Sr Donation Amounts Edit : ".$sr_donation_amount->$view_col)

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
			
				{!! Form::model($sr_donation_amount, ['route' => [config('laraadmin.adminRoute') . '.sr_donation_amounts.update', $sr_donation_amount->id ], 'method'=>'PUT', 'id' => 'sr_donation_amount-edit-form']) !!}
					{{--@ la_form($module) --}}
					
					
					@la_edit_input($module, 'amount')
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/sr_donation_amounts') }}">@lang('messages.Cancel')</a>
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
	$("#sr_donation_amount-edit-form").validate({
		
	});
});
</script>
@endpush
