@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Inboxes"))
@section("contentheader_description", trans("messages.Inboxes listing"))
@section("section", trans("messages.Inboxes"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Inboxes listing"))

@section("headerElems")
    @la_access("Inboxes", "create")
        <a href="{{ url(config('laraadmin.adminRoute') . '/inboxes/create') }}" class="btn btn-success btn-sm pull-right">Old Version</a>
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
        <!--<div class="box-header"></div>-->
        <div class="filter-box"
             style="border: 1px solid #eeeeee; padding: 10px; margin: 10px 10px;box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.12)">
            <div class="row">
                
                <div class="col-md-3">
                    <label for="datepicker1">From : </label>
                    <div class="input-group date" data-provide="datepicker" id="datepicker1">
                        <input type="text" class="form-control date-range-filter" id="from" value={{$startDate}}>
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="datepicker2">To : </label>
                    <div class="input-group date" data-provide="datepicker" id="datepicker2">
                        <input type="text" class="form-control date-range-filter" id="to" value={{$endDate}}>
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="website">Website:</label>
                    <div class="form-group">
                        <select class="form-control" name="website" id="website" onchange="$('#search').click()">
                            <option value="">All</option>
                            @foreach($websites as $website)
                                <option value="{{$website->id}}">{{$website->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="type">Type : </label>
                    <div class="form-group">
                        <select class="form-control" name="type" id="type" onchange="$('#search').click()">
                            <option value="">All</option>
                            <option value="4">Online</option>
                            <option value="1">Offline</option>
                            <option value="2">Paypal</option>
                            <option value="3">SSL</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <label for="website">Payment Methods:</label>
                    <div class="form-group">
                        <select class="form-control" name="payment_method_id" id="payment_method_id" onchange="$('#search').click()">
                            <option value="">All</option>
                            @foreach($payment_methods as $payment_method)
                                <option value="{{$payment_method->name}}">{{$payment_method->name}}</option>
                            @endforeach
                            <option value="SSL">SSL</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="website">Status:</label>
                    <div class="form-group">
                        <select class="form-control" id="status_id" onchange="$('#search').click()">
                            <option value="">All</option>
                            <option value="1">Draft</option>
                            <option value="2">Clarify</option>
                            <option value="3">Approved</option>
                            <option value="4">Disapproved</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="type">Donor Account No : </label>
                    <div class="form-group">
                        <input type="text" id="payer_account_no" class="form-control" placeholder="Bkash/Rocket/Bank/Paypal">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="type">Recipient Account No : </label>
                    <div class="form-group">
                        <input type="text" id="payee_account_no" class="form-control" placeholder="Bkash/Rocket/Bank/Paypal">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="type">Email : </label>
                    <div class="form-group">
                        <input type="text" id="email" class="form-control" placeholder="example@mail.com">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <label for="type">Comments : </label>
                    <div class="form-group">
                        <input type="text" id="comments" class="form-control" placeholder="Comments">
                    </div>
                </div>

                
                <div class="col-md-2">
                    <label for="type">Amount : </label>
                    <div class="form-group">
                        <input type="text" id="amount" class="form-control" placeholder="Amount">
                    </div>
                </div>
                <div class="col-md-1">
                    <label for="type">Sign</label>
                    <div class="form-group">
                        <select class="form-control" id="sign_id" onchange="$('#search').click()">
                            <option value=">=">>=</option>
                            <option value="<="><=</option>
                            <option value="=">=</option>
                            <option value=">">></option>
                            <option value="<"><</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="type"></label>
                    <div class="form-group">
                        <button type="button" class="btn btn-info btn-block" id="search">
                            <span class="glyphicon glyphicon-search"></span> Search
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="box-body">
            <table id="example1" class="table table-bordered">
                <thead>
                <tr class="success">
                    <th>@lang('messages.No')</th>
                    <!-- <th>@lang('messages.Donor')</th> -->
                    <th>Email</th>
                    <th>@lang('messages.Amount')</th>
                    <th>@lang('messages.Date')</th>
                    <th>Type</th>
                    <th>Method</th>
                    <th>Donor Account</th>
                    <th>@lang('messages.Website')</th>
                    <th>Comments</th>
                    <th>Status</th>
                    <th>@lang('messages.Action')</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    {{--Details modal--}}
    <div class="modal fade" id="modalCompose">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Details</h4>
                </div>
                <div class="modal-body">
                    <div id="transaction-info"></div>
                </div>
                <div class="modal-footer">
                    <div id="message"></div>
                    <a class="btn btn-success" id="closemodal">Close</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

@endsection

@push('styles')
<style>
    .btn{
        margin-bottom: 2px;
        margin-right: 2px;
    }
    a:hover {
        cursor: pointer;
    }
    #message {
        margin-bottom: 10px;
    }

    #message-box {
        border: 1px solid #CCCCCC;
        background-color: #F5F5F5;
        padding: 5px 10px;
        border-radius: 5px;
        min-height: 25px;
        text-align: left;
    }

</style>
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/buttons.print.min.js') }}"></script>

<script>
    $(document).keyup(function (event) {
        if (event.keyCode === 13) {
            $("#search").click();
        }
    });

    $('#closemodal').click(function () {
        $('#modalCompose').modal('hide');
    });

    //load dynamic transaction details
    function loadTransactionDetails(type, id) {
        const url = "{{url(config('laraadmin.adminRoute') .'/inboxes/details')}}"+'/'+ type + '/' + id;
        $.ajax({
            type: "GET",
            dataType: "json",
            url: url,
            success: function (response) {
                const transaction = 'transaction-info';
                const message = 'message';
                $('#'+transaction).empty();
                $('#'+message).empty();
                $('#'+transaction).html(response.transactionInfo);
                $('#'+message).html(response.message);
            }
        });
    }

    $(function () {
        const from = document.getElementById('from').value;
        const to = document.getElementById('to').value;
        const website = document.getElementById('website').value;
        const type = document.getElementById('type').value;
        const email = document.getElementById('email').value;
        const comments = document.getElementById('comments').value;
        const payer_account_no = document.getElementById('payer_account_no').value;
        const payment_method_id = document.getElementById('payment_method_id').value;
        const status_id = document.getElementById('status_id').value;
        const payee_account_no = document.getElementById('payee_account_no').value;
        const sign_id = document.getElementById('sign_id').value;
        const amount = document.getElementById('amount').value;

        fill_datatable(from, to, website, type, email,comments,payer_account_no,payment_method_id,status_id,payee_account_no,sign_id,amount);
        function fill_datatable(from, to, website, type, email,comments,payer_account_no,payment_method_id,status_id,payee_account_no,sign_id,amount) {
            var myTable = $('#example1').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "searching": false,
                "dom": '<"top"Bf>rt<"bottom"lip><"clear">',
                buttons: [
                    'csv', 'excel', 'pdf', 'print'
                ],
                "ajax": {
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('admin/inboxes/get_inboxes') }}",
                    data: {
                        startDate: from,
                        endDate: to,
                        website_id: website,
                        type: type,
                        email: email,
                        comments:comments,
                        payer_account_no:payer_account_no,
                        payment_method_id:payment_method_id,
                        status_id:status_id,
                        payee_account_no:payee_account_no,
                        sign_id:sign_id,
                        amount:amount,
                        _token: '{{csrf_token()}}'
                    }
                },
                "columns": [
                    {"data": "seralNo"},
                    {"data": "Email"},
                    {"data": "amount"},
                    {"data": "date"},
                    {"data": "type"},
                    {"data": "Payment Method"},
                    {"data": "Donor Account"},
                    {"data": "website"},
                    {"data": "comments"},
                    {"data": "status"},
                    {"data": "action"}
                ]
            });
        }

        $('#search').on('click', function () {
            const filter_from = document.getElementById('from').value;
            const filter_to = document.getElementById('to').value;
            if(!filter_from || !filter_to)
            {
                $.alert('Please select a date range');
                retutn;
            }
            const filter_website = document.getElementById('website').value;
            const filter_type = document.getElementById('type').value;
            const filter_email = document.getElementById('email').value;
            const filter_comments = document.getElementById('comments').value;
            const payer_account_no = document.getElementById('payer_account_no').value;
            const payment_method_id = document.getElementById('payment_method_id').value;
            const status_id = document.getElementById('status_id').value;
            const payee_account_no = document.getElementById('payee_account_no').value;
            const sign_id = document.getElementById('sign_id').value;
            const amount = document.getElementById('amount').value;
            
            $('#example1').DataTable().destroy();
            fill_datatable(filter_from, filter_to, filter_website, filter_type, filter_email,filter_comments,payer_account_no,payment_method_id,status_id,payee_account_no,sign_id,amount);
        });
    });


</script>
@endpush
