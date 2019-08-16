@extends("la.layouts.app")

@section("contentheader_title", trans("messages.PayPal"))
@section("contentheader_description", trans("messages.Payment Details"))
@section("section", trans("messages.PayPal"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Payment Details"))

@section("headerElems")

@endsection

@section("main-content")

	@if (count($errors) > 0)
		<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<div class="box box-success">
		<!--<div class="box-header"></div>-->
		<div class="box-body">
			<div>
				<h3>Paypal Payment Info</h3>
				<div class="row">
					<div class="col-md-6">
						<table class="table table-hover">
							<tr>
								<th>@lang('messages.Payer First Name')</th>
								<td>{{ $payment->payer_first_name or null }}</td>
							</tr>
							<tr>
								<th>@lang('messages.Payer Last Name')</th>
								<td>{{ $payment->payer_last_name or null }}</td>
							</tr>
							<tr>
								<th>@lang('messages.Email')</th>
								<td>{{ $payment->payer_email or null }}</td>
							</tr>
							<tr>
								<th>@lang('messages.Payer Id')</th>
								<td>{{  $payment->payer_id or null }}</td>
							</tr>
							<tr>
								<th>@lang('messages.Payer Country Code')</th>
								<td>{{ $payment->payer_country_code or null }}</td>
							</tr>
							<tr>
								<th>@lang('messages.Payer Status')</th>
								<td>{{  $payment->payer_status or null }}</td>
							</tr>
							<tr>
								<th>@lang('messages.Payee Email')</th>
								<td>{{ $payment->payee_email or null }}</td>
							</tr>
							<tr>
								<th>@lang('messages.Payee Merchant Id')</th>
								<td>{{ $payment->payee_merchant_id or null }}</td>
							</tr>
							<tr>
								<th>@lang('messages.State')</th>
								<td>{{ $payment->state or null }}</td>
							</tr>
						</table>
					</div>

					<div class="col-md-6">
						<table class="table table-hover">
							<tr>
								<th>@lang('messages.Payment Date')</th>
								<td><?php
                                    if(isset($payment->payment_date)){
                                        echo App\Helpers\CommonHelper::showDateTimeFormat($payment->payment_date);
                                    }?>
								</td>
							</tr>
							<tr>
								<th>@lang('messages.Currency')</th>
								<td>{{  $payment->currency or null }}</td>
							</tr>
							<tr>
								<th>@lang('messages.Amount')</th>
								<td>{{ $payment->amount or null }}</td>
							</tr>
							<tr>
								<th>@lang('messages.Transaction Fee')</th>
								<td>{{ $payment->transaction_fee or null }}</td>
							</tr>
							<tr>
								<th>@lang('messages.Payment ID')</th>
								<td>{{ $payment->payment_id or null }}</td>
							</tr>
							<tr>
								<th>@lang('messages.Payment Method')</th>
								<td>{{ $payment->payer_payment_method or null }}</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>


@endsection

@push('scripts')
<script>

</script>
@endpush
