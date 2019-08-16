@extends('la.layouts.app')

@section('htmlheader_title')
    Paypal View
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
                        <h4 class="name"><?php
                            if (isset($paypal->tran_time)) {
                                echo App\Helpers\CommonHelper::showDateTimeFormat($paypal->tran_time);
                            }?></h4>
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
            <li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/ssl_payments') }}" data-toggle="tooltip"
                            data-placement="right" title="Back to inboxes"><i class="fa fa-chevron-left"></i></a></li>
            <li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info"
                                  data-target="#tab-info"><i class="fa fa-bars"></i> @lang('messages.General Info')</a>
            </li>
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
                                <label for="name" class="col-md-2">@lang('messages.Payment Date'):</label>

                                <div class="col-md-10 fvalue"><?php
                                    if (isset($paypal->tran_time)) {
                                        echo App\Helpers\CommonHelper::showDateTimeFormat($paypal->tran_time);
                                    }?></div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-2">@lang('messages.Comments'):</label>

                                <div class="col-md-10 fvalue">
                                    <div style="border: 1px solid #CCCCCC; background-color: #F5F5F5; padding: 5px 10px; border-radius: 5px;">{{ $paypal->order->comments or null}}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-2">@lang('messages.Amount'):</label>

                                <div class="col-md-10 fvalue">
                                    <b>{{ App\Helpers\CommonHelper::decimalNumberFormat($paypal->total_amount) }}
                                        Taka</b></div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-2">Store Amount:</label>

                                <div class="col-md-10 fvalue">{{ App\Helpers\CommonHelper::decimalNumberFormat($paypal->store_amount)}}
                                    Taka
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-2">@lang('messages.Project'):</label>

                                <div class="col-md-10 fvalue">{{ $paypal->project->name or null }}</div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-2">@lang('messages.Student'):</label>

                                <div class="col-md-10 fvalue">{{ $paypal->student->id_card or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Tran Status :</label>
                                <div class="col-md-10 fvalue">{{ $paypal->tran_status or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Store Id :</label>
                                <div class="col-md-10 fvalue">{{ $paypal->store_id  or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Store Amount :</label>
                                <div class="col-md-10 fvalue"><?php
                                    if (isset($paypal->store_amount)) {
                                        echo App\Helpers\CommonHelper::decimalNumberFormat($paypal->store_amount );
                                    }?></div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Val Id :</label>
                                <div class="col-md-10 fvalue">{{ $paypal->val_id  or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Verify Sign :</label>
                                <div class="col-md-10 fvalue">{{ $paypal->verify_sign  or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Verify Key :</label>
                                <div class="col-md-10 fvalue" style=" word-wrap: break-word;">{{ $paypal->verify_key  or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Bank Tran Id :</label>
                                <div class="col-md-10 fvalue">{{ $paypal->bank_tran_id  or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Card No  :</label>
                                <div class="col-md-10 fvalue">{{ $paypal->card_no or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Card Brand  :</label>
                                <div class="col-md-10 fvalue">{{ $paypal->card_brand or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Card Type  :</label>
                                <div class="col-md-10 fvalue">{{ $paypal->card_type or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Card Issuer   :</label>
                                <div class="col-md-10 fvalue">{{ $paypal->card_issuer or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Card Issuer Country   :</label>
                                <div class="col-md-10 fvalue">{{ $paypal->card_issuer_country or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Card Issuer Country Code   :</label>
                                <div class="col-md-10 fvalue">{{ $paypal->card_issuer_country_code or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Created Ip Address   :</label>
                                <div class="col-md-10 fvalue">{{ $paypal->created_ip_address or null }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2"> Service :</label>

                                <div class="col-md-10 fvalue">
                                    @if($paypal->service==1)
                                        <span class="">Not Served</span>
                                    @elseif($paypal->service==2)
                                        Served
                                    @elseif($paypal->service==3)
                                        Served and Mail Sent
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2"> Website :</label>

                                <div class="col-md-10 fvalue">
                                    {{ $paypal->website->name or null }}
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
