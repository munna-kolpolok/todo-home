@extends('website.profile_layouts.app')


@section('profile-content')

  <div class="small-device-padding">
        <div class="col-md-9">
            <!-- start blog-main-content -->
            <section class="blog-main-content">
                <div class="breadcomb-list">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                            <div class="breadcomb-wp">
                                <div class="breadcomb-icon">
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                </div>
                                <div style="width: 100%" class="breadcomb-ctn">
                                    <h2 style="line-height: 48px; color: #21c292">Donation List of USD in {{ $current_year }}</h2>
                                    <div id="no-more-tables">
                                        <table class="col-md-12 table-bordered table-striped table-condensed cf">
                                            <thead class="cf">
                                            <tr>
                                                <th>Date</th>
                                                <th>Currency</th>
                                                <th>Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php $total_sum=0;?>
                                                @foreach($paypals as $key => $value)
                                                <tr>
                                                    <td data-title="Date">{{$value->payment_date}}</td>
                                                    <td data-title="currency">{{$value->currency}}</td>
                                                    <td data-title="amount" align="right">{{$value->amount}}</td>
                                                </tr>
                                                <?php $total_sum+=$value->amount;?>
                                                @endforeach
                                                

                                                @foreach($scholarships as $key => $value)
                                                <tr>
                                                    <td data-title="Date">{{$value->donate_date or null}}</td>
                                                    <td data-title="currency">{{$value->currency->currency_code or null}}</td>
                                                    <td data-title="amount" align="right">{{$value->amount}}</td>
                                                </tr>
                                                <?php $total_sum+=$value->amount;?>
                                                @endforeach

                                                @foreach($donations as $key => $value)
                                                <tr>
                                                    <td data-title="Date">{{$value->donate_date or null}}</td>
                                                    <td data-title="currency">{{$value->currency->currency_code or null}}</td>
                                                    <td data-title="amount" align="right">{{$value->amount}}</td>
                                                </tr>
                                                <?php $total_sum+=$value->amount;?>
                                                @endforeach

                                                <tr>
                                                   <td colspan="2" align="right"><b>Total</b></td>
                                                   <td align="right">{{ number_format($total_sum, 2, '.', '')}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end blog-main-content -->
        </div>
    </div>

@endsection

