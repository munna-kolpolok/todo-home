@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Donation Packages"))
@section("contentheader_description", trans("messages.Donation Packages listing"))
@section("section", trans("messages.Donation Packages"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Donation Packages listing"))

{{--@section("headerElems")
@la_access("Donation_Packages", "create")
	<a href="{{ url(config('laraadmin.adminRoute') . '/donation_packages/create') }}" class="btn btn-success btn-sm pull-right">@lang("messages.Add Donation Packages")</a>
@endla_access
@endsection--}}

@section("main-content")

@if(session()->has('seccess_msg'))
	<div class="alert alert-success alert-dismissable">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <strong>{{ session()->get('seccess_msg') }}</strong>
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
			<th>Serial</th>
			<th>Last Donate Date</th>
			<th>Donor Name</th>
			<th>Donor Email</th>
			<th>From Date</th>
            <th>To date</th>
            <th>Last Donate Plan</th>
			{{--<th>Action</th>--}}
		</tr>
		</thead>
		<tbody>
			
			@foreach($values as $key=>$value)
			<tr>
				<td>{{++$key}}</td>
				<td>
                    <?php
                    if(isset($value->donate_date)){
                        echo App\Helpers\CommonHelper::showDateTimeFormat($value->donate_date);
                    }?>
                </td>
                <td>{{$value->user->name or null}}</td>
                <td><a href="{{ url(config('laraadmin.adminRoute') .'/donation_packages/'.$value->user_id) }}">{{$value->user->email or null}}</a></td>
				<td>{{$value->from_date or null}}</td>
				<td>{{$value->to_date or null}}</td>
				<td>
                    @if($value->month == 1)
                        <span class="">Monthly</span>
                    @elseif($value->month == 6)
                        <span class="">Half Yearly</span>
					@elseif($value->month == 12)
						<span class="">Yearly</span>
                    @endif
                </td>
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
