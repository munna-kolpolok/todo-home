@extends('website.profile_layouts.app')


@section('profile-content')
    <div class="small-device-padding">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <!-- Start Status area -->
                    <div class="notika-status-area">
                        
                        <div class="row">
                            <a href="{{url('donors_scholarship')}}">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                                    <div class="website-traffic-ctn">
                                        <h2><span class="counter">{{ $scholarship_students->student or 0}}</span> Students</h2>
                                        <p>Total Sponsor in {{ $current_year }}</p>
                                    </div>
                                    <div class="donation-icon"><i class="fa fa-male" aria-hidden="true"></i></div>
                                </div>
                            </div>
                            </a>


                            <a href="{{url('donors/paypal_payments/'.$current_year)}}">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                                    <div class="website-traffic-ctn">
                                        <h2><span class="counter">{{ floatval($paypal_payment_sum_usd+$scholarship_donation_sum_usd+$donation_sum_usd) }}</span> USD</h2>
                                        <p>Total donation in {{ $current_year }}</p>
                                    </div>
                                    <div class="donation-icon"><i class="fa fa-usd" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            </a>

                            <!-- <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                                    <div class="website-traffic-ctn">
                                        <h2><span class="counter">5000</span>k</h2>
                                        <p>TK</p>
                                    </div>
                                    <div class="donation-icon"><i class="fi flaticon-donation-1"></i></div>
                                </div>
                            </div> -->

                        </div>
                    </div>
                </div>
                <!-- End Status area-->
            </div>


            <div class="row">
                <div class="col-md-12">
                    <!-- Start Status area -->
                    <div class="notika-status-area">
                        
                        <div class="row">


                            <a href="{{url('donors/ssl_payments/'.$current_year)}}">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                                    <div class="website-traffic-ctn">
                                        <h2><span class="counter">{{ floatval($ssl_payment_sum_bdt+$scholarship_donation_sum_bdt+$donation_sum_bdt) }}</span> BDT</h2>
                                        <p>Total donation in {{ $current_year }}</p>
                                    </div>
                                    <div class="donation-icon"><span class="amount-in-tk">৳</span></div>
                                </div>
                            </div>
                            </a>

                            <a href="{{url('donors/other_currency/'.$current_year)}}">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                                    <div class="website-traffic-ctn">

                                        <h2><span class="counter">{{ floatval($scholarship_donation_sum_oc+$donation_sum_oc) }}</span></h2>
                                        <p>Except BDT and USD in {{ $current_year }}</p>
                                    </div>
                                    <div class="donation-icon"><i class="fi flaticon-donation-1"></i></div>
                                </div>
                            </div>
                            </a>

                        </div>
                    </div>
                </div>
                <!-- End Status area-->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- Start Status area -->
                    <div class="notika-status-area">
                        
                        <div class="row">


                            <a href="{{url('donors/scholarship_donations/'.$current_year)}}">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                                    <div class="website-traffic-ctn">
                                        <h2>Scholarship Donations in  {{ $current_year }}</h2>
                                        <!-- <p>Total donation in {{ $current_year }}</p> -->
                                    </div>
                                    <!-- <div class="donation-icon"><i class="fi flaticon-donation-1"></i></div> -->
                                </div>
                            </div>
                            </a>

                            <a href="{{url('donors/all_donations/'.$current_year)}}">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                                    <div class="website-traffic-ctn">
                                        <h2>All Donations in {{ $current_year }}</h2>
                                        <!-- <p>Total donation in {{ $current_year }}</p> -->
                                    </div>
                                    <div class="donation-icon"></div>
                                </div>
                            </div>
                            </a>

                        </div>
                    </div>
                </div>
                <!-- End Status area-->
            </div>


        </div>
    </div>
@endsection

@push('scripts')

@endpush