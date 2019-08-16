@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Currencies"))
@section("contentheader_description", trans("messages.Currencies listing"))
@section("section", trans("messages.Currencies"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Currencies listing"))

@section("headerElems")
@la_access("Currencies", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">@lang("messages.Add Currency")</button>
	<a style="margin: 0 10px" href="{{ url(config('laraadmin.adminRoute') . '/currencies/order/change') }}"
   	class="btn btn-warning btn-sm pull-right">Update Order</a>
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

@la_access("Currencies", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">@lang("messages.Add Currency")</h4>
			</div>
			{!! Form::open(['action' => 'LA\CurrenciesController@store', 'id' => 'currency-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
					{{--
                    @la_form($module)
                    @la_input($module, 'serial_no')
					--}}

					@la_input($module, 'currency_name')
					@la_input($module, 'currency_code')
					@la_input($module, 'tk_convert_amount')
					@la_input($module, 'min_donate_amount')
					@la_input($module, 'max_donate_amount')

					{{--@la_input($module, 'paypal')--}}
					<div class="form-group">
						<label for="name">Paypal</label>
						<select class="form-control select2" name="paypal" id="paypal">
							<option value="0">Not used in paypal</option>
							<option value="1">Used in paypal</option>
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
serverSide: true,
ajax: "{{ url(config('laraadmin.adminRoute') . '/currency_dt_ajax') }}",
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
$("#currency-add-form").validate({

});
});
</script>
@endpush
