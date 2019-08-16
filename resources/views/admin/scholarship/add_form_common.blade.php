@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/inboxes') }}">@lang('messages.Scholarship')</a>
@endsection
@section("contentheader_description")
@section("section", trans("messages.Scholarship"))
@section("section_url", url(config('laraadmin.adminRoute') . '/inboxes'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", "Scholarship Add")

@section("main-content")
<style type="text/css">
	/*#save_div{
		display: none;
	}*/
</style>

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

	$student_options='<option value="">Select Students</option>';
	$year_options=Null;
	$currency_options=Null;
	foreach($students as $student){ 
		$student_options.='<option value="'.$student->id.'">'.$student->id_card.'</option>';
	}

	foreach($years as $year){ 
		$year_options.='<option value="'.$year.'">'.$year.'</option>';
	}

	foreach($currencies as $currency){ 
		if($currency->id==$info->currency_id)
		{
			$currency_options.='<option value="'.$currency->id.'" selected>'.$currency->currency_name. ' ('.$currency->currency_code.')'.'</option>';
		}
		else
		{
			$currency_options.='<option value="'.$currency->id.'">'.$currency->currency_name. ' ('.$currency->currency_code.')'.'</option>';
		}
		
	}
	
?>


<div class="box box-success">
	<div class="box-header">
	</div>
	{!! Form::open(['url' => config('laraadmin.adminRoute').'/c_scholarship_store', 'id' => 'scholarship-add-form']) !!}
	<input type="hidden" name="type" value="{{ $type }}">
	<input type="hidden" name="id" value="{{ $info->id }}">

	<div class="box-body">
		
		<div class="row">
			

			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Student')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<select class="form-control"  rel="select2" required="1" name="student_id" id="student_id" onchange="studentWiseDonorLoad(this.value)">
		        	<?php echo $student_options;?>
		        	</select>
	        	</div>
			</div>

			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Year')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<select class="form-control"  rel="select2" required="1" name="year" id="year">
		        	<?php echo $year_options;?>
		        	</select>
	        	</div>
			</div>
		</div>
		<div class="row">
			
			<div class="col-md-1">
				<div class="form-group">
					<label for="item_id">@lang('messages.Donor')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<input type="hidden" name="user_id" id="user_id">
				<div class="form-group">
					<input class="form-control" type="text" name="user_id_email" id="user_id_email" readonly="1">
				</div>
			</div>

			<div class="col-md-1">
				<div class="form-group">
					<label for="receive_voucher_no">@lang('messages.Donate Date')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<div class='input-group date' id='datetimepicker1'>
		                <input type='text' class="form-control" name="donate_date" id="donate_date"  placeholder="@lang('messages.Enter Date')" required="1" value="{{ App\Helpers\CommonHelper::showDateFormat(date('Y-m-d')) }}" />
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>
	            </div>
			</div>


		</div>

		
		
		<div class="row">			
			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Amount')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<?php 
					if($type==3)
					{
						$scholarship_due=$info->total_amount-$info->scholarship_amount; 
					}
					else
					{
						$scholarship_due=$info->amount-$info->scholarship_amount; 
					}
					?>
		        	<input class="form-control" required="1" type="number" name="amount" id="amount" min="1" placeholder="@lang('messages.Enter Amount')" value="{{ $scholarship_due }}" max="{{ $scholarship_due }}">
	        	</div>
			</div>

			<div class="col-md-1">
				<div class="form-group">
					<label for="item_id">@lang('messages.Currency')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					

					@if($type==1)
					<input type="hidden" name="currency_id" value="{{ $info->currency_id }}">
					<select class="form-control" rel="select2" disabled="1">
						<?php echo $currency_options;?>
					</select>
					@elseif($type==2)
						<input type="hidden" name="currency_id" value="{{ $currency_usd->id }}">
						<input class="form-control" type="text" value="{{ $currency_usd->currency_name }} ({{ $currency_usd->currency_code }})" readonly="1">
					@elseif($type==3)
						<input type="hidden" name="currency_id" value="{{ $currency_bdt->id }}">
						<input class="form-control" type="text" value="{{ $currency_usd->currency_name }} ({{ $currency_bdt->currency_code }})"readonly="1">
					@endif
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Payment Method')</label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<input type="hidden" name="payment_method" value="{{ $type }}">
		        	<select class="form-control" rel="select2" disabled="1">
						<option value="1" @if($type==1) selected @endif>Manual</option>
						<option value="2" @if($type==2) selected @endif>Paypal</option>
						<option value="3" @if($type==3) selected @endif>Sslcommerz</option>
					</select>
	        	</div>
			</div>

			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Slip No')</label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
		        	<input class="form-control" type="text" name="slip_no" id="slip_no" maxlength="256"placeholder="@lang('messages.Enter Slip No')">
	        	</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Desc')</label>
				</div>
			</div>
			<div class="col-md-11">
				<div class="form-group">
		        <textarea class="form-control" name="payment_description" id="payment_description" placeholder="@lang('messages.Enter Description')"></textarea>
	        	</div>
			</div>
		</div>
		

	<div id="save_div">
		<a href="#" class="btn btn-success" onclick="save()">@lang('messages.Save')</a>
		<a href="{{ url(config('laraadmin.adminRoute') . '/inboxes') }}" class="btn btn-default">@lang('messages.Cancel')</a>
	</div>
	{!! Form::close() !!}
</div>



@endsection

@push('scripts')
<script type="text/javascript">
	$(function () {
		$("#scholarship-add-form").validate({
			
		});

	});


	function save()
	{
		$( "#scholarship-add-form" ).submit();
	}	

	function studentWiseDonorLoad(student_id)
	{
		var url="{{ url(config('laraadmin.adminRoute') .'/studentWiseDonorLoad') }}";
		$.post(url,{'student_id':student_id},function( data ) {
			$("#user_id").val(data.id)
			$("#user_id_email").val(data.email)
		});
	}
	
</script>
@endpush
