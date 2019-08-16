@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Transactions"))
@section("contentheader_description", trans("messages.Transactions listing"))
@section("section", trans("messages.Transactions"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Transactions listing"))

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
        <!--<div class="box-header"></div>-->
        <div class="filter-box"
             style="border: 1px solid #eeeeee; padding: 10px; margin: 10px 10px;box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.12)">
            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="datepicker1">From : </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group date" data-provide="datepicker" id="datepicker1">
                        <input type="text" class="form-control date-range-filter" id="from" value={{$startDate}}>
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="datepicker2">To : </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group date" data-provide="datepicker" id="datepicker2">
                        <input type="text" class="form-control date-range-filter" id="to" value={{$endDate}}>
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="website">Website:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select class="form-control" name="website" id="website" onchange="$('#search').click()">
                            <option value="">All</option>
                            @foreach($websites as $website)
                                <option value={{$website->id}}>{{$website->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="type">Type : </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select class="form-control" name="type" id="type" onchange="$('#search').click()">
                            <option value="">All</option>
                            <option value="2">Online</option>
                            <option value="1">Offline</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="type">Email : </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" id="email" class="form-control" placeholder="example@mail.com">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="type">&nbsp;</label>
                    </div>
                </div>
                <div class="col-md-3">
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
                    <th>@lang('messages.Donor')</th>
                    <th>Payment Email</th>
                    <th>@lang('messages.Amount')</th>
                    <th>@lang('messages.Date')</th>
                    <th>Type</th>
                    <th>Payment Method</th>
                    <th>@lang('messages.Website')</th>
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
                    <h4 class="modal-title">Transaction Details</h4>
                </div>
                <div class="modal-body">
                    <div class="transaction-info">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td>Project</td>
                                        <td>education program</td>
                                    </tr>
                                    <tr>
                                        <td>Sector</td>
                                        <td>Bidiyanodo</td>
                                    </tr>
                                    <tr>
                                        <td>Students</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Food Project</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Food Items</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Donation Package</td>
                                        <td>Bidiyanodo</td>
                                    </tr>
                                    <tr>
                                        <td>Unit No</td>
                                        <td></td>
                                    </tr>
                                    <tr class="success">
                                        <td>Website</td>
                                        <td>Bidiyanodo</td>
                                    </tr>
                                    <tr>
                                        <td>Ip Address</td>
                                        <td>Paypal</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr class="success">
                                        <td>Amount</td>
                                        <td>10 usd</td>
                                    </tr>
                                    <tr>
                                        <td>Amount(TK)</td>
                                        <td>820</td>
                                    </tr>
                                    <tr class="success">
                                        <td>Date</td>
                                        <td>2019-12-12</td>
                                    </tr>
                                    <tr>
                                        <td>Transaction Fee</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>Type</td>
                                        <td>Online</td>
                                    </tr>
                                    <tr>
                                        <td>Payment Method</td>
                                        <td>Paypal</td>
                                    </tr>
                                    <tr>
                                        <td>Payer Email</td>
                                        <td>Paypal</td>
                                    </tr>
                                    <tr>
                                        <td>Donor's Account No</td>
                                        <td>Paypal</td>
                                    </tr>
                                    <tr>
                                        <td>Recipient Account No</td>
                                        <td>Paypal</td>
                                    </tr>
                                    <tr class="success">
                                        <td>Donor</td>
                                        <td>Paypal</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <pre>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Consequatur deleniti esse et impedit laudantium qui.</pre>
                    <a class="btn btn-success" id="closemodal">Close</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

@endsection

@push('styles')
<style>
    a:hover {
        cursor: pointer;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
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
        const url = "{{url(config('laraadmin.adminRoute') .'/transactions/details')}}"+'/'+ type + '/' + id;
        $.ajax({
            type: "GET",
            dataType: "json",
            url: url,
            success: function (response) {
                console.log(response);
            }
        });
    }


    $(function () {
        const from = document.getElementById('from').value;
        const to = document.getElementById('to').value;
        const website = document.getElementById('website').value;
        const type = document.getElementById('type').value;
        const email = document.getElementById('email').value;

        fill_datatable(from, to, website, type, email);
        function fill_datatable(from, to, website, type, email) {
            var myTable = $('#example1').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": false,
                "dom": '<"top"Bf>rt<"bottom"lip><"clear">',
                "ajax": {
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('admin/transactions/get-inboxes') }}",
                    data: {
                        startDate: from,
                        endDate: to,
                        website_id: website,
                        type: type,
                        email: email,
                        _token: '{{csrf_token()}}'
                    }
                },
                "columns": [
                    {"data": "seralNo"},
                    {"data": "donor"},
                    {"data": "Payment Email"},
                    {"data": "amount"},
                    {"data": "date"},
                    {"data": "type"},
                    {"data": "Payment Method"},
                    {"data": "website"}
                ]
            });
        }

        $('#search').on('click', function () {
            const filter_from = document.getElementById('from').value;
            const filter_to = document.getElementById('to').value;
            const filter_website = document.getElementById('website').value;
            const filter_type = document.getElementById('type').value;
            const filter_email = document.getElementById('email').value;
            $('#example1').DataTable().destroy();
            fill_datatable(filter_from, filter_to, filter_website, filter_type, filter_email);
        });
    });


</script>
@endpush
