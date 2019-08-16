@extends("la.layouts.app")

@section("contentheader_title", trans("messages.PayPal"))
@section("contentheader_description", trans("messages.Paypal listing"))
@section("section", trans("messages.PayPal"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Paypal listing"))

@section("main-content")

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
                    <th>@lang('messages.Payment Date')</th>
                    <th>@lang('messages.Payer First Name')</th>
                    <th>@lang('messages.Payer Last Name')</th>
                    <th>@lang('messages.Email')</th>
                    <th>@lang('messages.Amount')</th>
                    <th>@lang('messages.Transaction Fee')</th>
                    <th>@lang('messages.Actions')</th>
                </tr>
                </thead>
                <tbody>

                @foreach($payments as $key=>$payment)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td><?php
                            if(isset($payment->payment_date)){
                                echo App\Helpers\CommonHelper::showDateTimeFormat($payment->payment_date);
                            }?>
                        </td>

                        <td>{{ $payment->payer_first_name or null}}</td>
                        <td>{{ $payment->payer_last_name or null}}</td>
                        <td>{{ $payment->payee_email or null }}</td>

                        <td>{{ $payment->amount }}</td>
                        <td>{{ $payment->transaction_fee }}</td>

                        <td>
                            <a href="{{ url(config('laraadmin.adminRoute') .'/paypal_payments/'.$payment->id) }}" class="btn btn-success btn-xs" target="_blank" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>
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
        $('#example1').DataTable( {
            responsive: false,
            columnDefs: [ { orderable: false, targets: [-1] }]
        } );
        $("#payment-add-form").validate({

        });
    });


</script>
@endpush
