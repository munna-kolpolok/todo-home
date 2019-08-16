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
                        <h4 class="name">{{ $paypal->payer_email or null }}</h4>
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
            <li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/paypal_payments') }}" data-toggle="tooltip"
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
                                    if (isset($paypal->payment_date)) {
                                        echo App\Helpers\CommonHelper::showDateTimeFormat($paypal->payment_date);
                                    }?></div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-2">@lang('messages.Comments'):</label>

                                <div class="col-md-10 fvalue">
                                    <div style="border: 1px solid #CCCCCC; background-color: #F5F5F5; padding: 5px 10px; border-radius: 5px;">{{ $paypal->order->comments or null}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-2">@lang('messages.Amount'):</label>

                                <div class="col-md-10 fvalue">
                                    <b>{{ App\Helpers\CommonHelper::decimalNumberFormat($paypal->amount) }} USD</b>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-2">Amount TK:</label>

                                <div class="col-md-10 fvalue">{{ App\Helpers\CommonHelper::decimalNumberFormat($paypal->tk_amount)}}</div>
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
                                <label for="name" class="col-md-2">Transaction Fee:</label>

                                <div class="col-md-10 fvalue">{{ App\Helpers\CommonHelper::decimalNumberFormat($paypal->transaction_fee)}}</div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-2">Payer Email:</label>

                                <div class="col-md-10 fvalue">{{ $paypal->payer_email }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Payment Id :</label>

                                <div class="col-md-10 fvalue">{{$paypal->payment_id  }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Payer Payment Method :</label>

                                <div class="col-md-10 fvalue">{{$paypal->payer_payment_method }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Payer First Name :</label>

                                <div class="col-md-4 fvalue">{{$paypal->payer_first_name  }}</div>

                                <label for="name" class="col-md-2">Payer Last Name :</label>

                                <div class="col-md-4 fvalue">{{$paypal->payer_last_name  }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Payer Id :</label>

                                <div class="col-md-10 fvalue">{{$paypal->payer_id  }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Payer Country Code :</label>

                                <div class="col-md-10 fvalue">{{$paypal->payer_country_code }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Payer Status :</label>

                                <div class="col-md-10 fvalue">{{$paypal->payer_status  }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">Payer Merchant Id :</label>

                                <div class="col-md-10 fvalue">{{$paypal->payee_merchant_id   }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2">State:</label>

                                <div class="col-md-10 fvalue">{{$paypal->state }}</div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-2"> Created Ip Aaddress :</label>

                                <div class="col-md-10 fvalue">{{$paypal->created_ip_address  }}</div>
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
