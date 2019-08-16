@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Scholarship Donation"))
@section("contentheader_description", trans("messages.Scholarship Donation listing"))
@section("section", trans("messages.Scholarship Donation"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Scholarship Donation listing"))

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
        <div class="box-body">
            <table id="example1" class="table table-bordered">
                <thead>
                <tr class="success">
                    <th>@lang('messages.Serial No.')</th>
                    <th>@lang('messages.Donor Name')</th>
                    <th>@lang('messages.Donor Email')</th>
                    <th>@lang('messages.Student Id Card')</th>
                    <th>@lang('messages.Scholarship Session')</th>
                    <!-- <th>@lang('messages.Currency')</th> -->
                    <th>@lang('messages.Amount')</th>

                    <th>Conversion amount</th>
                    <th>Amount (TK)</th>

                    <th>@lang('messages.Type')</th>
                    <th>@lang('messages.Payment Method')</th>
                </tr>
                </thead>
                <tbody>

                @foreach($donations as $key=>$value)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $value->user->name or null}}</td>
                        <td>{{ $value->user->email or null}}</td>
                        <td>{{ $value->scholarship->student->id_card or null }}
                        </td>
                        <td>{{ $value->scholarship->year or null }}</td>
                        
                        <td>{{ App\Helpers\CommonHelper::decimalNumberFormat($value->amount) }} {{ $value->currency->currency_name or null }}</td>

                        <td align="right">{{ App\Helpers\CommonHelper::decimalNumberFormat($value->tk_convert_amount) }}</td>
                        <td align="right">{{ App\Helpers\CommonHelper::decimalNumberFormat($value->tk_amount) }}</td>

                        <td>
                            @if( $value->type == 1)
                                <span class='label label-default'>Donate</span>
                            @else
                                <span class='label label-danger'>Return</span>
                        @endif
                        <td>
                            @if($value->payment_method == 1)
                                <span class='label label-success'>Manual</span>
                            @elseif($value->payment_method == 2)
                                <span class='label label-info'>PayPal</span>
                            @else
                                <span class='label label-danger'>SSLCommerze</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
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
        $('#example1').DataTable({
            responsive: false,
            columnDefs: [{orderable: false, targets: [-1]}]
        });
    });
</script>
@endpush
