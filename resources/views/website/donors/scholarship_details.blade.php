@extends('website.profile_layouts.app')


@section('profile-content')
    <div class="col-md-9">
        <!-- start blog-main-content -->
        <section class="blog-main-content" id="donor-scholarship-list">
            <div class="row blog-grid">
                <div class="col col-md-4 col-xs-12 wow fadeInLeftSlow" style="margin-bottom: 30px">
                    <div class="post">
                        <div class="entry-media">
                            <a href="{{url('sponsor/details/'.$student->id)}}">
                                <img src="{{asset($student->student_image)}}" alt="" class="img img-responsive">
                            </a>
                        </div>
                        <div class="entry-body">
                            <div class="entry-title text-center">
                                <h3>{{ $student->name or null }}</h3>
                            </div>
                            {{--<div style="text-align: center">
                                <input type="hidden" id="student-id" value="{{$student->id}}">
                                <a class="btn theme-btn btn-sm donate" data-toggle="modal"
                                   data-target="#donate-modal">@lang('messages.Sponsor')</a>
                            </div>--}}
                        </div>
                    </div>
                </div>
                <div class="col col-md-8 col-xs-12 wow fadeInRightSlow">
                    <div class="right-col">
                        <div class="video">
                            <img src="{{asset($student->student_image)}}" alt="">
                            <a href="{{$student->student_video}}" target="_blank"><i
                                        class="fa fa-play"></i></a>
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->
            <div class="row">
                <div class="col col-xs-12">
                    <div class="product-info">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="active"><a href="#student-information" data-toggle="tab">Student Information</a>
                            </li>
                            <li><a href="#payment-information" data-toggle="tab">Payment Information</a></li>
                            <li><a href="#notice" data-toggle="tab">Notice</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="student-information">
                                @if(!empty($student->biography))
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="student-biography">
                                            <h3>@lang('messages.biography')</h3>
                                            <p>{{$student->biography or null}}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
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
                                                <span class="info-title">@lang('messages.Admission Date') :</span>
                                                {{$student->admission_date or null}}
                                            </li>
                                            <li>
                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                <span class="info-title">@lang('messages.class roll') :</span>
                                                {{$student->class_roll or null}}
                                            </li>
                                            <li>
                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                <span class="info-title">
                                                                    @lang('messages.Class') :
                                                                </span>
                                                {{$student->section->class_name or null}}
                                            </li>
                                            <li>
                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                <span class="info-title">
                                                                   @lang('messages.Institute') :
                                                                </span>
                                                {{$student->institute or null}}
                                            </li>
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
                                                                    @lang('messages.Height') :
                                                                </span>
                                                {{$student->height or null}}
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
                                                <span class="info-title">@lang('messages.Blood Group') :</span>
                                                {{$student->blood->name or null}}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
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
                                                <span class="info-title">@lang('messages.Orphange') :</span>
                                                {{$student->orphange->name or null}}
                                            </li>
                                            <li>
                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                <span class="info-title">@lang('messages.Orphange reason') :</span>
                                                {{$student->reason_for_orphan or null}}
                                            </li>
                                            <li>
                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                <span class="info-title">@lang('messages.Contact No') :</span>
                                                {{$student->contact_no or null}}
                                            </li>
                                            <li>
                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                <span class="info-title">@lang('messages.Present Address') :</span>
                                                {{$student->present_address or null}}
                                            </li>
                                            <li>
                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                <span class="info-title">@lang('messages.Permanent Address') :</span>
                                                {{$student->permanent_address or null}}
                                            </li>
                                            <li>
                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                <span class="info-title">@lang('messages.Guardian Name') :</span>
                                                {{$student->gurdian_name or null}}
                                            </li>
                                            <li>
                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                <span class="info-title">@lang('messages.Guardian Relation') :</span>
                                                {{$student->gurdian_relation or null}}
                                            </li>
                                            <li>
                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                <span class="info-title">@lang('messages.siblings') :</span>
                                                {{$student->siblings or null}}
                                            </li>
                                            <li>
                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                <span class="info-title">@lang('messages.Illness') :</span>
                                                {{$student->illness or null}}
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="payment-information">
                                <div class="row">
                                    <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
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
                            <div role="tabpanel" class="tab-pane fade" id="notice">
                                <div class="row">
                                    <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
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
                </div>
            </div> <!-- end row -->
        </section>
        <!-- end blog-main-content -->
    </div>

@endsection
