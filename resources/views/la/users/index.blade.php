@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Users"))
@section("contentheader_description", trans("messages.Users listing"))
@section("section", trans("messages.Users"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Users listing"))

@section("headerElems")
@la_access("Users", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">@lang("messages.Add User")</button>
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
					<th>No</th>
					<th>ID Card</th>
					<th>Name</th>
					<th>Email</th>
					<th>level</th>
					<th>Verified</th>
					<th>Donor</th>
					<th>Actions</th>
				</tr>
				</thead>
				<tbody>

				@foreach($users as $key=>$user)
					<tr>
						<td>{{ ++$key }}</td>
						<td>{{ $user->id_card or null}}</td>
						<td>{{ $user->name or null}}</td>
						<td>{{ $user->email or null }}</td>
						<td>{{ App\Models\User_Level::find($user->user_level)->name}}</td>
						
						@if($user->is_verified == 1)
							<td class="success">Verified</td>
							@else
							<td class="danger">Not Verified</td>
						@endif

						@if($user->is_donor == 1)
							<td class="success">Donor</td>
							@else
							<td class="danger">Not Donor</td>
						@endif
						
						<td>
							@la_access("users", "edit")
							<a href="{{url(config('laraadmin.adminRoute').'/users/'.$user->id.'/edit')}}"
							   class="btn btn-warning btn-xs"  data-toggle="tooltip" title="Edit" style="display:inline;padding:2px 5px 3px 5px;" ><i class="fa fa-edit" ></i></a>
							@endla_access
							@la_access("users", "delete")
							{{Form::open(['route' => [config('laraadmin.adminRoute') . '.users.destroy', $user->id], 'method' => 'delete', 'style'=>'display:inline'])}}
							<button class="btn btn-danger btn-xs" type="submit"  data-toggle="tooltip" title="Delete"
									onclick="return confirm('Are you sure to delete this entry?')"><i
										class="fa fa-times" title="Delete"></i></button>
							{{Form::close()}}
							@endla_access
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>

@la_access("Users", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">@lang("messages.Add User")</h4>
			</div>
			{!! Form::open(['action' => 'LA\UsersController@store', 'id' => 'user-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="name">Name <span class="la-required">*</span></label>
								<input class="form-control" placeholder="Enter Name" data-rule-minlength="5" data-rule-maxlength="250" required="1" id="name" name="name" type="text" value="" aria-required="true">
							</div>
						</div>
						<div class="col-md-6">
							<label for="name">Email <span class="la-required">*</span></label>
							<input class="form-control" placeholder="Enter Email" data-rule-maxlength="250" data-rule-unique="true" required="1" data-rule-email="true" id="email" name="email" type="email" aria-required="true" aria-invalid="true">
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="name">Password <span class="la-required">*</span></label>
								<input class="form-control" placeholder="Enter Password" data-rule-minlength="6" data-rule-maxlength="250" required="1" id="password" name="password" type="password" value="" aria-required="true">							</div>
						</div>
						<div class="col-md-6">
							<label for="name">User Level <span class="la-required">*</span></label>
							<select class="form-control select2" name="user_level" required="1" id="user_level">
								@foreach ($levels as $level)
									<option value="{{$level->id}}">{{$level->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="is_verified">Verified</label>
								<select class="form-control select2" name="is_verified" id="is_verified">
									<option selected value="1">Verified</option>
									<option value="0">Not Verified</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="name">Donor</label>
								<select class="form-control select2" name="is_donor" id="is_donor">
									<option selected value="1">Donor</option>
									<option value="0">Not Donor</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="name">Id Card</label>
								<input class="form-control" placeholder="Enter Unique Id" data-rule-maxlength="150" id="id_card" name="id_card" type="text" value="" aria-required="true">
							</div>
						</div>
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
				'csv', 'excel', 'pdf', 'print',
			]
        } );

        
        $("#user-add-form").validate({
            
        });

    });

</script>
@endpush
