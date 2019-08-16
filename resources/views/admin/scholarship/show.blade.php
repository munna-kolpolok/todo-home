@extends('la.layouts.app')

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/receive_purchase') }}">@lang('messages.Back To List')</a>
@endsection
@section("headerElems")
	<a class="btn btn-success btn-sm pull-right" href="{{ $print_url }}" data-toggle="tooltip" data-placement="top" title="Print" role="button"><i class="fa fa-print"></i> Print</a>
@endsection

@section('main-content')
<div class="box box-success">
	<div class="box-header">
	</div>

	<div class="box-body">
		<div class="row">
			<div class="col-md-1">
				<div class="form-group">
					<label for="receive_voucher_no">@lang('messages.Voucher No')*</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					{{ $receive_info->receive_voucher_no  or null }}
				</div>
			</div>
			<div class="col-md-1">
				<div class="form-group">
					<label for="receive_voucher_no">@lang('messages.Date')*</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<?php 
					if(isset($receive_info->receive_date)){
		                echo App\Helpers\CommonHelper::showDateFormat($receive_info->receive_date);
		            }?>
	            </div>
			</div>
			<div class="col-md-1">
				<div class="form-group">
					<label for="purchase_order_no">@lang('messages.Purchase Order No')</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					{{ $receive_info->purchase_order_no or null  }}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-1">
				<div class="form-group">
					<label for="challan_no">@lang('messages.Challan No')</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					{{ $receive_info->challan_no or null  }}
				</div>
			</div>
			<div class="col-md-1">
				<div class="form-group">
					<label for="supplier_id">@lang('messages.Supplier')</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					{{ $receive_info->company_name or null  }}
	        	</div>
			</div>
			<div class="col-md-1">
				<div class="form-group">
					<label for="item_id">@lang('messages.Store')*</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					{{ $receive_info->store_name or null }}
				</div>
			</div>
		</div>
	

	<table class="table table-bordered">
		<thead>
			<tr class="success">
				<th>@lang('messages.Serial No.')</th>
				<th>@lang('messages.Item')</th>
				<th>@lang('messages.Category')</th>
				<th>@lang('messages.Group')</th>
				<th>@lang('messages.Unit')</th>
				<th>@lang('messages.Svc')</th>
				<th>@lang('messages.Un Svc')</th>
				<th>@lang('messages.Repairable')</th>
				<th>@lang('messages.Un Repairable')</th>
				<th>@lang('messages.Price')</th>
				<th>@lang('messages.Total Price')</th>
				<th>@lang('messages.Currency')</th>
				<th>@lang('messages.Origin')</th>
				{{-- <th>@lang('messages.Brand')</th> --}}
			</tr>
		</thead>
		<tbody>
			@foreach($receive_items as $key=>$receive_item)	
			<tr>
				<td>{{ ++$key }}</td>
				<td>{{ $receive_item->item_name or null}}</td>
				<td>{{ $receive_item->item_cat_name or null}}</td>
				<td>{{ $receive_item->item_group_name or null}}</td>
				<td>{{ $receive_item->mm_unit_name or null}}</td>

				<td align="right">{{ App\Helpers\CommonHelper::round_number_format($receive_item->svc_qty) }}</td>
				<td align="right">{{ App\Helpers\CommonHelper::round_number_format($receive_item->unsvc_qty) }}</td>
				<td align="right">{{ App\Helpers\CommonHelper::round_number_format($receive_item->repairable_qty) }}</td>
				<td align="right">{{ App\Helpers\CommonHelper::round_number_format($receive_item->unrepairable_qty) }}</td>
				<td align="right">{{ App\Helpers\CommonHelper::round_number_format($receive_item->unit_price) }}</td>
				<td align="right">{{ App\Helpers\CommonHelper::round_number_format($receive_item->total_price) }}</td>
				
				<td>{{ $receive_item->currency_name or null }}</td>
				<td>{{ $receive_item->country_name or null }}</td>
				{{-- <td>{{ $receive_item->brand_name or null}}</td> --}}
			</tr>
			@endforeach
		</tbody>
	</table>

	</div>	

	
</div>

@endsection