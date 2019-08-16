@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/scholarships') }}">@lang('messages.Scholarship Donate')</a>
@endsection
@section("contentheader_description")
@section("section", trans("messages.Scholarship Donate"))
@section("section_url", url(config('laraadmin.adminRoute') . '/scholarships'))
@section("sub_section", trans("messages.Donate"))

@section("htmlheader_title", "Scholarship Donate")

@section("main-content")

@if(session()->has('message'))
	<div class="alert alert-success alert-dismissable">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <strong>{{ session()->get('message') }}</strong>
	</div>
@endif

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
	$currency_options=Null;
	foreach($currencies as $currency){ 
		$currency_options.='<option value="'.$currency->id.'">'.$currency->currency_name. ' ('.$currency->currency_code.')'.'</option>';
	}
?>

<div class="box box-success">
	

	{{ Form::open(array('url' => 'admin/scholarships/donation_save', 'id' => 'donation-form')) }}
	<div class="box-body">
		
	<div class="col-md-9">
		<input type="hidden" name="scholarship_id" value="{{ $scholarship->id }}">
		<div class="row">
			<div class="col-md-1">
				<div class="form-group">
					<label for="receive_voucher_no">@lang('messages.Date')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<div class='input-group date' id='datetimepicker1'>
		                <input type='text' class="form-control" name="donate_date" id="donate_date" required="1" placeholder="@lang('messages.Enter Date')"/>
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>
	            </div>
			</div>

			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Method')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
		        	<select class="form-control" required="1" rel="select2" name="payment_method" id="payment_method">
						<option value="1">Manual</option>
						<option value="2">Paypal</option>
						<option value="3">Sslcommerz</option>
					</select>
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
		        	<input class="form-control" required="1" type="number" name="amount" id="amount" min="1" placeholder="@lang('messages.Enter Amount')">
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
					<label for="item_id">@lang('messages.Donor')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<select class="form-control" rel="select2" required="1" name="user_id" id="user_id">
						@foreach($donors as $user)
							<option value="{{ $user->id }}">{{ $user->email }}</option>
						@endforeach
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

			{{-- 
			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Type')<span class="la-required">*</span></label>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
		        	<select class="form-control" required="1" rel="select2" name="type" id="type">
						<option value="1">Donate</option>
						<option value="2">Return</option>
					</select>
	        	</div>
			</div>
			--}}

			
		</div>

		<!-- <div class="row">
			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Slip No')</label>
				</div>
			</div>
			<div class="col-md-11">
				<div class="form-group">
		        	<input class="form-control" type="text" name="slip_no" id="slip_no" maxlength="256"placeholder="@lang('messages.Enter Slip No')">
	        	</div>
			</div>
		</div> -->
		
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

		<div style="text-align: center;">
			@la_access("Scholarships", "edit")
			<a href="#" class="btn btn-success" onclick="save()">@lang('messages.Save')</a>
			@endla_access
			<a href="{{ url(config('laraadmin.adminRoute') . '/scholarships') }}" class="btn btn-default">@lang('messages.Cancel')</a>
		</div>
		{!! Form::close() !!}
		</div>

	<div class="col-md-3">

		<table class="table table-bordered">
			<tr>
				<td>@lang('messages.ID Card')</td>
				<td>{{ $scholarship->student->id_card or null}}</td>
			</tr>
			<tr>
				<td>@lang('messages.Name')</td>
				<td>{{ $scholarship->student->name or null}}</td>
			</tr>
			<tr>
				<td>@lang('messages.Year')</td>
				<td>{{ $scholarship->year or null }}</td>
			</tr>
			<tr>
				<td>@lang('messages.Scholarship Amount')</td>
				<td class="warning" align="right">{{ $scholarship->scholarship_amount or null }} TK</td>
			</tr>
			<tr>
				<td>@lang('messages.Donated Amount')</td>
				<td class="success" align="right">{{ $scholarship->donated_amount or null }} TK</td>
			</tr>
			<tr>
				<td>@lang('messages.Due')</td>
				<td class="danger" align="right">{{ $scholarship->due or null }} TK</td>
			</tr>
		</table>
	</div>

	</div>
	
	
</div>

<div class="box box-success">
<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
			<th>@lang('messages.Serial No.')</th>
			<th>@lang('messages.Donate Date')</th>
			<th>@lang('messages.Amount')</th>
			<th>@lang('messages.Currency')</th>
			<th>@lang('messages.Donor Email')</th>
			<th>@lang('messages.Donor Name')</th>
			<th>Method</th>
			<th>@lang('messages.Slip No')</th>
			<th>@lang('messages.Description')</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
			@foreach($values as $key=>$value)
			<tr>
				<td>{{ ++$key }}</td>
				<td>
					<?php 
					if(isset($value->donate_date)){
						echo App\Helpers\CommonHelper::showDateTimeFormat($value->donate_date);
					}?>
				</td>

				<td>{{ $value->amount or null}}</td>
				<td>{{ $value->currency->currency_code or null}}</td>

				<td>{{ $value->user->email or null}}</td>
				<td>{{ $value->user->name or null}}</td>

				<td>
					@if($value->payment_method==1) Manual @elseif($value->payment_method==2) Paypal @else Ssslcommerze @endif
				</td>
				<td>{{ $value->slip_no  or null}}</td>
				<td><pre>{{ $value->payment_description }}</pre></td>
				<td>
					@if($value->payment_method==1)
					{!! Form::open(['url' => [config('laraadmin.adminRoute').'/scholarships/donation_delete'],'method' => 'post','style'=>'display:inline']) !!}
					<input type="hidden" name="scholarship_donation_id" value="{{ $value->id }}">
					<button class="btn btn-danger btn-xs"  onclick="return confirm('Are you sure to delete this?')"><i class="fa fa-times"></i></button>
					{!! Form::close() !!}
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
		</table>
	</div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
	$(function () {
		$("#donation-form").validate({
			
		});
	});
	function save()
	{
		//alert('ok');
		$( "#donation-form" ).submit();
	}		
			
</script>
@endpush
