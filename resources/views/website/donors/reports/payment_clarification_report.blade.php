@extends('website.profile_layouts.app')


@section('profile-content')
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
            $sectorOptions .= "<option value='$sector->id'>$sector->name</option>";
        }

        //payment method options en
        foreach($payment_methods as $payment_method) {
            $selected = $payment_method->id=='5' ? 'selected' : '';
            $paymentMethodOptions .= "<option value='$payment_method->id' $selected>$payment_method->name</option>";
        }
    }
    ?>

    <div class="small-device-padding">
        <div class="col-md-9">
            <div id="post-wrapper">
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
                <div style="margin-bottom: 10px" class="post-create">
                    <a data-toggle="modal" data-target="#AddModal" class="btn theme-btn btn-block">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        @lang('messages.New Donation Clerification')
                    </a>
                </div>
                <!-- start blog-main-content -->
                <div class="box box-success">
                    <div class="box-body">
                        <table id="example1" class="table table-bordered">
                            <thead>
                            <tr class="success">
                                <th>@lang('messages.No')</th>
                                <th>@lang('messages.Amount')</th>
                                <th>@lang('messages.Sector')</th>
                                <th>@lang('messages.Payment')</th>
                                <th>@lang('messages.Donation Date')</th>
                                <th>@lang('messages.Type')</th>
                                <th>@lang('messages.Status')</th>
                                <th>@lang('messages.Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($inboxes)>0)
                                @foreach($inboxes as $key=>$inbox)
                                    <tr @if($inbox->status=='2')  class="danger"
                                        @elseif($inbox->status=='3')  class="success" @endif>
                                        <td>{{ ++$key }}</td>

                                        <td>{{ App\Helpers\CommonHelper::decimalNumberFormat($inbox->amount) }} {{ $inbox->currency_name or null }}</td>
                                        <td>{{ $inbox->sector_name or null }}</td>
                                        <td>{{ $inbox->payment_name or null }}</td>

                                        <td><?php
                                            if (isset($inbox->date)) {
                                                echo App\Helpers\CommonHelper::showDateFormat($inbox->date);
                                            }?>
                                        </td>

                                        @if($inbox->type==1)
                                            <td>@lang('messages.Offline')</td>
                                        @else
                                            <td class="danger">@lang('messages.Online')</td>
                                        @endif


                                        @if($inbox->status==1)
                                            <td>@lang('messages.Draft')</td>
                                        @elseif($inbox->status==2)
                                            <td class="danger">@lang('messages.Clarify')</td>
                                        @elseif($inbox->status==3)  
                                            <td class="success">@lang('messages.Approved')</td>  
                                        @elseif($inbox->status==4)
                                            <td class="warning">@lang('messages.Disapproved')</td>
                                        @endif

                                        {{--
                                        <td>
                                            @if($inbox->status==1)
                                                <span class="draft-span">@lang('messages.Draft')</span>
                                            @elseif($inbox->status==2)
                                                <span class="clarification-span">@lang('messages.Need Clarification')</span>
                                            @elseif($inbox->status==3)
                                                <span class="approved-span"><i class="fa fa-thumbs-o-up"
                                                                               aria-hidden="true"></i> @lang('messages.Approved')</span>
                                            @endif
                                        </td>
                                        --}}

                                        @if($inbox->type=='1')
                                            <td>

                                                @if(!empty($inbox->attachment))
                                                    <a href="{{ url($inbox->attachment)}}"
                                                       class="btn btn-success btn-xs"
                                                       data-toggle="tooltip" title="@lang('messages.Attachment')" target="_blank" ><i
                                                                class="fa fa-paperclip"></i></a>
                                                @endif

                                                
                                                <a href="{{ url('/donors/'.$inbox->id) }}"
                                                   class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                   title="@lang('messages.Comments')">
                                                    <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                                </a>

                                                @if($inbox->status<'3')
                                                <!--hidden input-->
                                                    <input type="hidden" id="smile-img-{{$inbox->id}}"
                                                           value="{{$inbox->attachment}}">
                                                    <input type="hidden" id="base_url" value="{{url('/')}}">
                                                    <input type="hidden" class="inbox_id" value="{{$inbox->id}}">

                                                    <a href="#" class="btn btn-info btn-xs edit_donation"
                                                       data-toggle="modal"
                                                       id="edit_donation" data-target="#edit-post-modal"
                                                       title="@lang('messages.Edit')"><i class="fa fa-pencil-square-o"
                                                                                         aria-hidden="true"></i>
                                                    </a>
                                                    <a href="{{ url('donors/delete_post/1/'.$inbox->id)}}"
                                                       class="btn btn-danger btn-xs confirm" data-toggle="tooltip"
                                                       title="@lang('messages.Delete')"><i class="fa fa-trash"
                                                                                           aria-hidden="true"></i>
                                                    </a>
                                                @else
                                                    @if($inbox->scholarship_amount>0)
                                                        <a href="{{ url('donation_scholarship_receipt/'.$inbox->id)}}"
                                                           class="btn btn-warning btn-xs" data-toggle="tooltip"
                                                           title="@lang('messages.Receipt')"><i
                                                                    class="fa fa-download"></i></a>
                                                    @else
                                                        <a href="{{ url('donation_receipt/1/'.$inbox->id)}}"
                                                           class="btn btn-warning btn-xs" data-toggle="tooltip"
                                                           title="@lang('messages.Receipt')"><i
                                                                    class="fa fa-download"></i></a>
                                                    @endif
                                                @endif

                                            </td>
                                        @else
                                            <td>
                                               
                                                <a href="{{ url('donation_receipt/'.$inbox->type.'/'.$inbox->id)}}"
                                                   class="btn btn-warning btn-xs" data-toggle="tooltip"
                                                   title="@lang('messages.Receipt')"><i class="fa fa-download"></i></a>
                                                
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end blog-main-content -->
            </div>
        </div>
    </div>

    <!-- modal start -->
    <div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"> &times; </span></button>
                    <h4 class="modal-title" id="myModalLabel">@lang('messages.Add Donation Clerification')</h4>
                </div>
                {!! Form::open(['action' => 'Website\DonorsController@store','files'=>true, 'id' => 'inbox-add-form']) !!}
                <input type="hidden" name="redirect_status" value="1">

                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">@lang("messages.Donation Date")<span
                                                class="la-required"> * </span>:</label>

                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='text' class="form-control" name="date" id="add_date"
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

                                    <input type="number" class="form-control add_amount" id="add_amount"
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

                                    <select class="form-control select2" rel="select2" required="1" name="currency_id"
                                            id="add_currency_id">
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
                                    <select class="form-control select2" name="sector_id" id="add_sector_id"
                                            rel="select2" required="1">
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
                                    <select class="form-control select2" name="payment_method_id"
                                            id="add_payment_method_id"
                                            rel="select2" required="1" onchange="account_hide(this.value)">
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
                                    <input type="file" id="add_attachment" class="form-control" name="attachment">
                                    
                                     
                                </div>
                            </div>

                        </div>
                        <div class="row account_div">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" id="l_payee_account_no">@lang("messages.Recipient Bkash No")<span class="la-required"> * </span>:</label>
                                    
                                    <select class="form-control select2" name="payee_account_no" id="payee_account_no_r">
                                        {!! $bkash_options !!}
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6" id="payer_account_no_div">
                                <div class="form-group">
                                    <label for="email" id="l_payer_account_no">@lang("messages.Donor Bkash No")<span
                                                class="la-required"> * </span>:</label>
                                    <input type="text" class="form-control" name="payer_account_no" id="payer_account_no" 
                                           placeholder="@lang('messages.Enter Your Bkash No')" required
                                           value="{{ old('payer_account_no') }}">
                                </div>
                            </div>
                            

                            
                        </div>

                       

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="pwd">@lang("messages.Message"):</label>
                                    <textarea class="form-control" name="donor_message" id="add_donor_message"
                                              placeholder="@lang("messages.Enter Your Message")"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.Close')</button>
                    <button type="button" id="save_button" class="btn btn-success" onclick="inbox_add()">@lang('messages.Save')</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- modal end -->
    <!-- Edit clarification modal start -->
    @include('website.donors.reports.common_clarification_edit_modal')
    <!-- Edit clarification modal end -->


@endsection

@push('style')
<style type="text/css">
    .suggestion_text{
        color: green;
        font-size: 12px;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
<link href="{{ asset('la-assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ asset('jquery-confirm-v3.2.0/css/jquery-confirm.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<!-- jquery.validate + select2 -->
<script src="{{ asset('la-assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js') }}"
        type="text/javascript"></script>

<script src="{{ asset('jquery-confirm-v3.2.0/js/jquery-confirm.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">

    $(document).ready(function() {
      $(".select2").select2({
        dropdownParent: $("#AddModal")
      });

      $(".select2_edit").select2({
        dropdownParent: $("#edit-post-modal")
      });
    });

    $('#example1').DataTable({
        responsive: false,
        columnDefs: [{orderable: false, targets: [-1]}]
    });


    $("#inbox-add-form").validate({
        submitHandler: function(form) { 
                $("#save_button").removeAttr("onclick");
                $("#save_button").addClass("disabled", true);
                $("#save_button").html("<?php echo Lang::get('messages.Processing');?> <i class='fa fa-spinner fa-spin'></i>");
                form.submit(); 
            }
    });
    /*Integer amount input*/
    $('.add_amount').keyup(function () {
        $('span.error-keyup-1').hide();
        var inputVal = $(this).val();
        var numericReg = /^\d*[0-9]$/;
        if (!numericReg.test(inputVal)) {
            this.value = this.value.replace(/[^0-9]/g, '');
            $(this).after('<span style="color: #ed3237; font-size: 12px" class="error error-keyup-1">Numeric characters only.</span>');
        }
    });

    /*  $('#add_donor_message').keyup(function() {
     var data = $(this).val();
     var dataFull = data.replace(/[^\w\s]/gi, '');
     $('#add_donor_message').val(dataFull);
     });
     $('#donor_message').keyup(function() {
     var data = $(this).val();
     var dataFull = data.replace(/[^\w\s]/gi, '');
     $('#donor_message').val(dataFull);
     });
     */
    $('a.confirm').confirm({
        title: 'Confirm!',
        content: "Are you sure to delete this ?",
    });

    $(function () {
        $('#datetimepicker1,#datetimepicker2').datetimepicker({
            format: 'DD/MM/YYYY',
            maxDate: new Date()
        });
    });

    /*$(function () {
     $("#datetimepicker1").datepicker({
     autoclose: true,
     todayHighlight: true
     }).datepicker('update', new Date());
     });*/

    //$('.select2').select2();

    function inbox_add() {
        var currency_id = $('#add_currency_id').val();
        var amount = $('#add_amount').val();

        if (currency_id > 0 && amount > 0) {
            var url = "{{ url('inbox_form_submit_check') }}";
            $.post(url, {'currency_id': currency_id, 'amount': amount}, function (data) {
                if (data.check == 1) {
                    $("#inbox-add-form").submit();
                }
                else {
                    $.alert(data.msg + data.min_donate_amount + ' ' + data.currency_name);
                }
            });
        }
        else {
            $("#inbox-add-form").submit();
        }
    }

    function inbox_edit() {
        var currency_id = $('#currency_id').val();
        var amount = $('#amount').val();

        if (currency_id > 0 && amount > 0) {
            var url = "{{ url('inbox_form_submit_check') }}";
            $.post(url, {'currency_id': currency_id, 'amount': amount}, function (data) {
                if (data.check == 1) {
                    
                    $("#inbox-edit-form").submit();
                }
                else {
                    $.alert(data.msg + data.min_donate_amount + ' ' + data.currency_name);
                }
            });
        }
        else {
            $.alert('Fill up Amount, Currency, Payment, Sector');
        }
    }

    function account_hide(value) {
        if (value > 3) {
            $('.account_div').show();

            if(value==8)
            {
                $('#payer_account_no_div').hide();
            }
            else
            {
                $('#payer_account_no_div').show();
            }

            if(value==4)
            {
                //....rocket....
                $('#l_payer_account_no').html("{{ Lang::get('messages.Donor Rocket No') }} <span  class='la-required'>*</span>");
                $('#l_payee_account_no').html("{{ Lang::get('messages.Recipient Rocket No') }} <span class='la-required'>*</span>");

                $('#payer_account_no').attr('placeholder',"{{ Lang::get('messages.Enter Your Rocket No') }}");

                $("#payee_account_no_r").empty();
                $('#payee_account_no_r').append('<?php echo $rocket_options;?>');
            }
            else if(value==5)
            {
                //....bkash....
                $('#l_payer_account_no').html("{{ Lang::get('messages.Donor Bkash No') }} <span class='la-required'>*</span>");
                $('#l_payee_account_no').html("{{ Lang::get('messages.Recipient Bkash No') }} <span class='la-required'>*</span>");

                $('#payer_account_no').attr('placeholder',"{{ Lang::get('messages.Enter Your Bkash No') }}");

                $("#payee_account_no_r").empty();
                $('#payee_account_no_r').append('<?php echo $bkash_options;?>');
            }
            else if(value==6)
            {
                //....Paypal....
                $('#l_payer_account_no').html("{{ Lang::get('messages.Donor Paypal Account No') }} <span class='la-required'>*</span>");
                $('#l_payee_account_no').html("{{ Lang::get('messages.Recipient Paypal Account No') }} <span class='la-required'>*</span>");

                $('#payer_account_no').attr('placeholder',"{{ Lang::get('messages.Enter Your Paypal Email') }}");

                $("#payee_account_no_r").empty();
                $('#payee_account_no_r').append('<?php echo $paypal_options;?>');
            }
            else if(value==7)
            {
                //....Bank Ttansfer....
                $('#l_payer_account_no').html("{{ Lang::get('messages.Donor Bank Account No') }} <span class='la-required'>*</span>");
                $('#l_payee_account_no').html("{{ Lang::get('messages.Recipient Bank Account No') }} <span class='la-required'>*</span>");
                $('#payer_account_no').attr('placeholder',"{{ Lang::get('messages.Enter Your Bank Account No') }}");

                $("#payee_account_no_r").empty();
                $('#payee_account_no_r').append('<?php echo $bank_options;?>');
            }
            else if(value==8)
            {
                //....Cash deposit Through bank....
                $('#l_payer_account_no').html("{{ Lang::get('messages.Donor Account No') }} <span class='la-required'>*</span>");
                $('#l_payee_account_no').html("{{ Lang::get('messages.Recipient Bank Account No') }} <span class='la-required'>*</span>");

                $("#payee_account_no_r").empty();
                $('#payee_account_no_r').append('<?php echo $bank_options;?>');
            }
            
            

        }
        else {
            $('.account_div').hide();
        }
    }

    function account_hide_edit(value) {
        if (value > 3) {
            $('.account_div').show();

            if(value==8)
            {
                $('#payer_account_no_div_e').hide();
            }
            else
            {
                $('#payer_account_no_div_e').show();
            }

            if(value==4)
            {
                //....rocket....
                $('#l_payer_account_no_e').html("{{ Lang::get('messages.Donor Rocket No') }} <span  class='la-required'>*</span>");
                $('#l_payee_account_no_e').html("{{ Lang::get('messages.Recipient Rocket No') }} <span class='la-required'>*</span>");

                $('#payer_account_no_e').attr('placeholder',"{{ Lang::get('messages.Enter Your Rocket No') }}");

                $("#payee_account_no_r_e").empty();
                $('#payee_account_no_r_e').append('<?php echo $rocket_options;?>');
            }
            else if(value==5)
            {
                //....bkash....
                $('#l_payer_account_no_e').html("{{ Lang::get('messages.Donor Bkash No') }} <span class='la-required'>*</span>");
                $('#l_payee_account_no_e').html("{{ Lang::get('messages.Recipient Bkash No') }} <span class='la-required'>*</span>");

                $('#payer_account_no_e').attr('placeholder',"{{ Lang::get('messages.Enter Your Bkash No') }}");

                $("#payee_account_no_r_e").empty();
                $('#payee_account_no_r_e').append('<?php echo $bkash_options;?>');
            }
            else if(value==6)
            {
                //....Paypal....
                $('#l_payer_account_no_e').html("{{ Lang::get('messages.Donor Paypal Account No') }} <span class='la-required'>*</span>");
                $('#l_payee_account_no_e').html("{{ Lang::get('messages.Recipient Paypal Account No') }} <span class='la-required'>*</span>");

                $('#payer_account_no_e').attr('placeholder',"{{ Lang::get('messages.Enter Your Paypal Email') }}");

                $("#payee_account_no_r_e").empty();
                $('#payee_account_no_r_e').append('<?php echo $paypal_options;?>');
            }
            else if(value==7)
            {
                //....Bank Ttansfer....
                $('#l_payer_account_no_e').html("{{ Lang::get('messages.Donor Bank Account No') }} <span class='la-required'>*</span>");
                $('#l_payee_account_no_e').html("{{ Lang::get('messages.Recipient Bank Account No') }} <span class='la-required'>*</span>");
                $('#payer_account_no_e').attr('placeholder',"{{ Lang::get('messages.Enter Your Bank Account No') }}");

                $("#payee_account_no_r_e").empty();
                $('#payee_account_no_r_e').append('<?php echo $bank_options;?>');
            }
            else if(value==8)
            {
                //....Cash deposit Through bank....
                $('#l_payer_account_no_e').html("{{ Lang::get('messages.Donor Account No') }} <span class='la-required'>*</span>");
                $('#l_payee_account_no_e').html("{{ Lang::get('messages.Recipient Bank Account No') }} <span class='la-required'>*</span>");

                $("#payee_account_no_r_e").empty();
                $('#payee_account_no_r_e').append('<?php echo $bank_options;?>');
            }
        }
        else {
            $('.account_div').hide();
        }
    }

    // function account_hide_edit(value)
    // {
    //     if(value>3)
    //     {
    //         $('.account_div').show();

    //         if(value==4)
    //         {
    //             $('#l_payer_account_no_e').html("{{ Lang::get('messages.Donor Rocket No') }} <span class='la-required'>*</span> :");
    //             $('#l_payee_account_no_e').html("{{ Lang::get('messages.Recipient Rocket No') }} <span class='la-required'>*</span> :");
    //         }
    //         else if(value==5)
    //         {
    //             $('#l_payer_account_no_e').html("{{ Lang::get('messages.Donor Bkash No') }} <span class='la-required'>*</span> :");
    //             $('#l_payee_account_no_e').html("{{ Lang::get('messages.Recipient Bkash No') }} <span class='la-required'>*</span> :");
    //         }
    //         else if(value==6)
    //         {
    //             $('#l_payer_account_no_e').html("{{ Lang::get('messages.Donor Paypal Account No') }} <span class='la-required'>*</span> :");
    //             $('#l_payee_account_no_e').html("{{ Lang::get('messages.Recipient Paypal Account No') }} <span class='la-required'>*</span> :");
    //         }
    //         else if(value==7)
    //         {
    //             $('#l_payer_account_no_e').html("{{ Lang::get('messages.Donor Bank Account No') }} <span class='la-required'>*</span> :");
    //             $('#l_payee_account_no_e').html("{{ Lang::get('messages.Recipient Bank Account No') }} <span class='la-required'>*</span> :");
    //         }
    //         else
    //         {
    //             $('#l_payer_account_no_e').html("{{ Lang::get('messages.Donor Account No') }} <span>*</span> :");
    //             $('#l_payee_account_no_e').html("{{ Lang::get('messages.Recipient Account No') }} <span>*</span> :");
    //         }

    //     }
    //     else
    //     {
    //         $('.account_div').hide();
    //     }
    // }

</script>
@endpush

