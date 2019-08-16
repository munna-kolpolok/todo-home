@extends("la.layouts.app")


@section("main-content")
<div id="page-content" class="profile2">
    <div class="bg-success clearfix">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-3">
                    <div class="profile-icon text-primary"><i class="fa fa-angle-double-right"></i></div>
                </div>
                <div class="col-md-9">
                    <h4 class="name">{{ $user->name or null }}</h4>              
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h4 class="name">{{ $user->email or null }}</h4> 
        </div>
    </div>

    <ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
        <li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/donation_packages') }}" data-toggle="tooltip" data-placement="right" title="Back to inboxes"><i class="fa fa-chevron-left"></i>Go Back</a></li>    
    </ul>

    <div class="tab-content">
        <div class="box box-success">
    <!--<div class="box-header"></div>-->
    <div class="box-body">
        <table id="example1" class="table table-bordered">
        <thead>
        <tr class="success">
            <th>@lang('messages.Serial No.')</th>
            <th>@lang('messages.Payment Date')</th>
            <th>@lang('messages.Amount')</th>
            <th>Currency</th>
            <th>Amount (TK)</th>
            <th>Kids No</th>
            <th>Donate Plan</th>
            <th>Payment</th>
        </tr>
        </thead>
        <tbody>
            
            @foreach($payment_lists as $key=>$value)
            <tr>
                <td>{{ ++$key }}</td>
                <td>
                    <?php
                    if(isset($value->payment_date)){
                        echo App\Helpers\CommonHelper::showDateTimeFormat($value->payment_date);
                    }?>
                </td>
                <td>{{ App\Helpers\CommonHelper::decimalNumberFormat($value->amount)}}</td>
                <td>{{ $value->currency_name or null }}</td>
                <td>{{ App\Helpers\CommonHelper::decimalNumberFormat($value->tk_amount)}}</td>
                <td>{{ $value->no_unit or null}}</td>
                <td>
                    @if($value->donate_plan == 1)
                        <span class="">Monthly</span>
                    @elseif($value->donate_plan == 6)
                        <span class="">Half Yearly</span>
                    @elseif($value->donate_plan == 12)
                        <span class="">Yearly</span>
                    @endif
                </td>
                <td>{{ $value->payment or null}}</td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
</div>      
    </div>
    </div>
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
});
</script>
@endpush
