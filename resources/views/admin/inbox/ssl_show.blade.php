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
							<div class="col-md-4 fvalue">Online (SSLCOMMERZ)</div>

                            <label for="name" class="col-md-2">Tran Status :</label>
                            <div class="col-md-4 fvalue">{{ $inbox->tran_status or null }}</div>
						</div>
                        <div class="form-group">
                            <label for="name" class="col-md-2">@lang('messages.Payment Date'):</label>

                            <div class="col-md-4 fvalue"><?php
                                if (isset($inbox->tran_time)) {
                                    echo App\Helpers\CommonHelper::showDateTimeFormat($inbox->tran_time);
                                }?></div>

                            <label for="name" class="col-md-2">Verify Sign :</label>
                            <div class="col-md-4 fvalue">{{ $inbox->verify_sign  or null }}</div>    
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-2">@lang('messages.Comments'):</label>

                            <div class="col-md-10 fvalue">
                                <div style="border: 1px solid #CCCCCC; background-color: #F5F5F5; padding: 5px 10px; border-radius: 5px;">{{ $inbox->order->comments or null}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-2">@lang('messages.Amount'):</label>
                            <div class="col-md-4 fvalue">
                                <b>{{ App\Helpers\CommonHelper::decimalNumberFormat($inbox->total_amount) }}
                                    Taka</b></div>

                            <label for="name" class="col-md-2">Store Amount:</label>
                            <div class="col-md-4 fvalue"><b>{{ App\Helpers\CommonHelper::decimalNumberFormat($inbox->store_amount)}}
                                Taka</b>
                            </div>
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
                            <label for="name" class="col-md-2">Payer Name :</label>
                            <div class="col-md-4 fvalue">{{$inbox->cus_name  }}</div>

                            <label for="name" class="col-md-2">Payer Email :</label>
                            <div class="col-md-4 fvalue"><b>{{$inbox->cus_email  }}</b></div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-2">Payer Phone :</label>
                            <div class="col-md-4 fvalue"><b>{{$inbox->cus_phone  }}</b></div>

                            <label for="name" class="col-md-2">Store Id :</label>
                            <div class="col-md-4 fvalue">{{ $inbox->store_id  or null }}</div>

                        </div>


                        <!-- <div class="form-group">
                            <label for="name" class="col-md-2">Verify Key :</label>
                            <div class="col-md-4 fvalue" style=" word-wrap: break-word;">{{ $inbox->verify_key  or null }}</div>

                            <label for="name" class="col-md-2">Val Id :</label>
                            <div class="col-md-4 fvalue">{{ $inbox->val_id  or null }}</div>
                        </div> -->

                        <div class="form-group">
                            <label for="name" class="col-md-2">Bank Tran Id :</label>
                            <div class="col-md-4 fvalue">{{ $inbox->bank_tran_id  or null }}</div>

                            <label for="name" class="col-md-2">Card No  :</label>
                            <div class="col-md-4 fvalue">{{ $inbox->card_no or null }}</div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-2">Card Brand  :</label>
                            <div class="col-md-4 fvalue">{{ $inbox->card_brand or null }}</div>

                            <label for="name" class="col-md-2">Card Type  :</label>
                            <div class="col-md-4 fvalue">{{ $inbox->card_type or null }}</div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-2">Card Issuer   :</label>
                            <div class="col-md-4 fvalue">{{ $inbox->card_issuer or null }}</div>

                            <label for="name" class="col-md-2">Issuer Country   :</label>
                            <div class="col-md-4 fvalue">{{ $inbox->card_issuer_country or null }}</div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-2">Ip Address   :</label>
                            <div class="col-md-4 fvalue">{{ $inbox->created_ip_address or null }}</div>

                            <label for="name" class="col-md-2">Country Code:</label>
                            <div class="col-md-4 fvalue">{{ $inbox->card_issuer_country_code or null }}</div>
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
