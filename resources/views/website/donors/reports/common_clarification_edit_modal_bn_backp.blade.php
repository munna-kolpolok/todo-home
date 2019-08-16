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
                            <div class="form-group">
                                <label for="date">@lang("messages.Donation Date")<span
                                            class="la-required"> * </span>:</label>
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
                                       required="1" min="1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">@lang("messages.Currency")<span
                                            class="la-required"> * </span>:</label>
                                <select class="form-control select2" rel="select2" required="1" name="currency_id"
                                        id="currency_id">
                                    <option value="">@lang('messages.Select currency')</option>
                                    @foreach($currency_lists as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->bn_currency_name }}
                                            ({{ $currency->currency_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">@lang("messages.Payment")<span
                                            class="la-required"> * </span>:</label>
                                <select class="form-control select2" name="payment_method_id" id="payment_method_id"
                                        rel="select2" required="1">
                                    <option value="">@lang("messages.Select payment method")</option>
                                    @foreach($payment_methods as $payment_method)
                                        <option value="{{ $payment_method->id }}">{{ $payment_method->bn_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">@lang("messages.Sector")<span
                                            class="la-required"> * </span>:</label>
                                <select class="form-control select2" name="sector_id" id="sector_id" rel="select2"
                                        required="1">
                                    <option value="">@lang("messages.Select donate sector")</option>
                                    @foreach($sectors as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->bn_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">@lang("messages.Payer Account No")<span
                                            class="la-required"> * </span>:</label>
                                <input type="text" class="form-control" name="payer_account_no" id="payer_account"
                                       placeholder="@lang('messages.Enter Payer Account No')" required
                                       value="{{ old('payer_account_no') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">@lang("messages.Payee Account No")<span
                                            class="la-required"> * </span>:</label>
                                <input type="text" class="form-control" name="payee_account_no" id="payee_account"
                                       placeholder="@lang('messages.Enter Payee Account No')" required
                                       value="{{ old('payer_account_no') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pwd">@lang("messages.Attachment"):</label>
                                <input style="display: inline" type="file" id="attachment"
                                       name="attachment">
                                <a style="font-size: 18px; display: none" class="btn btn-warning btn-xs"
                                   id="attachment-download" data-toggle="tooltip" title="@lang('messages.Receipt')"><i
                                            class="fa fa-download"></i></a>
                                <span class="suggestion_text" style="color:green; font-size: 12px; display: block">
                                <i class="fa fa-hand-o-right" aria-hidden="true">
                                </i> Max file size: 1 MB
                            </span>
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
                <button type="button" class="btn btn-success"
                        onclick="inbox_edit()">@lang('messages.Update')</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

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
                    $('#payer_account').val(response.payer_account_no);
                    $('#payee_account').val(response.payee_account_no);
                    //var date = explode(response_date);
                    //console.log(date);
                    $('#date').val(response.date);

                    var sector_id = response.sector_id;
                    var payment_id = response.payment_method_id;
                    var currency_id = response.currency_id;
                    $('#sector_id').val(sector_id).trigger('change.select2');
                    $('#currency_id').val(currency_id).trigger('change.select2');
                    $('#payment_method_id').val(payment_id).trigger('change.select2');

                    $('#inbox-edit-form').attr('action', "{{url('/donors')}}" + '/' + inbox_id);


                }
            });


        });

        $("#inbox-edit-form").validate({});


    });
</script>
@endpush