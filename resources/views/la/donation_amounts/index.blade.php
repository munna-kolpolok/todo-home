@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Donation Amounts"))
@section("contentheader_description", trans("messages.Donation Amounts listing"))
@section("section", trans("messages.Donation Amounts"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Donation Amounts listing"))

@section("headerElems")
@la_access("Donation_Amounts", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">@lang("messages.Add Donation Amount")</button>
@endla_access
@endsection

@section("main-content")
	@php
		$projectsArr=array();
        foreach ($projects as $project)
        {
        $projectsArr[$project->id]=$project->name;
        }
    $projectsJson=json_encode($projectsArr);
	@endphp
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
			@foreach( $listing_cols as $col )
				@if($col=='id')
					<th>@lang('messages.Serial No.')</th>
				@else
					<th>
					@php 
						if(isset($module->fields[$col]['label']))
						{
							$v_col=$module->fields[$col]['label'];
						}
						else
						{
							$v_col=ucfirst($col);
						}						
					@endphp
					{{ Lang::get('messages.'.$v_col) }}
					</th>
				@endif
			@endforeach
			@if($show_actions)
			<th>@lang('messages.Actions')</th>
			@endif
		</tr>
		</thead>
		<tbody>
			
		</tbody>
		</table>
	</div>
</div>

@la_access("Donation_Amounts", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">@lang("messages.Add Donation Amount")</h4>
			</div>
			{!! Form::open(['action' => 'LA\Donation_AmountsController@store', 'id' => 'donation_amount-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
					{{--@la_form($module)--}}
					{{--
					@la_input($module, 'amount')
					@la_input($module, 'description')
					@la_input($module, 'bn_description')
					@la_input($module, 'currency')
					@la_input($module, 'project_id')
					@la_input($module, 'column')
					@la_input($module, 'general_donation')
					--}}
					<input type="hidden" name="currency" value="BDT">
					<input type="hidden" name="column" value="6">

					<div class="form-group">
						<label for="amount">Amount (TK)<span class='la-required'>* </span>:</label>
						<input class="form-control" placeholder="Enter Amount in taka" required="1" data-rule-currency="true" min="0" id="amount" name="amount" type="number">
					</div>
					@la_input($module, 'description')
					@la_input($module, 'bn_description')


					<div class="form-group">
						<label for="general_donation">General Donation: </label> <span class="suggestion_text">(If select YES, it will show in Donate now of Bidyanondo website)</span>
						<select class="form-control" data-placeholder="Enter General Donation" id="general_donation" onchange="showProjects()" name="general_donation">
							<option value="">No</option>
							<option value="general_donation">Yes</option>
						</select>
					</div>
					<div class="form-group projects-row">
						<label for="project_id">Project:</label>
					<select class="form-control" data-placeholder="Enter Project" rel="select2" id="project_id" name="project_id">

					{{--	@foreach($projets as $project)
							<option value="{{$project->id}}">{{$project->name}}</option>
						@endforeach--}}
					</select>
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
	var t=$("#example1").DataTable({
		processing: true,
		stateSave: true,
        //serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/donation_amount_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	t.on( 'order.dt search.dt', function () 
	{
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) 
        {
            cell.innerHTML = i+1;
        } );
    }).draw();
	$("#donation_amount-add-form").validate({
		
	});
	showProjects();
});

function showProjects() {
 var genDonation=	$('#general_donation').val();

 	//$('.projects-row').show();

	 var items = $.parseJSON('<?php echo $projectsJson;?>');//parse JSON
	 if(genDonation!='general_donation'){
		 $('#project_id').empty();
		 $.each(items, function (k, v) {
			 var item_list_option = "<option value=" + k + ">" + v + "</option>";
			 $(item_list_option).appendTo('#project_id');
			 $('.projects-row').show()
		 });
	 }else {
		 $('#project_id').empty();
		 var item_list_option = "<option value=''>None</option>";
		 $(item_list_option).appendTo('#project_id');
		 $('.projects-row').hide()

	 }
}
</script>
@endpush
