<?php
$requestSegment1 = \Request::segment(1);
$requestSegment2 = \Request::segment(2);
$requestSegment3 = \Request::segment(3);
$requestSegment7 = \Request::segment(7);

if ($requestSegment1 == 'donors' && $requestSegment2 == null) {
    $donorSelected = 'selected';
} else {
    $donorSelected = '';
}

if ($requestSegment1 == 'donor' && $requestSegment2 == 'profile') {
    $donorProfileSelected = 'selected';
} else {
    $donorProfileSelected = '';
}

if ($requestSegment1 == 'donors_scholarship') {
    $scholarshipSelected = 'selected';
} else {
    $scholarshipSelected = '';
}
/*
if ($requestSegment1 == 'payment_clarification_report') {
    $payment_clarification_report_selected = 'selected';
} else {
    $payment_clarification_report_selected = '';
}
dump($requestSegment1);
dump($donorSelected);
dd($requestSegment2);*/


?>


<div class="col-md-3">
    <div class="profile-menu-wrapper">
        <ul class="profile-menu">
            <li class="{!! $donorSelected !!}">
                <a href="{{url('/donors')}}">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    @lang('messages.Home')
                </a>
            </li>
           <li class="{!! $donorProfileSelected !!}">
                <a href="{{url('/donor/profile/edit')}}">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    @lang('messages.Donor Profile')
                </a>
            </li>

            {{--<li class="{!! $payment_clarification_report_selected !!}">
                <a href="{{url('/payment_clarification_report')}}">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    Clarification Report
                </a>
            </li>--}}

            <li class="{!! $scholarshipSelected !!}">
                <a href="{{url('donors_scholarship')}}">
                    <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                    @lang('messages.Students')
                </a>
            </li>
        </ul>

        {{--<div class="donor-filter-wrapper">
            @if($donorSelected=='selected' && $requestSegment7<'0')
                <div class="donor-filter">
                    <h4 class="filter-heading">Donation Filter</h4>
                    <div class="form-group">
                        <label for="sector">Sector</label>
                        @if(isset($sectors))
                            <select class="form-control" id="sector" onChange="filter_inboxes()">
                                <option value="">All</option>
                                @foreach($sectors as $sector)
                                    <option value="{{$sector->id}}" @if($sector->id==$sector_filter) selected @endif>{{$sector->name}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="sector">Donataion</label>
                        <select class="form-control" id="status_inboxes" onChange="filter_inboxes()">
                            <option value="0">All</option>
                            <option value="1" @if($status_filter=='1') selected @endif>Draft Donataion</option>
                            <option value="2" @if($status_filter=='2') selected @endif>Need Clarification Donataion</option>
                            <option value="3" @if($status_filter=='3') selected @endif>Approved Donataion</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="sector">Latest</label>
                        <select class="form-control" id="latest_inboxes" onChange="filter_inboxes()">
                            <option value="5" @if($latest_filter=='5') selected @endif>Last 5 Donataion</option>
                            <option value="10" @if($latest_filter=='10') selected @endif>Last 10 Donataion</option>
                            <option value="15" @if($latest_filter=='15') selected @endif>Last 15 Donataion</option>
                        </select>
                    </div>

                </div>
            @endif
        </div>--}}
    </div>

</div>
