@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/inboxes') }}">@lang('messages.Inbox')</a>
@endsection
@section("contentheader_description")
@section("section", trans("messages.Inbox"))
@section("section_url", url(config('laraadmin.adminRoute') . '/inboxes'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Inbox Edit")

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
	$sector_options='<option value="">Select Sector</option>';
	$payment_method_options='';
	$currency_options='';
	foreach($sectors as $sector){ 
		if($sector->id==$inbox->sector_id){
			$sector_options.='<option value="'.$sector->id.'"  selected="selected">'.$sector->name.'</option>';
		}else{
			$sector_options.='<option value="'.$sector->id.'">'.$sector->name.'</option>';
		}
	}

	foreach($payment_methods as $payment_method){ 
		if($payment_method->id==$inbox->payment_method_id){
			$payment_method_options.='<option value="'.$payment_method->id.'"  selected="selected">'.$payment_method->name.'</option>';
		}else{
			$payment_method_options.='<option value="'.$payment_method->id.'">'.$payment_method->name.'</option>';
		}
	}

	foreach($currencies as $currency){ 
		if($currency->id==$inbox->currency_id){
			$currency_options.='<option value="'.$currency->id.'"  selected="selected">'.$currency->currency_code.'</option>';
		}else{
			$currency_options.='<option value="'.$currency->id.'">'.$currency->currency_code.'</option>';
		}
	}

	
?>
<div class="box box-success">
	<div class="box-header">
	</div>
	{!! Form::open(['route' => [config('laraadmin.adminRoute') . '.inboxes.update', $inbox->id ], 'method'=>'PUT', 'id' => 'inboxes-edit-form']) !!}
	<div class="box-body">
		<div class="row">
			@if($inbox->user_id>0)
			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Donor')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<input class="form-control" type="text" name="" value="{{ $inbox->user->name or null}}" readonly="">
	        	</div>
			</div>

			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Donor')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<input type="hidden" name="user_id" value="{{ $inbox->user_id }}">
					<input class="form-control" type="text" name="" value="{{ $inbox->user->email or null}}" readonly="">
	        	</div>
			</div>
			@else
			<div class="col-md-1">
				<div class="form-group">
					<label for="item_id">@lang('messages.Donor')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-11">
				<div class="form-group">
					<select class="form-control" rel="select2" required="1" name="user_id" id="user_id">
						<option value="">Select Donor</option>
						@foreach($donors as $user)
							<option value="{{ $user->id }}">{{ $user->email }} - {{ $user->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			@endif

			
		</div>

		<div class="row">
			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Amount')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
		        	<input class="form-control" required="1" type="number" name="amount" id="amount" min="1" placeholder="@lang('messages.Enter Amount In English')" value="{{ $inbox->amount or null}}">
	        	</div>
			</div>

			<div class="col-md-1">
				<div class="form-group">
					<label for="item_id">@lang('messages.Currency')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<select class="form-control" rel="select2" required="1" name="currency_id" id="currency_id">
						<?php echo $currency_options;?>
					</select>
				</div>
			</div>

		</div>

		


		<div class="row">
			<div class="col-md-1">
				<div class="form-group">
					<label for="item_id">@lang('messages.Sector')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<select class="form-control" rel="select2" name="sector_id" id="sector_id">
						<?php echo $sector_options;?>
					</select>
				</div>
			</div> 

			<div class="col-md-1">
				<div class="form-group">
					<label for="item_id">@lang('messages.Payment Channel')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<select class="form-control" rel="select2" required="1" name="payment_method_id" id="payment_method_id">
						<?php echo $payment_method_options;?>
					</select>
				</div>
			</div>
			

			
		</div>

		<div class="row">
			<div class="col-md-1">
				<div class="form-group">
					<label for="item_id">@lang('messages.Payer Account No')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<input class="form-control" type="text" name="payer_account_no" id="payer_account_no" placeholder="@lang('messages.Enter Payer Account No')" value="{{ $inbox->payer_account_no or null}}">
				</div>
			</div> 

			<div class="col-md-1">
				<div class="form-group">
					<label for="item_id">@lang('messages.Payee Account No')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<input class="form-control" type="text" name="payee_account_no" id="payee_account_no" placeholder="@lang('messages.Enter Payee Account No')" value="{{ $inbox->payee_account_no or null}}">
				</div>
			</div>
			
		</div>



		<div class="row">
			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Donor Message')</label>
				</div>
			</div>
			<div class="col-md-11">
				<div class="form-group">
		        <textarea class="form-control" name="donor_message" id="donor_message" placeholder="@lang('messages.Enter Your Message')" readonly="">{{ $inbox->donor_message or null }}</textarea>
	        	</div>
			</div>
		</div>


		<div>
			@la_access("Inboxes", "edit")
			<a href="#" class="btn btn-success" onclick="update()">@lang('messages.Update')</a>
			@endla_access
			<a href="{{ url(config('laraadmin.adminRoute') . '/inboxes') }}" class="btn btn-default">@lang('messages.Cancel')</a>
		</div>
		{!! Form::close() !!}

	</div>

	
</div>


@endsection

@push('scripts')
<script type="text/javascript">
	$(function () {
		$("#inboxes-edit-form").validate({
			
		});
	});
	function update()
	{
		//alert('ok');
		$( "#inboxes-edit-form" ).submit();
	}		
			
</script>
@endpush
