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
        <div style="margin-top: 25px" class="col-md-6 pull-right">
           <div class="col-md-8">
               <div class="input-group input-daterange">
                   <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="dd/mm/yyyy"
                          placeholder="From:">
                   <div class="input-group-addon">To</div>
                   <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="dd/mm/yyyy"
                          placeholder="To:">
               </div>
           </div>
            <div class="col-md-4">
                <button class="btn btn-success" value="Refresh Page" onClick="window.location.reload()">
                    <i class="fa fa-refresh" aria-hidden="true"></i>
                    Refresh
                </button>
            </div>
        </div>
    </div>
    <!--<div class="box-header"></div>-->
    <div class="box-body">
        <table id="example1" class="table table-bordered">
            <thead>
            <tr class="success">
                <th>@lang('messages.No')</th>
                <th>@lang('messages.Donor')</th>
                <th>Payment Email</th>
                <th>@lang('messages.Amount')</th>

                <th>@lang('messages.Date')</th>

                <th>Type</th>
            <!-- <th>@lang('messages.Donor Message')</th> -->
            <!-- <th>@lang('messages.Money')</th> -->

                <th>@lang('messages.Status')</th>
                <th>@lang('messages.Website')</th>
                <th>@lang('messages.Comments')</th>
                <th>@lang('messages.Actions')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($values as $key=>$inbox)
                <tr>
                    <td>{{ ++$key }}</td>

                    <td>{{ $inbox->email or null }}</td>

                    <td>{{ $inbox->not_user_email or null }}</td>

                    <td>
                        <a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/'.$inbox->type.'/'.$inbox->id) }}">{{ App\Helpers\CommonHelper::decimalNumberFormat($inbox->amount) }} {{ $inbox->currency_name or null }}</a>
                    </td>

                    <td><?php
                        if (isset($inbox->date)) {
                            echo App\Helpers\CommonHelper::showDateFormat($inbox->date);
                        }?>
                    </td>

                    @if($inbox->type==1)
                        <td class="success">Offline</td>
                    @else
                        <td class="danger">Online</td>
                    @endif

                <!-- status start -->
                    @if($inbox->status==1)
                        <td>@lang('messages.Draft')</td>
                    @elseif($inbox->status==2)
                        <td class="danger">@lang('messages.Clarify')</td>
                    @elseif($inbox->status==3)
                        <td class="success">@lang('messages.Approved')</td>
                    @elseif($inbox->status==4)
                        <td class="warning">@lang('messages.Disapproved')</td>
                    @endif
                <!-- status end -->


                    <td>{{ $inbox->website_name or null }}</td>

                    <td>{{ str_limit($inbox->comments,10) }}</td>

                    @if($inbox->type=='1')
                    <!-- verification start -->
                        <td>{{--<a href="{{ url(config('laraadmin.adminRoute') .'/service/1/'.$inbox->id.'/'.'d_'.$inbox->user_id) }}" class="btn btn-default btn-xs" style="background-color: #ECF0F5;"> Sevice</a>--}}
                            @if($inbox->status<'3')
                                @if(!empty($inbox->attachment))
                                    <a href="{{ url($inbox->attachment)}}" class="btn btn-success btn-xs"
                                       data-toggle="tooltip" title="@lang('messages.Attachment')"
                                       target="_blank"><i class="fa fa-paperclip"></i></a>
                                @endif

                                @la_access("Inboxes", "edit")

                                @if($inbox->sector_id==1)

                                    <a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/1/'.$inbox->id.'/'.$inbox->user_id) }}"
                                       class="btn btn-success btn-xs" data-toggle="tooltip"
                                       title="@lang('messages.Sponsor')"><i class="fa fa-users"
                                                                            aria-hidden="true"></i>
                                        @lang('messages.Sponsor')</a>

                                @else

                                    <a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/status/3/'.$inbox->id) }}"
                                       class="btn btn-primary btn-xs confirm" data-toggle="tooltip"
                                       title="@lang('messages.Approve')"><i class="fa fa-thumbs-up"
                                                                            aria-hidden="true"></i>
                                        @lang('messages.Approve')</a>

                                    <a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/status/4/'.$inbox->id) }}"
                                       class="btn btn-danger btn-xs dis_confirm" data-toggle="tooltip"
                                       title="@lang('messages.Disapprove')"><i class="fa fa-thumbs-down"
                                                                               aria-hidden="true"></i>
                                        @lang('messages.Disapprove')</a>

                                @endif




                                <a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/'.$inbox->id.'/edit') }}"
                                   class="btn btn-warning btn-xs" data-toggle="tooltip"
                                   title="@lang('messages.Edit')">
                                    <i class="fa fa-edit"></i></a>

                                @la_access("Inboxes", "delete")
                                {!! Form::open(['action' => ['Admin\InboxesController@destroy',$inbox->id],'method' => 'delete','style'=>'display:inline']) !!}
                                <button class="btn btn-danger btn-xs"
                                        onclick="return confirm('Are you sure to delete this?')"
                                        data-toggle="tooltip" title="@lang('messages.Delete')"><i
                                            class="fa fa-times"></i></button>
                                {!! Form::close() !!}
                                @endla_access

                                @if($inbox->status=='2')
                                    <a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/status/1/'.$inbox->id) }}"
                                       class="btn btn-danger btn-xs confirm_clarify" data-toggle="tooltip"
                                       title="@lang('messages.No Need Clarification')"><i
                                                class="fa fa-toggle-on" aria-hidden="true"></i>
                                        @lang('messages.Clarify')</a>
                                @else
                                    <a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/status/2/'.$inbox->id) }}"
                                       class="btn btn-danger btn-xs confirm_clarify" data-toggle="tooltip"
                                       title="@lang('messages.Need Clarification')"><i class="fa fa-toggle-off"
                                                                                       aria-hidden="true"></i>
                                        @lang('messages.Clarify')</a>
                                @endif


                                @endla_access




                            @else
                                @if($inbox->status==3)

                                    <a href="{{ url(config('laraadmin.adminRoute') .'/service/1/'.$inbox->id.'/'.'d_'.$inbox->user_id) }}"
                                       class="btn btn-default btn-xs" style="background-color: #ECF0F5;"> Event <span
                                                class="badge badge-light">{{ App\Models\Service::where('inbox_id', $inbox->id)->count() }}</span></a>
                                    @if($inbox->scholarship_amount>0)

                                        <a href="{{ url('donation_scholarship_receipt/'.$inbox->id)}}"
                                           class="btn btn-warning btn-xs" data-toggle="tooltip"
                                           title="@lang('messages.Receipt')"><i
                                                    class="fa fa-download"></i>@lang('messages.Receipt')</a>
                                    @else
                                        <a href="{{ url('donation_receipt/1/'.$inbox->id.'/'.$inbox->website_id) }}"
                                           class="btn btn-warning btn-xs" data-toggle="tooltip"
                                           title="@lang('messages.Receipt')"><i
                                                    class="fa fa-download"></i> @lang('messages.Receipt')</a>
                                    @endif
                                @endif
                            @endif

                            <?php
                            $inbox_chat = App\Models\Inbox_Chat::where('inbox_id', $inbox->id)->latest()->first();
                            $inbox_chat_count = App\Models\Inbox_Chat::where('inbox_id', $inbox->id)->count();

                            ?>
                            <a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/'.$inbox->id) }}"
                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                               title="@lang('messages.Comments')">
                                <i class="fa fa-commenting" aria-hidden="true"></i>
                                @if(isset($inbox_chat->is_admin) && $inbox_chat->is_admin==0)
                                    Comments <span class="badge badge-light" style="color:red;">{{ $inbox_chat_count }}
                                        <i class="fa fa-bell" aria-hidden="true" style="color:red"></i></span>
                                @else
                                    @lang('messages.Comments') <span
                                            class="badge badge-light">{{ $inbox_chat_count }}</span>
                                @endif

                            </a>

                        </td>
                    @elseif($inbox->type=='2')
                    <!-- Paypal start -->
                        <td>
                            <a href="{{ url(config('laraadmin.adminRoute') .'/service/2/'.$inbox->id.'/'.'d_'.$inbox->user_id) }}"
                               class="btn btn-default btn-xs" style="background-color: #ECF0F5;"> Event <span
                                        class="badge badge-light">{{ App\Models\Service::where('paypal_payment_id', $inbox->id)->count() }}</span></a>
                            @if($inbox->donate_way=='1' && $inbox->user_id>0 && !empty($inbox->comments))
                                <a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/2/'.$inbox->id.'/'.$inbox->user_id) }}"
                                   class="btn btn-success btn-xs" data-toggle="tooltip"
                                   title="@lang('messages.Sponsor')"><i class="fa fa-users"
                                                                        aria-hidden="true"></i>
                                    @lang('messages.Sponsor')</a>
                            @endif
                            <a href="{{ url('donation_receipt/2/'.$inbox->id.'/'.$inbox->website_id)}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip"
                               title="@lang('messages.Receipt')"><i
                                        class="fa fa-download"></i>@lang('messages.Receipt')</a>

                        </td>
                    @elseif($inbox->type=='3')
                    <!-- SSL start -->

                        <td>
                            <a href="{{ url(config('laraadmin.adminRoute') .'/service/3/'.$inbox->id.'/'.'d_'.$inbox->user_id) }}"
                               class="btn btn-default btn-xs" style="background-color: #ECF0F5;"> Event <span
                                        class="badge badge-light">{{ App\Models\Service::where('ssl_payment_id', $inbox->id)->count() }}</span></a>
                            @if($inbox->donate_way=='1' && $inbox->user_id>0 && !empty($inbox->comments))
                                <a href="{{ url(config('laraadmin.adminRoute') .'/inboxes/3/'.$inbox->id.'/'.$inbox->user_id) }}"
                                   class="btn btn-success btn-xs" data-toggle="tooltip"
                                   title="@lang('messages.Sponsor')"><i class="fa fa-users"
                                                                        aria-hidden="true"></i>
                                    @lang('messages.Sponsor')</a>
                            @endif

                            <a href="{{ url('donation_receipt/3/'.$inbox->id.'/'.$inbox->website_id)}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip"
                               title="@lang('messages.Receipt')"><i
                                        class="fa fa-download"></i>@lang('messages.Receipt')</a>
                        </td>

                    @endif

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
<style>
    .datepicker-days {
        cursor: pointer;
    }

    .top {
        display: -webkit-box;
    }

    div.dataTables_wrapper div.dataTables_filter {
        margin-left: 40px;
        border-radius: 0;
    }

    .content-wrapper {
        background-color: #fff;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
{{--Data table export options--}}
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/buttons.print.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>


<script>
    // Bootstrap datepicker
    $('.input-daterange input').each(function () {
        $(this).datepicker({
            autoclose: true,
            todayHighlight: true
        })
    });
    $(function () {
        var table = $('#example1').DataTable({
            responsive: false,
            stateSave: true,
            paging: true,
            ordering: true,
            dom: '<"top"Bf>rt<"bottom"lip><"clear">',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            columnDefs: [{orderable: false, targets: [-1]}]

        });

        // Re-draw the table when the a date range filter changes
        $('.date-range-filter').change(function () {
            var min = $('#min-date').val();
            var max = $('#max-date').val();
            // Extend dataTables search
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#min-date').val();
                    var max = $('#max-date').val();
                    var currentDate = data[3] || 0; // Our date column in the table
                    var compareDate = moment(currentDate, "DD/MM/YYYY");
                    var startDate = moment(min, "DD/MM/YYYY");
                    var endDate = moment(max, "DD/MM/YYYY");
                    if (compareDate.isBetween(startDate.subtract(1, 'day'), endDate.add(1, 'day'))) {
                        return true;
                    }
                    return false;
                }
            );
            if (min !== '' && max !== '') {
                table.draw();
            }
        });
    });

    /* Custom filtering function which will search data in column four between two values */


    $('a.confirm').confirm({
        title: 'Confirm!',
        content: "Are you sure to approve this?",
    });

    $('a.confirm_clarify').confirm({
        title: 'Confirm!',
        content: "Are you sure to clarify this?",
    });

    $('a.dis_confirm').confirm({
        title: 'Confirm!',
        content: "Are you sure to disapprove this?",
    });


</script>
@endpush
