@extends('la.layouts.app')

@section('htmlheader_title')
	Inbox View
@endsection


@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-success clearfix">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-3">
					<div class="profile-icon text-primary"><i class="fa fa-angle-double-right"></i></div>
				</div>
				<div class="col-md-9">
					<h4 class="name">{{ $inbox->user->name or null }} / {{ $inbox->user->email or null }}</h4>				
				</div>
			</div>
		</div>
		<div class="col-md-3">
		</div>
		<div class="col-md-4">			
		</div>
		
		<div class="col-md-1 actions">
			@if($inbox->status==1)
				@la_access("Inboxes", "edit")
					<a href="{{ url(config('laraadmin.adminRoute') . '/inboxes/'.$inbox->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
				@endla_access
				
				@la_access("Inboxes", "delete")
					{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.inboxes.destroy', $inbox->id], 'method' => 'delete', 'style'=>'display:inline']) }}
						<button class="btn btn-default btn-delete btn-xs" type="submit"  onclick="return confirm('Are you sure to delete this?')"><i class="fa fa-times"></i></button>
					{{ Form::close() }}
				@endla_access
			@endif
		</div>
		
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/inboxes') }}" data-toggle="tooltip" data-placement="right" title="Back to inboxes"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> @lang('messages.General Info')</a></li>		
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">
					<!-- <div class="panel-default panel-heading">
						<h4>@lang('messages.General Info')</h4>
					</div> -->
					<div class="panel-body">

						<div class="form-group">
							<label for="name" class="col-md-2">@lang('messages.Type'):</label>
							<div class="col-md-4 fvalue">Offline</div>

							<label for="name" class="col-md-2">@lang('messages.Date'):</label>
									<div class="col-md-4 fvalue"><?php 
							if(isset($inbox->date)){
								echo App\Helpers\CommonHelper::showDateTimeFormat($inbox->date);
							}?></div>
						</div>
						<div class="form-group">
							<label for="name" class="col-md-2">@lang('messages.Donor Message'):</label>
							<div class="col-md-10 fvalue"><div style="border: 1px solid #CCCCCC; background-color: #F5F5F5; padding: 5px 10px; border-radius: 5px; min-height: 25px">{{ $inbox->donor_message or null}}</div></div>
						</div>

						<div class="form-group">
							<label for="name" class="col-md-2">@lang('messages.Amount'):</label>
							<div class="col-md-4 fvalue"><b>{{ App\Helpers\CommonHelper::decimalNumberFormat($inbox->amount) }} {{ $inbox->currency->currency_name or null}} ({{ $inbox->currency->currency_code or null}})</b></div>

							<label for="name" class="col-md-2">@lang('messages.Amount') TK:</label>
							<div class="col-md-4 fvalue"><b>{{ App\Helpers\CommonHelper::decimalNumberFormat($inbox->tk_amount) }} Taka</b></div>
						</div>
						<div class="form-group">
							<label for="name" class="col-md-2">@lang('messages.Project'):</label>
							<div class="col-md-4 fvalue">{{ $inbox->sector->project->name or null}}</div>

							<label for="name" class="col-md-2">@lang('messages.Sector'):</label>
							<div class="col-md-4 fvalue">{{ $inbox->sector->name or null}}</div>
						</div>
						<div class="form-group">
							<label for="name" class="col-md-2">@lang('messages.Payment'):</label>
							<div class="col-md-4 fvalue">{{ $inbox->payment_method->name or null}}</div>

							<label for="name" class="col-md-2">@lang('messages.Status'):</label>
							<div class="col-md-4 fvalue">
							@if($inbox->status==1)
								@lang('messages.Draft')
							@elseif($inbox->status==2)
								@lang('messages.Need Clarification')
							@elseif($inbox->status==3)
								@lang('messages.Approved')
							@elseif($inbox->status==4)
								@lang('messages.Disapproved')
							@endif
							</div>
						</div>

						<div class="form-group">
							<label for="name" class="col-md-2">@lang('messages.Payer Account No'):</label>
							<div class="col-md-10 fvalue">{{ $inbox->payer_account_no or null}}</div>
						</div>
						<div class="form-group">
							<label for="name" class="col-md-2">@lang('messages.Payee Account No'):</label>
							<div class="col-md-10 fvalue">{{ $inbox->payee_account_no or null}}</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="col-md-2"> Service :</label>
                            <div class="col-md-4 fvalue">
                                @if($inbox->service==1)
                                    <span class="">Not Served</span>
                                @elseif($inbox->service==2)
                                    Served
                                @elseif($inbox->service==3)
                                    Served and Mail Sent
                                @endif
                            </div>

							<label for="name" class="col-md-2"> Website :</label>
                            <div class="col-md-4 fvalue">
                                {{ $inbox->website->name or null }}
                            </div>
						</div>


					</div>
				</div>
			</div>
		</div>		
	</div>
	</div>
	</div>
</div>
@endsection
