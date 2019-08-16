@extends("la.layouts.app")

@section("contentheader_title", trans("messages.SSL"))
@section("contentheader_description", trans("messages.SSL Payment listing"))
@section("section", trans("messages.SSL"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.SSL Payment listing"))

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
			{{--
			<th>@lang('messages.Project')</th>
			<th>@lang('messages.ID Card')</th>
			--}}
			
			<th>@lang('messages.Amount')</th>
			<th>@lang('messages.Store Amount')</th>
			<th>@lang('messages.Currency')</th>
			{{--<th>@lang('messages.Status')</th>--}}

			<th>@lang('messages.Comments')</th>

		</tr>
		</thead>
		<tbody>
			
			@foreach($payment_lists as $key=>$value)
			<tr>
				<td>{{ ++$key }}</td>
				<td>
                    <?php
                    if(isset($value->tran_time)){
                        echo App\Helpers\CommonHelper::showDateFormat($value->tran_time);
                    }?>
				</td>
				<td>{{ $value->user->name or null}}</td>
				{{-- 
				<td>{{ $value->project->name or null }}</td>
				<td>{{ $value->student->id_card or null }}</td>
				--}}

				<td align="right"><a href="{{ url(config('laraadmin.adminRoute') .'/ssl_payments/'.$value->id) }}">{{ App\Helpers\CommonHelper::decimalNumberFormat($value->total_amount)}}</a></td>
				<td align="right">{{ App\Helpers\CommonHelper::decimalNumberFormat($value->store_amount)}}</td>
				<td>{{ $value->currency or null }}</td>
				{{--<td>{{ $value->tran_status or null }}</td>--}}
				<td>{{ str_limit( $value->order->comments, 10)}}</td>
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
