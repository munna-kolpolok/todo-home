@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/donation_amounts') }}">@lang('messages.Donation Amount')</a> :
@endsection
@section("contentheader_description", $donation_amount->$view_col)
@section("section", trans("messages.Donation Amounts"))
@section("section_url", url(config('laraadmin.adminRoute') . '/donation_amounts'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Donation Amounts Edit : ".$donation_amount->$view_col)

@section("main-content")
	@php
		$projectsArr=array();
        foreach ($projects as $project)
        {
        $projectsArr[$project->id]=$project->name;
        }
    $projectsJson=json_encode($projectsArr);
	@endphp

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
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			
				{!! Form::model($donation_amount, ['route' => [config('laraadmin.adminRoute') . '.donation_amounts.update', $donation_amount->id ], 'method'=>'PUT', 'id' => 'donation_amount-edit-form']) !!}
					{{--@ la_form($module) --}}


					{{--@la_edit_input($module, 'amount')--}}
			<div class="col-md-2"><div class="form-group">
					<label for="amount">Amount (TK)<span class='la-required'>* </span>:</label>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<input class="form-control" placeholder="Enter Amount in taka" required="1"  min="0" id="amount" name="amount" type="number" value="{{$donation_amount->amount or null}}">
				</div>
			</div>
					@la_edit_input($module, 'description')
					@la_edit_input($module, 'bn_description')
					{{--@la_edit_input($module, 'currency')--}}
					{{--@la_edit_input($module, 'project_id')--}}
					{{--@la_edit_input($module, 'column')--}}
					{{--@la_edit_input($module, 'general_donation')--}}
			<div class="col-md-2">
				<div class="form-group">
					<label for="general_donation">General Donation:</label>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<select class="form-control" data-placeholder="Enter General Donation" id="general_donation" onchange="showProjects()" name="general_donation">
						{{--<option value="">No</option>
						<option value="general_donation">Yes</option>--}}

						<option  value="0"  {{ $donation_amount->general_donation==0? 'selected ':''}} >No</option>
						<option  value="1" {{ $donation_amount->general_donation==1? 'selected ':''}} >Yes</option>
					</select>
					<span class="suggestion_text" >(If YES, it will show in Donate now of Bidyanondo)</span>
				</div>

			</div>

			<div class="projects-row">
				<div class="col-md-2">
					<div class="form-group">
						<label for="general_donation">Project:</label>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<select class="form-control" data-placeholder="Enter Project" rel="select2" id="project_id" name="project_id">
							@foreach($projects as $project)
								<option value="{{$project->id}}" @php echo $donation_amount->project_id==$project->id? "selected":"" @endphp>{{$project->name}} </option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/donation_amounts') }}">@lang('messages.Cancel')</a>
					</div>
					</div>
				{!! Form::close() !!}
			
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#donation_amount-edit-form").validate({
		
	});
	checkDonation();
});

function showProjects() {
	var genDonation=$('#general_donation').val();

	var items = $.parseJSON('<?php echo $projectsJson;?>');//parse JSON
	if(genDonation==0  ){
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
function  checkDonation() {
	var genDonation=$('#general_donation').val();

	if(genDonation=='1' ){
		$('#project_id').empty();
		$('.projects-row').hide()

	}

}
</script>
@endpush
