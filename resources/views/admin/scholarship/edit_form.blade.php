@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/scholarships') }}">@lang('messages.Scholarship')</a>
@endsection
@section("contentheader_description")
@section("section", trans("messages.Scholarship"))
@section("section_url", url(config('laraadmin.adminRoute') . '/scholarships'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Scholarship Edit")

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

<?php
	$donor_options='<option value="">'.Lang::get('messages.Select Donor').'</option>';
	
	foreach($donors as $donor){ 
		if($donor->id==$scholarship->donor_id){
			$donor_options.='<option value="'.$donor->id.'"  selected="selected">'.$donor->email.'-'.$donor->name.'</option>';
		}else{
			$donor_options.='<option value="'.$donor->id.'">'.$donor->email.'-'.$donor->name.'</option>';
		}
		
	}
?>
<div class="box box-success">
	<div class="box-header">
	</div>
	{!! Form::open(['route' => [config('laraadmin.adminRoute') . '.scholarships.update', $scholarship->id ], 'method'=>'PUT', 'id' => 'scholarships-edit-form']) !!}
	<div class="box-body">
		<div class="row">
			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Student')</label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<input class="form-control" type="text" name="" value="{{ $scholarship->student->name or null}}" readonly="">
	        	</div>
			</div>

			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">ID Card</label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<input class="form-control" type="text" name="" value="{{ $scholarship->student->id_card or null}}" readonly="">
	        	</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Year')</label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<input class="form-control" type="text" name="" value="{{ $scholarship->year or null}}" readonly="">
	        	</div>
			</div>
			<div class="col-md-1">
				<div class="form-group">
					<label for="receive_voucher_no">Amount<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<input class="form-control" type="number" name="scholarship_amount" value="{{ $scholarship->scholarship_amount or null}}">
	            </div>
			</div>
		</div>


		<div>
			@la_access("Scholarships", "edit")
			<a href="#" class="btn btn-success" onclick="update()">@lang('messages.Update')</a>
			@endla_access
			<a href="{{ url(config('laraadmin.adminRoute') . '/scholarships') }}" class="btn btn-default">@lang('messages.Cancel')</a>
		</div>
		{!! Form::close() !!}

	</div>

	
</div>


@endsection

@push('scripts')
<script type="text/javascript">
	$(function () {
		$("#scholarships-edit-form").validate({
			
		});
	});
	function update()
	{
		//alert('ok');
		$( "#scholarships-edit-form" ).submit();
	}		
			
</script>
@endpush
