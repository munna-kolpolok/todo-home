@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Scholarship Donors"))
@section("contentheader_description", trans("messages.Scholarship Donors listing"))
@section("section", trans("messages.Scholarship Donors"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Scholarship Donors listing"))

@section("headerElems")
@la_access("Scholarship_Donors", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">@lang("messages.Add Scholarship Donor")</button>
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
			<th>@lang('messages.Donor')</th>
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
				<td>{{ $value->user->email  or null}}</td>
				<td>
					@la_access("Scholarship_Donors", "edit")
					<a href="{{ url(config('laraadmin.adminRoute') .'/scholarship_donors/'.$value->id.'/edit') }}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
					@endla_access


					@la_access("Scholarship_Donors", "delete")
					{!! Form::open(['action' => ['LA\Scholarship_DonorsController@destroy',$value->id],'method' => 'delete','style'=>'display:inline']) !!}
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

@la_access("Scholarship_Donors", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">@lang("messages.Add Scholarship Donor")</h4>
			</div>
			{!! Form::open(['action' => 'LA\Scholarship_DonorsController@store', 'id' => 'scholarship_donor-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
					{{--
                    @la_form($module)
					
					
					@la_input($module, 'student_id')
					@la_input($module, 'user_id')
					--}}

					<div class="form-group">
						<label for="item_cat">@lang('messages.Student')<span class="la-required">*</span></label>
						<select id="item_cat" class="form-control" required="1" rel="select2" name="student_id" id="student_id">
						@foreach($students as $student)
						<option value="{{$student->id}}">{{ $student->id_card }}</option>
						@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="item_cat">@lang('messages.Donor')<span class="la-required">*</span></label>
						<select id="item_cat" class="form-control" required="1" rel="select2" name="user_id" id="user_id">
						@foreach($donors as $donor)
						<option value="{{$donor->id}}">{{ $donor->email }}</option>
						@endforeach
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
	    stateSave: true,
	    columnDefs: [ { orderable: false, targets: [-1] }],
		dom: '<"top"Bf>rt<"bottom"lip><"clear">',
		buttons: [
			'csv', 'excel', 'pdf', 'print'
		]
	} );

	$("#scholarship_donor-add-form").validate({
		
	});
});
</script>
@endpush
