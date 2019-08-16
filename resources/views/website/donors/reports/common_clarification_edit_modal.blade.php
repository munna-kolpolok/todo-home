<?php
$bkash_options = '';
$rocket_options = '';
$paypal_options = '';
$bank_options = '';
$sectorOptions = '';
$paymentMethodOptions = '';

if (request()->cookie('locale') == 'bn') {
    //Account no bn
    foreach ($accounts as $account) {
        if ($account->type == 'Paypal') {
            $paypal_options .= '<option value="' . $account->name . '">' . $account->bn_name . '</option>';
        } elseif ($account->type == 'Bank') {
            $bank_options .= '<option value="' . $account->name . '">' . $account->bn_name . '</option>';
        } elseif ($account->type == 'Bkash') {
            $bkash_options .= '<option value="' . $account->name . '">' . $account->bn_name . '</option>';
        } elseif ($account->type == 'Rocket') {
            $rocket_options .= '<option value="' . $account->name . '">' . $account->bn_name . '</option>';
        }
    }
    //sector name bn
    foreach ($sectors as $sector) {
        $sectorOptions .= "<option value=$sector->id>$sector->bn_name</option>";
    }

    //payment method options bn
    foreach($payment_methods as $payment_method) {
        $paymentMethodOptions .= "<option value=$payment_method->id>$payment_method->bn_name</option>";
    }

} else {
    //Account no en
    foreach ($accounts as $account) {
        if ($account->type == 'Paypal') {
            $paypal_options .= '<option value="' . $account->name . '">' . $account->name . '</option>';
        } elseif ($account->type == 'Bank') {
            $bank_options .= '<option value="' . $account->name . '">' . $account->name . '</option>';
        } elseif ($account->type == 'Bkash') {
            $bkash_options .= '<option value="' . $account->name . '">' . $account->name . '</option>';
        } elseif ($account->type == 'Rocket') {
            $rocket_options .= '<option value="' . $account->name . '">' . $account->name . '</option>';
        }

    }

    //sector name en
    foreach ($sectors as $sector) {
        $sectorOptions .= "<option value=$sector->id>$sector->name</option>";
    }

    //payment method options en
    foreach($payment_methods as $payment_method) {
        $paymentMethodOptions .= "<option value=$payment_method->id>$payment_method->name</option>";
    }
}

?>


<div class="modal fade" id="edit-post-modal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">@lang('messages.Edit Donation Clerification')</h4>
            </div>
        {{ Form::open( array('url' => '', 'files'=>true, 'method'=>'PATCH', 'id' => 'inbox-edit-form'))}}
        <!--hidden field-->
            <input type="hidden" name="redirect_status" value="1">
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form - group">
                                <label for="date">@lang("messages.Donation Date")<span
                                            class="la - required"> * </span>:</label>
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' class="form-control" name="date" id="date"
                                           placeholder="@lang('messages.Enter Date')" required="1"
                                           value="{{ App\Helpers\CommonHelper::showDateFormat(date('Y-m-d')) }}"/>
                                    <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">@lang("messages.Amount")<span
                                            class="la-required"> * </span>:</label>
                                <input type="number" class="form-control add_amount" id="amount"
                                       placeholder="@lang("messages.Enter Amount In English")" name="amount"
                                       required="1" min="1" max="10000000">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">@lang("messages.Currency")<span
                                            class="la-required"> * </span>:</label>
                                <select class="form-control select2_edit" rel="select2" required="1" name="currency_id"
                                        id="currency_id">
                                    @foreach($currency_lists as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->currency_name }}
                                            ({{ $currency->currency_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">@lang("messages.Donation Reason")<span
                                            class="la-required"> * </span>:</label>
                                <select class="form-control select2_edit" name="sector_id" id="sector_id" rel="select2"
                                        required="1">
                                        {!! $sectorOptions  !!}
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">@lang("messages.Payment Channel")<span
                                            class="la-required"> * </span>:</label>
                                <select class="form-control select2_edit" name="payment_method_id"
                                        id="payment_method_id"
                                        rel="select2" required="1" onchange="account_hide_edit(this.value)">
                                        {!! $paymentMethodOptions  !!}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pwd">@lang("messages.Attachment"):</label><span class="suggestion_text">
                                                <i class="fa fa-hand-o-right" aria-hidden="true">
                                                 </i> @lang("messages.inbox_file_suggestion")
                                        </span>
                                <input style="display: inline" type="file" id="attachment"
                                       name="attachment">
                                <a style="font-size: 18px; display: none" class="btn btn-warning btn-xs"
                                   id="attachment-download" data-toggle="tooltip" title="@lang('messages.Receipt')"
                                   target="_blank"><i
                                            class="fa fa-download"></i></a>
                            </div>
                        </div>


                    </div>
                    <div class="row account_div">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" id="l_payee_account_no_e">@lang("messages.Recipient Bkash No")<span
                                            class="la-required"> * </span>:</label>
                                <select class="form-control select2_edit" name="payee_account_no"
                                        id="payee_account_no_r_e">
                                    {!! $bkash_options !!}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6" id="payer_account_no_div_e">
                            <div class="form-group">
                                <label for="email" id="l_payer_account_no_e">@lang("messages.Donor Bkash No")<span
                                            class="la-required"> * </span>:</label>
                                <input type="text" class="form-control" name="payer_account_no" id="payer_account_no_e"
                                       placeholder="@lang('messages.Enter Your Bkash No')" required
                                       value="{{ old('payer_account_no') }}">
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pwd">@lang("messages.Message"):</label>
                                <textarea class="form-control" name="donor_message" id="donor_message"
                                          placeholder="@lang("messages.Enter Your Message")"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.Close')</button>
                <button type="button" id="update_button" class="btn btn-success"
                        onclick="inbox_edit()">@lang('messages.Update')</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('style')
<style type="text/css">
    .suggestion_text {
        color: green;
        font-size: 12px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(function () {
        /*Edit donation modal value set*/
        $('.edit_donation').on('click', function () {
            const inbox_id = $(this).prev().val();
            //console.log(inbox_id);
            /*File download*/
            var imageSrc = $(this).prev().prev().prev().val();
            if (imageSrc !== '') {
                var base_url = $(this).prev().prev().val() + '/';
                var image_src = base_url + imageSrc;
                var attachment = 'attachment-download';
                $('#' + attachment).show().attr('href', image_src);
            } else {
                var attachment_hide = 'attachment-download';
                $('#' + attachment_hide).hide().attr('href', '');
            }

            $.ajax({
                url: "{{url('get-inbox')}}",
                type: 'POST',
                dataType: 'json',
                data: {
                    id: inbox_id
                },
                success: function (response) {

                    $('#amount').val(response.amount);
                    $('#donor_message').val(response.donor_message);
                    $('#payer_account_no_e').val(response.payer_account_no);
                    // $('#payee_account').val(response.payee_account_no);
                    //var date = explode(response_date);
                    //console.log(date);
                    $('#date').val(response.date);

                    var sector_id = response.sector_id;
                    var payment_id = response.payment_method_id;
                    var currency_id = response.currency_id;
                    $('#sector_id').val(sector_id).trigger('change.select2');
                    $('#currency_id').val(currency_id).trigger('change.select2');
                    $('#payment_method_id').val(payment_id).trigger('change.select2');

                    $('#payee_account_no_r_e').val(response.payee_account_no).trigger('change.select2');

                    $('#inbox-edit-form').attr('action', "{{url('/donors')}}" + '/' + inbox_id);


                }
            });


        });

        $("#inbox-edit-form").validate({
            submitHandler: function(form) {
                $("#update_button").removeAttr("onclick"); 
                $("#update_button").addClass("disabled", true);
                $("#update_button").html("<?php echo Lang::get('messages.Processing');?> <i class='fa fa-spinner fa-spin'></i>");
                form.submit(); 
            }
        });


    });
</script>
@endpush