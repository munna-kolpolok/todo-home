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
        <!--<div class="box-header"></div>-->
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' class="form-control" name="date" id="date"
                               placeholder="@lang('messages.Enter Date')"
                               value=" {{App\Helpers\CommonHelper::showDateFormat(date('Y-m-d')) }}"/>
                        <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select class="form-control" name="status" id="status">
                        <option>All</option>
                        <option value="1">Draft</option>
                        <option value="3">Approved</option>
                        <option value="2">Need Clarification</option>
                    </select>
                </div>
            </div>
        </div>

            <div class="box-body">
                <table id="example1" class="table table-bordered">
                    <thead>
                    <tr class="success">
                        <th>@lang('messages.No')</th>
                        <th>@lang('messages.Donor')</th>

                        <th>@lang('messages.Amount')</th>

                        <th>@lang('messages.Date')</th>

                        <th>Type</th>
                    <!-- <th>@lang('messages.Donor Message')</th> -->
                    <!-- <th>@lang('messages.Money')</th> -->

                        <th>@lang('messages.Status')</th>
                        <th>@lang('messages.Website')</th>
                    <!-- <th>@lang('messages.Comments')</th> -->
                        <th>@lang('messages.Actions')</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        @endsection

        @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
        @endpush

        @push('scripts')
        <script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
        <script>
            $(function () {
                const date = document.getElementById('date').value;
                const status = document.getElementById('status').value;

                var myTable=$('#example1').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                        type: "POST",
                        dataType: "json",
                        url: "{{ url('admin/inboxes/get_inboxes') }}",
                        data: {
                            date : date,
                            status : status,
                            _token: '{{csrf_token()}}'
                        }
                    },
                    "columns": [
                        { "data": "seralNo" },
                        { "data": "donor" },
                        { "data": "amount" },
                        { "data": "date" },
                        { "data": "type" },
                        { "data": "status" },
                        { "data": "website" },
                        { "data": "action" }

                    ]
                });
            });

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
