@extends("la.layouts.app")

@section("contentheader_title", "Menu Permissions")
@section("contentheader_description", "Menu Permissions listing")
@section("section", "Menu Permissions")
@section("sub_section", "Listing")
@section("htmlheader_title", "Menu Permissions Listing")

@section("headerElems")
@la_access("Menu Permissions", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Menu Permissions</button>
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
			<th>Serial No.</th>
			<th>Role Name</th>
			<th>Menu Name</th>
			<th>View</th>
			<th>Create</th>
			<th>Edit</th>
			<th>Delete</th>
			@if($show_actions)
			<th>Actions</th>
			@endif
		</tr>
		</thead>
		<tbody>
			
			@foreach($values as $key=>$value)
			<tr>
				<form action="{{ url('/admin/edit_role_permissions') }}" method="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="role_menu_id" value="{{ $value->id }}">
				<td>{{ ++$key }}</td>
				<td>{{ $value->roleName }}</td>
				<td>{{ $value->menuName }}</td>
				<td><input class="create_checkb" type="checkbox" name="acc_view" id="acc_view" <?php if($value->acc_view == 1) { echo 'checked="checked"'; } ?> ></td>
				<td><input class="create_checkb" type="checkbox" name="acc_create" id="acc_create" <?php if($value->acc_create == 1) { echo 'checked="checked"'; } ?> ></td>
				<td><input class="create_checkb" type="checkbox" name="acc_edit" id="acc_edit" <?php if($value->acc_edit == 1) { echo 'checked="checked"'; } ?> ></td>
				<td><input class="create_checkb" type="checkbox" name="acc_delete" id="acc_delete" <?php if($value->acc_delete == 1) { echo 'checked="checked"'; } ?> ></td>
				<td>
				@la_access("Menu Permissions", "edit")
				<button class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></button>	
				@endla_access
				@la_access("Menu Permissions", "delete")			
				<button name='delete' value="1" class="btn btn-danger btn-xs" type="submit" onclick="return confirm(\'Are you sure to delete this entry?\')" style="display:inline;padding:2px 5px 3px 5px;">
				<i class="fa fa-times"></i></button>
				@endla_access	
				</td>
				</form>
			</tr>
			
			
			@endforeach
		</tbody>
		</table>
	</div>
</div>

@la_access("Menu Permissions", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Menu Permissions</h4>
			</div>

			<form action="{{ url('/admin/store_role_permission') }}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="modal-body">
				<div class="box-body">
                    <div class="form-group">
                    	<label for="division_id">Roles* :</label>
                    	<select class="form-control" required="1" data-placeholder="Select Role" multiple="true" rel="select2" name="role_id[]">
                    	@foreach($roles as $role)
                    		<option value="{{ $role->id }}">{{ $role->name }}</option>
                    	@endforeach	
                    	</select>				
					</div>
					<div class="form-group">
                    	<label for="division_id">Menus* :</label>
                    	<select class="form-control" required="1" data-placeholder="Select Menu" multiple="true" rel="select2" name="menu_id[]">
                    	@foreach($menus as $menu)
                    		<option value="{{ $menu->id }}">{{ $menu->name }}</option>
                    	@endforeach	
                    	</select>				
					</div>
					<div class="form-group">
                    	<label for="division_id">View : </label>
                    	<input class="create_checkb" type="checkbox" name="acc_view" id="acc_view" checked="checked">

                    	<label for="division_id">Create : </label>
                    	<input class="create_checkb" type="checkbox" name="acc_create" id="acc_create" >

                    	<label for="division_id">Edit : </label>
                    	<input class="create_checkb" type="checkbox" name="acc_edit" id="acc_edit" >

                    	<label for="division_id">Delete : </label>
                    	<input class="create_checkb" type="checkbox" name="acc_delete" id="acc_delete" >			
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
			</div>
			
			</form>
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
	$('#example1').DataTable( {
	    responsive: false
	} );
});
</script>
@endpush
