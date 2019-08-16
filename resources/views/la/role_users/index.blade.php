@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Role Users"))
@section("contentheader_description", trans("messages.Role Users listing"))
@section("section", trans("messages.Role Users"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Role Users Listing"))

@section("headerElems")
@la_access("Role_Users", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">@lang('messages.Add Role User')</button>
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
			@foreach( $listing_cols as $col )
			<th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
			@endforeach
			@if($show_actions)
			<th>Actions</th>
			@endif
		</tr>
		</thead>
		<tbody>
			
		</tbody>
		</table>
	</div>
</div>

@la_access("Role_Users", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Role User</h4>
			</div>
			{!! Form::open(['action' => 'LA\Role_UsersController@store', 'id' => 'role_user-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
					{{--
                    @la_form($module)
					
					
					@la_input($module, 'user_id')
					@la_input($module, 'role_id')
					--}}

					<div class="form-group">
			        	<label for="user_id" >@lang('messages.User')* :</label>
			        	<div>
				        	<select class="form-control"  data-placeholder="@lang('messages.Select')"  rel="select2" name="user_id" id="user_id" required="">
				        	<option value="">@lang('messages.Select')</option>
				        	@foreach($users as $user)
				        		<option value="{{ $user->id }}" 
				        		 >{{ $user->email }}</option>
				        	@endforeach	
				        	</select>	
			        	</div>		
					</div>
					@la_input($module, 'role_id')
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
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
	$("#example1").DataTable({
		processing: true,
        //serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/role_user_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#role_user-add-form").validate({
		
	});
});
</script>
@endpush
