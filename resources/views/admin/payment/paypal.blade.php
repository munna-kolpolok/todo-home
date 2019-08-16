@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Paypal"))
@section("contentheader_description", trans("messages.Paypal Payment listing"))
@section("section", trans("messages.Paypal"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Paypal Payment listing"))

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

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
			<th>@lang('messages.Serial No.')</th>
			<th>@lang('messages.Payment Date')</th>
			<th>@lang('messages.Donor')</th>
			<th>Payer Email</th>
			<th>Payer First Name</th>
			<th>Payer Last Name</th>
			
			
			
			<th>@lang('messages.Amount')</th>
			<!-- <th>@lang('messages.Currency')</th> -->
			<!-- <th>@lang('messages.Transaction Fee')</th> -->

			<th>1 USD</th>
			<th>Amount (TK)</th>

			{{--<th>@lang('messages.State')</th>--}}
			{{-- 
			<th>@lang('messages.Project')</th>
			<th>@lang('messages.ID Card')</th>
			--}}
			<!-- <th>@lang('messages.IP Address')</th> -->
			 <th>@lang('messages.Comments')</th>
		</tr>
		</thead>
		<tbody>
			
			@foreach($payment_lists as $key=>$value)
			<tr>
				<td>{{ ++$key }}</td>
				<td>
                    <?php
                    if(isset($value->payment_date)){
                        echo App\Helpers\CommonHelper::showDateFormat($value->payment_date);
                    }?>
				</td>
				<td>{{ $value->user->name or null}}</td>
				<td>{{ $value->payer_email or null}}</td>
				<td>{{ $value->payer_first_name or null}}</td>
				<td>{{ $value->payer_last_name or null}}</td>
				
				

				<td align="right"><a href="{{ url(config('laraadmin.adminRoute') .'/paypal_payments/'.$value->id) }}">{{ App\Helpers\CommonHelper::decimalNumberFormat($value->amount)}} {{ $value->currency or null }}</a></td>
				<!-- <td>{{ $value->currency or null }}</td> -->
				<!-- <td align="right">{{ $value->transaction_fee or null }}</td> -->

				<td align="right">{{ App\Helpers\CommonHelper::decimalNumberFormat($value->tk_convert_amount)}} TK</td>
				<td align="right">{{ App\Helpers\CommonHelper::decimalNumberFormat($value->tk_amount)}}</td>

				<td>{{ str_limit($value->order->comments,10)  }}</td>

				{{-- 
				<td>{{ $value->project->name or null }}</td>
				<td>{{ $value->student->id_card or null }}</td>
				--}}
				<!-- <td>{{ $value->created_ip_address or null }}</td> -->
				<!-- <td>{{ $value->order->comments or null}}</td> -->
			</tr>
			@endforeach
		</tbody>
		</table>
	</div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>

{{--Data table export options--}}
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/buttons.print.min.js') }}"></script>
<script>
$(function () {
	$('#example1').DataTable( {
	    responsive: false,
	    columnDefs: [ { orderable: false, targets: [-1] }],
		dom: '<"top"Bf>rt<"bottom"lip><"clear">',
		buttons: [
			'csv', 'excel', 'pdf', 'print'
		]
	} );
});
</script>
@endpush
