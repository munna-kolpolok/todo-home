@extends('website.profile_layouts.app')


@section('profile-content')
    <div class="small-device-padding">
        <div class="col-md-9">
            <!-- start blog-main-content -->
            <section style="background-color: #fff" class="blog-main-content">
                <!-- start page-wrapper -->
                <div class="page-wrapper scholarship-details">

                    <!-- start preloader -->
                    <div class="preloader">
                        <div class="middle">
                            <i class="fi flaticon-animal"></i>
                        </div>
                    </div>
                    <!-- end preloader -->

                    <!-- start causes-list-section -->
                    <section class="causes-list-section">
                        <div class="row">
                            <div class="col col-md-12">
                                <div class="student-biography">
                                    <div class="student-biography-inner">
                                        <h2 style="line-height: 48px; color: #21c292">@lang('messages.Bio')</h2>
                                        <p><img src="{{asset($student->student_image)}}" alt="{{$student->name}}" align="left"> {{$student->biography or null}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- end causes-list-box-wrapper -->
                                <div class="breadcomb-list">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                                            <div class="breadcomb-wp">
                                                <div class="breadcomb-icon">
                                                    <i class="fa fa-money" aria-hidden="true"></i>
                                                </div>
                                                <div style="width: 100%" class="breadcomb-ctn">
                                                    <h2 style="line-height: 48px; color: #21c292">@lang('messages.Payment Info')</h2>

                                                    <div id="no-more-tables">
                                                        <table class="col-md-12 table-bordered table-striped table-condensed cf">
                                                            <thead class="cf">
                                                            <tr>
                                                                <th>@lang('messages.Date')</th>
                                                                <th>@lang('messages.Description')</th>
                                                                <th>@lang('messages.Payment Method')</th>
                                                                <th>@lang('messages.Currency')</th>
                                                                <th>@lang('messages.Amount')</th>
                                                                <th>@lang('messages.Session')</th>
                                                            </tr>
                                                            </thead>
                                                            @if($donation_details->count() > 0)
                                                                <tbody>
                                                                @foreach($donation_details as $key => $donation_detail)
                                                                    <tr>
                                                                        <td data-title="Date">{{$donation_detail->donate_date or null}}</td>
                                                                        <td data-title="Description">
                                                                            {{$donation_detail->payment_description or null}}
                                                                        </td>
                                                                        <td data-title="payment" class="text-center">
                                                                            @if($donation_detail->payment_method == 1)
                                                                                <span class="label label-success">@lang('messages.Manual')</span>
                                                                            @elseif($donation_detail->payment_method == 2)
                                                                                <span class="label label-info">@lang('messages.PayPal')</span>
                                                                            @else
                                                                                <span class="label label-danger">@lang('messages.SSLCommerze')</span>
                                                                            @endif
                                                                        </td>
                                                                        <td data-title="currency">{{$donation_detail->currency->currency_name or null}}</td>
                                                                        <td data-title="amount">{{$donation_detail->amount or null}}</td>
                                                                        <td data-title="year">{{$donation_detail->scholarship->year or null}}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="breadcomb-list">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                                            <div class="breadcomb-wp">
                                                <div class="breadcomb-icon">
                                                    <i class="fa fa-info" aria-hidden="true"></i>
                                                </div>
                                                <div style="width: 100%" class="breadcomb-ctn">
                                                    <h2 style="line-height: 48px; color: #21c292">@lang('messages.Notice')</h2>

                                                    <div id="no-more-tables">
                                                        <table class="col-md-12 table-bordered table-striped table-condensed cf">
                                                            <thead class="cf">
                                                            <tr>
                                                                <th>@lang('messages.Sr')</th>
                                                                <th>@lang('messages.Topic')</th>
                                                                <th>@lang('messages.Date')</th>
                                                                <th>@lang('messages.Description')</th>
                                                                <th>@lang('messages.Attachment')</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($student->details as $key => $detail)
                                                                <tr>
                                                                    <td data-title="Serial">{{++$key}}</td>
                                                                    <td data-title="topic">{{$detail->topic or null}}</td>
                                                                    <td data-title="Date">{{$detail->date or null}}</td>
                                                                    <td data-title="Description">
                                                                        {{$detail->description or null}}
                                                                    </td>

                                                                    <td data-title="Attachment" class="text-center">
                                                                        @if(!empty($detail->attachment))
                                                                            <a href="{{ url($detail->attachment)}}"
                                                                               style="font-size: 22px; color: #21c292"
                                                                               target="_blank" data-toggle="tooltip"
                                                                               title="@lang('messages.Attachment')">
                                                                                <i class="fa fa-download"
                                                                                   aria-hidden="true"></i>
                                                                            </a>
                                                                        @endif

                                                                    </td>
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
                                <div style="margin-bottom: 10px" class="breadcomb-list">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                                            <div class="breadcomb-wp">
                                                <div class="breadcomb-icon">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </div>
                                                <div style="width: 100%" class="breadcomb-ctn">
                                                    <h2 style="line-height: 48px; color: #21c292">@lang('messages.Additional Info')</h2>

                                                    <div class="col-md-4">
                                                        <ul class="additional-info">
                                                            <li>
                                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                <span class="info-title">
                                                                    @lang('messages.Father') :
                                                                </span>
                                                                {{$student->father_name or null}}
                                                            </li>
                                                            <li>
                                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                <span class="info-title">
                                                                    @lang('messages.Father Occ') :
                                                                </span>
                                                                {{$student->father_occupation or null}}
                                                            </li>
                                                            <li>
                                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                @if($student->is_father === 1)
                                                                    <span class="info-title">
                                                                    @lang('messages.Father') : @lang('messages.Yes')
                                                                </span>
                                                                @else
                                                                    <span style="background-color: #7f8c8df2; padding: 2px 5px; color: #fff; border-radius: 5px;"
                                                                          class="info-title">
                                                                    @lang('messages.Father') : @lang('messages.Died')
                                                                </span>
                                                                @endif

                                                            </li>
                                                            <li>
                                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                <span class="info-title">
                                                                    @lang('messages.Tribe Name') :
                                                                </span>
                                                                {{$student->tribe_name or null}}
                                                            </li>
                                                            <li>
                                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                <span class="info-title">
                                                                   @lang('messages.Institute') :
                                                                </span>
                                                                {{$student->institute or null}}
                                                            </li>

                                                        </ul>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <ul class="additional-info">
                                                            <li>
                                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                <span class="info-title">
                                                                    @lang('messages.Mother') :
                                                                </span>
                                                                {{$student->mother_name or null}}
                                                            </li>
                                                            <li>
                                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                <span class="info-title">
                                                                    @lang('messages.Mother Occ') :
                                                                </span>
                                                                {{$student->mother_occupation or null}}
                                                            </li>
                                                            <li>
                                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                @if($student->is_mother === 1)
                                                                    <span class="info-title">
                                                                    @lang('messages.Mother') : @lang('messages.Yes')
                                                                </span>
                                                                @else
                                                                    <span style="background-color: #7f8c8df2; padding: 2px 5px; color: #fff; border-radius: 5px;"
                                                                          class="info-title">
                                                                    @lang('messages.Mother') : @lang('messages.Died')
                                                                </span>
                                                                @endif
                                                            </li>
                                                            <li>
                                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                <span class="info-title">
                                                                    @lang('messages.Height') :
                                                                </span>
                                                                {{$student->height or null}}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <ul class="additional-info">
                                                            <li>
                                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                <span class="info-title">
                                                                    @lang('messages.Religion') :
                                                                </span>
                                                                {{$student->religion->religion_name or null}}
                                                            </li>
                                                            <li>
                                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                <span class="info-title">
                                                                    @lang('messages.Gender') :
                                                                </span>
                                                                {{$student->gender->gender_name or null}}
                                                            </li>
                                                            <li>
                                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                <span class="info-title">
                                                                    @lang('messages.Weight') :
                                                                </span>
                                                                {{$student->weight or null}}
                                                            </li>
                                                            <li>
                                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                <span class="info-title">
                                                                    @lang('messages.Class') :
                                                                </span>
                                                                {{$student->section->class_name or null}}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- end col -->
                        <!-- end row -->
                    </section>
                    <!-- end causes-list-section -->
                </div>
                <!-- end of page-wrapper -->
            </section>
            <!-- end blog-main-content -->

        </div>
    </div>
@endsection