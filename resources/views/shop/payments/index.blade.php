@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Payments"))
@section("contentheader_description", trans("messages.Payments listing"))
@section("section", trans("messages.Payments"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Payments listing"))

@section("headerElems")
@la_access("Payments", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">@lang("messages.Add Payment")</button>
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
			<th>@lang('messages.Bill')</th>
			<th>@lang('messages.Paid Amount')</th>
			<th>@lang('messages.Due')</th>
			<th>@lang('messages.Payment Date')</th>
			<th>@lang('messages.Actions')</th>
		</tr>
		</thead>
		<tbody>
			
			@foreach($values as $key=>$value)
			<tr>
				<td>{{ ++$key }}</td>
				<td>{{ $value->order->order_no }}</td>
				<td>{{ $value->order->payable_amount }}</td>
				<td>{{ $value->amount }}</td>
				<td>{{ $value->order->due }}</td>
				<td><?php 
					if(isset($value->payment_date)){
						echo App\Helpers\CommonHelper::showDateFormat($value->payment_date);
					}?>
				</td>
				
				<td>
					@la_access("Payments", "edit")
					{{-- 
					<a href="{{ url(config('laraadmin.adminRoute') .'/shops/paments/'.$value->id.'/edit') }}" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
					--}}
					@endla_access
					@la_access("Payments", "delete")
					{!! Form::open(['action' => ['Shop\PaymentsController@destroy',$value->id],'method' => 'delete','style'=>'display:inline']) !!}
					<button class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
					{!! Form::close() !!}
					@endla_access

				</td>
			</tr>
			@endforeach
		</tbody>
		</table>
	</div>
</div>

@la_access("Payments", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">@lang("messages.Add Payment")</h4>
			</div>
			{!! Form::open(['action' => 'Shop\PaymentsController@store', 'id' => 'payment-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
					<label for="group_id">@lang('messages.Payment Date')<span class="la-required">*</span></label>
					<div class="form-group">
						<div class='input-group date' id='datetimepicker1'>
			                <input type='text' class="form-control"  required="1"  name="payment_date" id="payment_date"  placeholder="@lang('messages.Enter Date')" value=""/>
			                <span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
			            </div>
		            </div>
                    <div class="form-group">
                        <label for="group_id">@lang('messages.Order No')<span class="la-required">*</span></label>
                        <select class="form-control" rel="select2" required="1" name="order_id" id="order_id" onchange="payable_amount_load(this.value)">
                            <option value="">@lang('messages.Select')</option>
                            @foreach ($orders as $order)
                                <option value="{{$order->id}}">{{ $order->order_no }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="group_id">@lang('messages.Due')<span class="la-required">*</span></label>
                        <input class="form-control" type="text" name="due" id="due" required="1" readonly="1">
                    </div>
                    <div class="form-group">
                        <label for="group_id">@lang('messages.Amount')<span class="la-required">*</span></label>
                        <input class="form-control" type="text" name="amount" id="amount" required="1" readonly="1">
                    </div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.Close')</button>
				{!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
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
