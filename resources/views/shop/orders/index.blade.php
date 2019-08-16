@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Orders"))
@section("contentheader_description", trans("messages.Orders listing"))
@section("section", trans("messages.Orders"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Orders listing"))

@section("headerElems")
@la_access("Orders", "create")
	
@endla_access
@endsection

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
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
			<th>@lang('messages.Serial No.')</th>
			<th>@lang('messages.Order No')</th>
			<th>@lang('messages.Order Date')</th>

			<th>@lang('messages.Name')</th>
			<th>@lang('messages.Phone')</th>

			<th>@lang('messages.Bill')</th>
			<th>@lang('messages.Paid')</th>
			<th>@lang('messages.Due')</th>
			<th>@lang('messages.Payment')</th>
			<th>@lang('messages.Status')</th>
			<th>@lang('messages.Actions')</th>
		</tr>
		</thead>
		<tbody>
			
			@foreach($values as $key=>$value)
			<tr>
				<td>{{ ++$key }}</td>
				<td>{{ $value->order_no }}</td>
				<td><?php 
					if(isset($value->order_date)){
						echo App\Helpers\CommonHelper::showDateFormat($value->order_date);
					}?>
				</td>

				<td>{{ $value->shipping_name or null }}</td>
				<td>{{ $value->shipping_mobile_no or null }}</td>

				<td>{{ $value->payable_amount }}</td>
				<td>{{ $value->paid_amount }}</td>
				<td>{{ $value->due }}</td>

				@if($value->payment_type==1)
				<td class="success">Cash</td>
				@else
				<td class="warning">Card</td>
				@endif

				@if($value->status==2)
				<td class="success">Order placed</td>
				@elseif($value->status==3)
				<td class="warning">Confirm by agent</td>
				@elseif($value->status==4)
				<td class="danger">Paid</td>
				@elseif($value->status==5)
				<td>Delivered</td>
				@endif

				
				<td>
					@la_access("Orders", "edit")
					{{-- 
					<a href="{{ url(config('laraadmin.adminRoute') .'/shops/paments/'.$value->id.'/edit') }}" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
					--}}
					@endla_access

					<a href="{{ url(config('laraadmin.adminRoute') .'/orders/'.$value->id) }}" class="btn btn-success btn-xs" target="_blank" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>

					@la_access("Orders", "delete")
					@if($value->status<5)
					{!! Form::open(['action' => ['Shop\OrdersController@destroy',$value->id],'method' => 'delete','style'=>'display:inline']) !!}
					<button class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
					{!! Form::close() !!}
					@endif
					@endla_access

					@if($value->status==2)
					<a href="{{ url(config('laraadmin.adminRoute') .'/orders/'.$value->id.'/3') }}" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;">Confirm</a>
					@endif

					@if($value->status==4)
					<a href="{{ url(config('laraadmin.adminRoute') .'/orders/'.$value->id.'/5') }}" class="btn btn-success btn-xs" style="display:inline;padding:2px 5px 3px 5px;">Delivery</a>
					@endif



				</td>
			</tr>
			@endforeach
		</tbody>
		</table>
	</div>
</div>

@la_access("Orders", "create")

@endla_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
	$('#example1').DataTable( {
	    responsive: false,
	    columnDefs: [ { orderable: false, targets: [-1] }]
	} );
	$("#payment-add-form").validate({
		
	});
});

function payable_amount_load(order_id)
{
	//alert(order_id);
	var url="{{ url(config('laraadmin.adminRoute') .'/order_load') }}";

	$.post(url,{'order_id':order_id},function( data ) {
			$('#due').val(data.payable_amount);
			$('#amount').val(data.payable_amount);
	});

}

</script>
@endpush
