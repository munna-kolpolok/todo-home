@extends('la.layouts.app')

@section('htmlheader_title')
	Order Details
@endsection



@section('main-content')
<div class="box box-success">
	<!-- <div class="box-header"></div> -->

	<div class="col-md-6">
		<table class="table table-hover">
			<caption style="text-align: center;font-weight: bold">@lang('messages.Delivery Information')</caption>
			<tr>
				<th>@lang('messages.Name')</th>
				<td>{{ $order->shipping_name or null }}</td>
			</tr>
			<tr>
				<th>@lang('messages.Phone')</th>
				<td>{{ $order->shipping_mobile_no or null }}</td>
			</tr>
			<tr>
				<th>@lang('messages.Location')</th>
				<td><pre>{{ $order->shipping_location or null }}</pre></td>
			</tr>
			<tr>
				<th>@lang('messages.Division')</th>
				<td>{{ $order->shipping_division or null }}</td>
			</tr>
			<tr>
				<th>@lang('messages.Upazila')</th>
				<td>{{ $order->shipping_upazila or null }}</td>
			</tr>
			<tr>
				<th>@lang('messages.Payment Type')</th>
				@if($order->payment_type==1)
				<td class="success">Cash</td>
				@else
				<td class="warning">Card</td>
				@endif
			</tr>
			<tr>
				<th>@lang('messages.Order Status')</th>
				@if($order->status==2)
				<td class="success">Order placed</td>
				@elseif($order->status==3)
				<td class="warning">Confirm by agent</td>
				@elseif($order->status==4)
				<td class="danger">Paid</td>
				@elseif($order->status==5)
				<td class="success">Delivered</td>
				@endif
			</tr>
		</table>
	</div>
	<div class="col-md-6">
		<table class="table table-hover">
			<caption style="text-align: center;font-weight: bold">@lang('messages.Order Information')</caption>
			<tr>
				<th>@lang('messages.Order No')</th>
				<td>{{ $order->order_no or null }}</td>
			</tr>
			<tr>
				<th>@lang('messages.Order Date')</th>
				<td>{{ $order->order_date or null }}</td>
			</tr>
			<tr>
				<th>@lang('messages.Total Price')</th>
				<td align="right">{{ $order->total_price or null }}</td>
			</tr>
			<tr>
				<th>@lang('messages.Delivery Charge')</th>
				<td align="right">{{ $order->delivery_charge or null }}</td>
			</tr>
			<tr>
				<th>@lang('messages.Discount')</th>
				<td align="right">{{ $order->discount or null }}</td>
			</tr>
			<tr>
				<th>@lang('messages.Bill')</th>
				<td align="right" class="warning"><b>{{ $order->payable_amount or null }}</b></td>
			</tr>
			<tr>
				<th>@lang('messages.Paid Amount')</th>
				<td align="right" class="success"><b>{{ $order->paid_amount or null }}</b></td>
			</tr>
			<tr>
				<th>@lang('messages.Due')</th>
				<td align="right" class="danger"><b>{{ $order->due or null }}</b></td>
			</tr>
		</table>
	</div>


	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
			<th>@lang('messages.Serial No.')</th>
			<th>@lang('messages.Name')</th>
			<th>@lang('messages.Color')</th>
			<th>@lang('messages.Size')</th>
			<th>@lang('messages.Quantity')</th>
			<th>@lang('messages.Price')</th>
			<th>@lang('messages.Total Price')</th>
			
		</tr>
		</thead>
		<tbody>
			
			@foreach($order_details as $key=>$order_detail)
			<tr>
				<td>{{ ++$key }}</td>
				<td>{{ $order_detail->product->product_name or null }}</td>
				<td>{{ $order_detail->color->color_name or null }}</td>
				<td>{{ $order_detail->size->size_name or null }}</td>
				<td align="right">{{ $order_detail->quantity or null }}</td>
				<td align="right">{{ $order_detail->price or null }}</td>
				<td align="right">{{ $order_detail->price*$order_detail->quantity }}</td>
			</tr>
			@endforeach
		</tbody>
		</table>
	</div>
</div>
@endsection
