@extends('website.profile_layouts.app')


@section('profile-content')

    <?php
    $bkash_options='';
    $rocket_options='';
    $paypal_options='';
    $bank_options='';
    foreach($accounts as $account){ 
        if($account->type=='Paypal')
        {
            $paypal_options.='<option value="'.$account->name.'">'.$account->name.'</option>';
        }
        elseif($account->type=='Bank')
        {
            $bank_options.='<option value="'.$account->name.'">'.$account->name.'</option>';
        }
        elseif($account->type=='Bkash')
        {
            $bkash_options.='<option value="'.$account->name.'">'.$account->name.'</option>';
        }
        elseif($account->type=='Rocket')
        {
            $rocket_options.='<option value="'.$account->name.'">'.$account->name.'</option>';
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
                <!-- start blog-main-content -->
                <div class="box box-success">
                    <div class="box-body">
                        <table style="margin-bottom: 0" id="example1" class="table table-bordered">
                            <thead>
                            <tr class="success">
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
                                <tr @if($inbox->status=='2')  class="danger" @elseif($inbox->status=='3')  class="success" @endif>
                                    <td>{{ App\Helpers\CommonHelper::decimalNumberFormat($inbox->amount) }}  {{ $inbox->currency->currency_code or null }}</td>
                                    <td>{{ $inbox->sector->name or null }}</td>
                                    <td>{{ $inbox->payment_method->name or null }}</td>

                                    <td><?php
                                        if (isset($inbox->created_at)) {
                                            echo App\Helpers\CommonHelper::showDateTimeFormat($inbox->date);
                                        }?>
                                    </td>
                                    
                                    <td>@lang('messages.Offline')</td>


                                    @if($inbox->status==1)
                                        <td>@lang('messages.Draft')</td>
                                    @elseif($inbox->status==2)
                                        <td class="danger">@lang('messages.Clarify')</td>
                                    @elseif($inbox->status==3)  
                                        <td class="success">@lang('messages.Approved')</td>  
                                    @elseif($inbox->status==4)
                                        <td class="warning">@lang('messages.Disapproved')</td>
                                    @endif

                                    <td>

                                        @if(!empty($inbox->attachment))
                                            <a href="{{ url($inbox->attachment)}}" class="btn btn-success btn-xs"
                                               data-toggle="tooltip" title="@lang('messages.Attachment')"><i
                                                        class="fa fa-paperclip"></i></a>
                                        @endif
                                        @if($inbox->status<'3')
                                        <!--hidden input-->
                                            <input type="hidden" id="smile-img-{{$inbox->id}}"
                                                   value="{{$inbox->attachment}}">
                                            <input type="hidden" id="base_url" value="{{url('/')}}">
                                            <!--hidden input-->
                                            <input type="hidden" id="smile-img-{{$inbox->id}}"
                                                   value="{{$inbox->attachment}}">
                                            <input type="hidden" id="base_url" value="{{url('/')}}">
                                            <input type="hidden" class="inbox_id" value="{{$inbox->id}}">

                                            <a href="#" class="btn btn-info btn-xs edit_donation" data-toggle="modal"
                                               id="edit_donation" data-target="#edit-post-modal"
                                               title="@lang('messages.Edit')"><i class="fa fa-pencil-square-o"
                                                                                 aria-hidden="true"></i>
                                            </a>
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
                                </tr>
                            </tbody>
                        </table>
                        <!--Chat box start-->
                        <?php
                        $inbox_chats=$inbox->inboxChat;
                        ?>

                        <div class="post-wrapper">
                            @if(count($inbox_chats)=='0' && $inbox->status>'2')
                                <h2>@lang('messages.No Comments')</h2>
                            @else
                                <div class="panel panel-default">
                                    <div class="panel-body">


                                        <div class="scroll-chat-box-wrapper">
                                            <div class="scroll-chat-box">

                                                @foreach($inbox_chats as $inbox_chat)
                                                    @if($inbox_chat->is_admin==1)
                                                        <div  style="background: #f6f8fa; padding: 10px; margin-bottom: 10px" class="media">
                                                            <div class="media-body">
                                                                <h4 class="media-heading" style="color: #f69033">@lang('messages.Bidyanondo') <small><i>{{ $inbox_chat->created_at or null }}</i></small></h4>

                                                                @if($inbox_chat->is_file==1)
                                                                    <a href="{{ url($inbox_chat->comments)}}"><i class="fa fa-download" aria-hidden="true"></i> @lang('messages.Click here to see the attachment')</a>
                                                                @else
                                                                    <pre>{{ $inbox_chat->comments or null }}</pre>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <h4 class="media-heading">{{$user_name or null}} <small><i>{{ $inbox_chat->created_at or null }}</i></small></h4>
                                                                @if($inbox_chat->is_file==1)
                                                                    <a href="{{ url($inbox_chat->comments)}}"><i class="fa fa-download" aria-hidden="true"></i> @lang('messages.Click here to see the attachment')</a>
                                                                @else
                                                                    <pre>{{ $inbox_chat->comments or null }}</pre>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>



                                    @if($inbox->status<'3')

                                        <!-- <form class="form-inline"> -->
                                            <form method="POST" class="form-inline"
                                                  role="form" action="{{url('/save_inbox_chat')}}" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="inbox_id" value="{{ $inbox->id }}">
                                                <textarea style="padding-left: 10px" placeholder="@lang('messages.Write your comment here!')" id="comments" class="pb-cmnt-textarea" name="comments"></textarea>
                                                <input type="file" name="comment_attachment" class="comment_attachment">
                                                <button style="margin-top: -23px;" type="submit" class="btn btn-primary btn-sm pull-right">@lang('messages.Send')</button>

                                            </form>
                                        @endif
                                    </div>
                                </div>


                            @endif
                        </div>
                        <!--Chat box end-->
                    </div>
                </div>
                <!-- end blog-main-content -->
            </div>
        </div>
    </div>

    <!--modal start-->
    {{--@if(request()->cookie('locale')=='bn')
            --}}{{--Bangla Lan--}}{{--
        @include('website.donors.reports.common_clarification_edit_modal_bn')
    @else--}}
    {{--English Lan--}}
        @include('website.donors.reports.common_clarification_edit_modal')
    {{--@endif--}}
    <!--modal end-->

@endsection

@push('style')
<link href="{{ asset('la-assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ asset('jquery-confirm-v3.2.0/css/jquery-confirm.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>

<!-- jquery.validate + select2 -->
<script src="{{ asset('la-assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>

<script src="{{ asset('jquery-confirm-v3.2.0/js/jquery-confirm.min.js') }}" type="text/javascript"></script>

<script>

    $('.add_amount').keyup(function() {
        $('span.error-keyup-1').hide();
        var inputVal = $(this).val();
        var numericReg = /^\d*[0-9]$/;
        if(!numericReg.test(inputVal)) {
            this.value=this.value.replace(/[^0-9]/g,'');
            $(this).after('<span style="color: #ed3237; font-size: 12px" class="error error-keyup-1">Numeric characters only.</span>');
        }
    });
/*
    $('#donor_message').keyup(function() {
        var data = $(this).val();
        var dataFull = data.replace(/[^\w\s]/gi, '');
        $('#donor_message').val(dataFull);
    });

    $('#comments').keyup(function() {
        var data = $(this).val();
        var dataFull = data.replace(/[^\w\s]/gi, '');
        $('#comments').val(dataFull);
    });
        */

    
    $( document ).ready(function() {
        $(".select2_edit").select2({
            dropdownParent: $("#edit-post-modal")
        });

        $('#datetimepicker2').datetimepicker({
            format: 'DD/MM/YYYY',
            maxDate: new Date()
        });

        /*Edit donation modal value set*/
        $('.edit_donation').on('click', function () {
            const inbox_id = $(this).prev().val();
            /*File download*/
            var imageSrc = $(this).prev().prev().prev().val();
            if (imageSrc !== '') {
                var base_url = $(this).prev().prev().val() + '/';
                var image_src = base_url + imageSrc;
                var attachment = 'attachment-download';
                $('#' + attachment).show().attr('href', image_src);
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
                    $('#date').val(response.date);

                    var sector_id = response.sector_id;
                    var payment_id = response.payment_method_id;
                    var currency_id = response.currency_id;
                    $('#sector_id').val(sector_id).trigger('change.select2');
                    $('#currency_id').val(currency_id).trigger('change.select2');
                    $('#payment_method_id').val(payment_id).trigger('change.select2');

                    $('#payee_account_no_r_e').val(response.payee_account_no).trigger('change.select2');

                    $('#inbox-edit-form').attr('action', "{{url('/donors')}}"+'/'+inbox_id);


                }
            });
        });

        $("#inbox-edit-form").validate({
            submitHandler: function(form) { 
                $("#update_button").addClass("disabled", true);
                $("#update_button").html("<?php echo Lang::get('messages.Processing');?> <i class='fa fa-spinner fa-spin'></i>");
                form.submit(); 
            }
        });

        /*Comments box selected*/
        $('#comments').focus();

        /*Scroll down*/
        var elements = document.querySelectorAll(".scroll-chat-box");
        elements.forEach(function (element) {
            element.scrollTop = element.scrollHeight;
        });

    });

    /*Chat end*/
    $('.pb-cmnt-textarea').keydown(function(event) {
        // enter has keyCode = 13, change it if you want to use another button
        if (event.keyCode == 13) {
            this.form.submit();
            return false;
        }
    });

    $('.comment_attachment').on('change', function () {
        this.form.submit();
        return false;
    });

    $('a.confirm').confirm({
        title: '@lang('messages.Confirm')!',
        content: "@lang('messages.Are you sure to delete this') ?",
    });

    function inbox_edit()
    {
        var currency_id=$('#currency_id').val();
        var amount=$('#amount').val();

        if(currency_id>0 && amount>0)
        {
            var url="{{ url('inbox_form_submit_check') }}";
            $.post(url,{'currency_id':currency_id,'amount':amount},function( data ) {
                if(data.check==1)
                {
                    $( "#inbox-edit-form" ).submit();
                }
                else
                {
                    $.alert(data.msg+data.min_donate_amount+ ' '+data.currency_name);
                }
            });
        }
        else
        {
            $("#inbox-edit-form").submit();
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

</script>

@endpush


