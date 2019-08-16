@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Inboxes"))
@section("contentheader_description", trans("messages.Inboxes listing"))
@section("section", trans("messages.Inboxes"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Inboxes listing"))

@section("headerElems")
@la_access("Scholarships", "create")

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
			<th>@lang('messages.Donor')</th>

			<th>@lang('messages.Amount')</th>
			<th>@lang('messages.Sector')</th>
			<th>@lang('messages.Payment')</th>
			
			<th>@lang('messages.Date')</th>
			
			<!-- <th>@lang('messages.Donor Message')</th> -->
			<!-- <th>@lang('messages.Money')</th> -->
			
			<th>@lang('messages.Status')</th>
			<th>@lang('messages.Comments')</th>
			<th>@lang('messages.Actions')</th>
		</tr>
		</thead>
		<tbody>
			@foreach($inbox_lists as $key=>$inbox)
			<tr>
				<td>{{ ++$key }}</td>
				<td><a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/'.$inbox->id) }}">{{ $inbox->user->email or null }}</a>
				</td>
				
				<td>{{ $inbox->amount or null }} {{ $inbox->currency->currency_code or null }}</td>
				<td>{{ $inbox->sector->name or null }}</td>
				<td>{{ $inbox->payment_method->name or null }}</td>

				<td><?php 
					if(isset($inbox->created_at)){
						echo App\Helpers\CommonHelper::showDateTimeFormat($inbox->created_at);
					}?>
				</td>

				<!-- <td>@if(!empty($inbox->donor_message))<pre>{{ $inbox->donor_message or null }}</pre>@endif</td> -->


				<td>
					@if($inbox->status==1)
						@lang('messages.Draft')
					@elseif($inbox->status==2)
						@lang('messages.Need Clarification')
					@elseif($inbox->status==3)
						@lang('messages.Approved')
					@endif
				</td>

				<td>
					<a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/comments/'.$inbox->id) }}" class="btn btn-primary btn-xs" data-toggle="tooltip" title="@lang('messages.Comments')">
						<i class="fa fa-commenting-o" aria-hidden="true"></i>
						@lang('messages.Comments')
					</a>
					

				</td>

				<td>
					<!-- <a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/'.$inbox->id) }}" class="btn btn-success btn-xs" data-toggle="tooltip" title="@lang('messages.Details')"><i class="fa fa-eye"></i></a> -->

					

					

						


					@if($inbox->status<'3')
						@if(!empty($inbox->attachment))
						<a href="{{ url($inbox->attachment)}}" class="btn btn-success btn-xs" data-toggle="tooltip" title="@lang('messages.Attachment')"><i class="fa fa-paperclip"></i></a>
						@endif	

						@la_access("Inboxes", "edit")

							@if($inbox->sector_id==1)

							<a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/1/'.$inbox->id) }}" class="btn btn-success btn-xs" data-toggle="tooltip" title="@lang('messages.Sponsor')"><i class="fa fa-users" aria-hidden="true"></i>
 							@lang('messages.Sponsor')</a>

							@else

							<a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/status/3/'.$inbox->id) }}" class="btn btn-primary btn-xs confirm" data-toggle="tooltip" title="@lang('messages.Approve')"><i class="fa fa-thumbs-up" aria-hidden="true"></i>
 							@lang('messages.Approve')</a>
							@endif
						 

 							

						 <a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/'.$inbox->id.'/edit') }}" class="btn btn-warning btn-xs" data-toggle="tooltip" title="@lang('messages.Edit')">
						 	<i class="fa fa-edit"></i></a>

						 @la_access("Inboxes", "delete")
						{!! Form::open(['action' => ['Admin\InboxesController@destroy',$inbox->id],'method' => 'delete','style'=>'display:inline']) !!}
						<button class="btn btn-danger btn-xs"  onclick="return confirm('Are you sure to delete this?')" data-toggle="tooltip" title="@lang('messages.Delete')"><i class="fa fa-times"></i></button>
						{!! Form::close() !!}
						@endla_access

						 @if($inbox->status=='2')
						 <a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/status/1/'.$inbox->id) }}" class="btn btn-danger btn-xs confirm_clarify" data-toggle="tooltip" title="@lang('messages.No Need Clarification')"><i class="fa fa-toggle-on" aria-hidden="true"></i> 
						@lang('messages.Clarify')</a>
						 @else
						 	<a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/status/2/'.$inbox->id) }}" class="btn btn-danger btn-xs confirm_clarify" data-toggle="tooltip" title="@lang('messages.Need Clarification')"><i class="fa fa-toggle-off" aria-hidden="true"></i>
 							@lang('messages.Clarify')</a>
						 @endif	
						 

						@endla_access

						

						
					@else
						@if($inbox->status==3)
						<a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/receipt/'.$inbox->id) }}" class="btn btn-warning btn-xs" data-toggle="tooltip" title="@lang('messages.Receipt')"><i class="fa fa-download"></i> @lang('messages.Receipt')</a>
						@endif
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

$('a.confirm').confirm({
	title: 'Confirm!',
    content: "Are you sure to approve this?",
});

$('a.confirm_clarify').confirm({
	title: 'Confirm!',
    content: "Are you sure to clarify this?",
});

</script>
@endpush
