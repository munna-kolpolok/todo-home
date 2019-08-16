@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Scholarship"))
@section("contentheader_description", trans("messages.Scholarship listing"))
@section("section", trans("messages.Scholarship"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Scholarship listing"))

@section("headerElems")
@la_access("Scholarships", "create")
	<a href="{{ url(config('laraadmin.adminRoute') . '/scholarships/create') }}" class="btn btn-success btn-sm pull-right">@lang("messages.Add Scholarship")</a>
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
			<th>@lang('messages.No')</th>
			<th>@lang('messages.ID Card')</th>
			<th>@lang('messages.Student Name')</th>
			<th>@lang('messages.Year')</th>
			<th>@lang('messages.Scholarship Amount') (TK)</th>
			<th>@lang('messages.Last Donated')</th>
			 
			@if($show_actions)
			<th>@lang('messages.Actions')</th>
			@endif
		</tr>
		</thead>
		<tbody>
			
			@foreach($values as $key=>$value)
			<tr>
				<td>{{ ++$key }}</td>
				<td>{{ $value->student->id_card or null}}</td>
				<td>{{ $value->student->name or null}}</td>
				
				<td>{{ $value->year }}</td>
				<td>{{ $value->scholarship_amount }}</td>
				<td>
					<?php 
					if(isset($value->last_donate_date)){
						echo App\Helpers\CommonHelper::showDateTimeFormat($value->last_donate_date);
					}?>
				</td>
				<td>
					@la_access("Scholarships", "edit")
					<a href="{{ url(config('laraadmin.adminRoute') .'/scholarships/donations/'.$value->id) }}" class="btn btn-primary btn-xs">Donate</a>
					
					<a href="{{url(config('laraadmin.adminRoute').'/scholarships/'.$value->id.'/edit')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
					@endla_access


					@la_access("Scholarships", "delete")
					{!! Form::open(['action' => ['Admin\ScholarshipsController@destroy',$value->id],'method' => 'delete','style'=>'display:inline']) !!}
					<button class="btn btn-danger btn-xs"  onclick="return confirm('Are you sure to delete this?')"><i class="fa fa-times"></i></button>
					{!! Form::close() !!}
					@endla_access
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
