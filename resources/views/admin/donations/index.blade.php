@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Donations"))
@section("contentheader_description", trans("messages.Donations listing"))
@section("section", trans("messages.Donations"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Donations listing"))

@section("headerElems")
@la_access("Scholarships", "create")

@endla_access
@endsection

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
			<th>@lang('messages.Donor Name')</th>
			<th>@lang('messages.Donor Email')</th>
			<th>@lang('messages.Amount')</th>
			<th>@lang('messages.Currency')</th>
			<th>@lang('messages.Date')</th>
			<th>@lang('messages.Description')</th>
			<th>@lang('messages.Sector')</th>
			<th>@lang('messages.Payment')</th>
			
			
		</tr>
		</thead>
		<tbody>
			@foreach($values as $key=>$value)
			<tr>
				<td>{{ ++$key }}</td>
				<td>{{ $value->user->name or null }}</td>
				<td>{{ $value->user->email or null }}</td>
				<td align="right">{{ $value->amount or null }}</td>
				<td>{{ $value->currency->currency_code or null }}</td>
				<td><?php echo App\Helpers\CommonHelper::showDateTimeFormat($value->donate_date);?></td>
				<td>{{ $value->payment_description or null }}</td>
				<td>{{ $value->inbox->sector->name or null }}</td>
				<td>{{ $value->inbox->payment_method->name or null }}</td>
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
<script>
$(function () {
	$('#example1').DataTable( {
	    responsive: false,
	    columnDefs: [ { orderable: false, targets: [-1] }]
	} );
});
</script>
@endpush
