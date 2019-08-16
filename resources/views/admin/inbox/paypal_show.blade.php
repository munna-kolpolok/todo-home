@extends('la.layouts.app')

@section('htmlheader_title')
	Payment Verification View
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
					<div class="panel-default panel-heading">
						<h4>@lang('messages.General Info')</h4>
					</div>

					<div class="panel-body">
						<div class="form-group">
							<label for="name" class="col-md-2">@lang('messages.Type'):</label>
							<div class="col-md-4 fvalue">Online (Paypal)</div>

                            <label for="name" class="col-md-2">Payment Method :</label>
                            <div class="col-md-4 fvalue">{{$inbox->payer_payment_method }}</div>
						</div>
                            <div class="form-group">
                                <label for="name" class="col-md-2">@lang('messages.Payment Date'):</label>
                                <div class="col-md-4 fvalue"><?php
                                    if (isset($inbox->payment_date)) {
                                        echo App\Helpers\CommonHelper::showDateTimeFormat($inbox->payment_date);
                                    }?></div>

                                <label for="name" class="col-md-2">Transaction Fee:</label>
                                <div class="col-md-4 fvalue"><b>{{ App\Helpers\CommonHelper::decimalNumberFormat($inbox->transaction_fee)}} USD</b>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-2">@lang('messages.Comments'):</label>

                                <div class="col-md-10 fvalue">
                                    <div style="border: 1px solid #CCCCCC; background-color: #F5F5F5; padding: 5px 10px; border-radius: 5px;">{{ $inbox->order->comments or null}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-2">@lang('messages.Amount'):</label>

                                <div class="col-md-4 fvalue">
                                    <b>{{ App\Helpers\CommonHelper::decimalNumberFormat($inbox->amount) }} USD</b>
                                </div>

                                <label for="name" class="col-md-2">Amount TK:</label>

                                <div class="col-md-4 fvalue"><b>{{ App\Helpers\CommonHelper::decimalNumberFormat($inbox->tk_amount)}} Taka (BDT)</b></div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">@lang('messages.Project'):</label>

                                <div class="col-md-4 fvalue">{{ $inbox->project->name or null }}</div>

                                <label for="name" class="col-md-2">@lang('messages.Student'):</label>
                                <div class="col-md-4 fvalue">{{ $inbox->student->id_card or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Food Project:</label>
                                <div class="col-md-4 fvalue">{{ $inbox->order->food_project->name or null }}</div>

                                <label for="name" class="col-md-2">Food Item :</label> 
                                <div class="col-md-4 fvalue">{{$inbox->order->food_item->name or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2"> Unit No:</label>
                                <div class="col-md-4 fvalue">{{$inbox->order->no_unit or null }}</div>

                                <label for="name" class="col-md-2">Donation Package :</label> 
                                <div class="col-md-4 fvalue">
                                    @if($inbox->order->donate_plan==1)
                                        Monthly
                                    @elseif($inbox->order->donate_plan==6)
                                        Half Yearly
                                    @elseif($inbox->order->donate_plan==12)
                                        Yearly
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Payer Email:</label>
                                <div class="col-md-4 fvalue">{{ $inbox->payer_email }}</div>

                                <label for="name" class="col-md-2">Payment Id :</label>
                                <div class="col-md-4 fvalue">{{$inbox->payment_id  }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Payer First Name :</label>

                                <div class="col-md-4 fvalue">{{$inbox->payer_first_name  }}</div>

                                <label for="name" class="col-md-2">Payer Last Name :</label>

                                <div class="col-md-4 fvalue">{{$inbox->payer_last_name  }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Payer Id :</label>
                                <div class="col-md-4 fvalue">{{$inbox->payer_id  }}</div>

                                <label for="name" class="col-md-2">Payer Merchant Id :</label>
                                <div class="col-md-4 fvalue">{{$inbox->payee_merchant_id   }}</div>
                            </div>


                            <div class="form-group">
                                <label for="name" class="col-md-2">Payer Status :</label>
                                <div class="col-md-4 fvalue">{{$inbox->payer_status  }}</div>

                                <label for="name" class="col-md-2">State:</label>
                                <div class="col-md-4 fvalue">{{$inbox->state }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Ip Address :</label>
                                <div class="col-md-4 fvalue">{{$inbox->created_ip_address  }}</div>

                                <label for="name" class="col-md-2">Country Code :</label>
                                <div class="col-md-4 fvalue">{{$inbox->payer_country_code }}</div>
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
