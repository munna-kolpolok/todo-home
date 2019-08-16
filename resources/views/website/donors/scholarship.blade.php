@extends('website.profile_layouts.app')


@section('profile-content')
    <div class="small-device-padding">
        <div class="col-md-9">
            <div style="margin-bottom: 10px" class="breadcomb-list">
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                        <div class="breadcomb-wp">
                            <div class="breadcomb-icon">
                                <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                            </div>
                            <div class="breadcomb-ctn">
                                <h2 style="line-height: 48px; color: #21c292">@lang('messages.Students List')</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- start blog-main-content -->
            <section class="blog-main-content">
                <div class="row blog-grid">
                    @if(request()->cookie('locale')=='bn')
                    <div class="col col-md-12">
                        <div class="scholarship-wrapper">
                            @if(count($students)>0)
                                @foreach($students as $student)
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="{{url('donors_scholarship/'.$student->id.'/'.$student->scholarship_id)}}">
                                                <img src="{{asset($student->student_image)}}" class="media-object"
                                                     width="80px" height="70px">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="left-side">
                                                <a href="{{url('donors_scholarship/'.$student->id.'/'.$student->scholarship_id)}}">
                                                    <h4 class="media-heading">{{$student->bn_name or null}}</h4>
                                                    <p>{{str_limit($student->bn_biography, 50)}}</p>
                                                </a>
                                            </div>
                                            <div class="right-side">
                                                <input type="hidden" id="student-id" value="{{$student->id}}">
                                                <a class="btn theme-btn btn-sm donate" data-toggle="modal" data-target="#donate-modal">@lang('messages.Sponsor')</a>
                                                <a style="background-color: #0094d6"
                                                   href="{{url('donors_scholarship/'.$student->id.'/'.$student->scholarship_id)}}"
                                                   class="btn theme-btn btn-sm">@lang('messages.Details')</a>
                                                <!-- <a style="background-color: #f69033" href="#" class="btn theme-btn btn-sm">Cancel</a> -->
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @foreach($sponsors as $student)
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="{{url('sponsor/details/'.$student->id)}}">
                                                <img src="{{asset($student->student_image)}}" class="media-object"
                                                     width="80px" height="70px">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="left-side">
                                                <a href="{{url('sponsor/details/'.$student->id)}}">
                                                    <h4 class="media-heading">{{$student->bn_name or null}}</h4>
                                                    <p>{{str_limit($student->bn_biography, 50)}}</p>
                                                </a>
                                            </div>
                                            <div class="right-side">
                                                <input type="hidden" id="student-id" value="{{$student->id}}">
                                                <a class="btn theme-btn btn-sm donate" data-toggle="modal" data-target="#donate-modal">@lang('messages.Sponsor')</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            @endif

                        </div>
                    </div>
                    @else
                        {{--.......English part start.............--}}
                        <div class="col col-md-12">
                        <div class="scholarship-wrapper">
                            @if(count($students)>0)
                                @foreach($students as $student)
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="{{url('donors_scholarship/'.$student->id.'/'.$student->scholarship_id)}}">
                                                <img src="{{asset($student->student_image)}}" class="media-object"
                                                     width="80px" height="70px">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="left-side">
                                                <a href="{{url('donors_scholarship/'.$student->id.'/'.$student->scholarship_id)}}">
                                                    <h4 class="media-heading">{{$student->name or null}}</h4>
                                                    <p>{{str_limit($student->biography, 50)}}</p>
                                                </a>
                                            </div>
                                            <div class="right-side">
                                                <input type="hidden" id="student-id" value="{{$student->id}}">
                                                <a class="btn theme-btn btn-sm donate" data-toggle="modal" data-target="#donate-modal">@lang('messages.Sponsor')</a>
                                                <a style="background-color: #0094d6"
                                                   href="{{url('donors_scholarship/'.$student->id.'/'.$student->scholarship_id)}}"
                                                   class="btn theme-btn btn-sm">@lang('messages.Details')</a>
                                                <!-- <a style="background-color: #f69033" href="#" class="btn theme-btn btn-sm">Cancel</a> -->
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else

                                @foreach($sponsors as $student)
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="{{url('sponsor/details/'.$student->id)}}">
                                                <img src="{{asset($student->student_image)}}" class="media-object"
                                                     width="80px" height="70px">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="left-side">
                                                <a href="{{url('sponsor/details/'.$student->id)}}">
                                                    <h4 class="media-heading">{{$student->name or null}}</h4>
                                                    <p>{{str_limit($student->biography, 50)}}</p>
                                                </a>
                                            </div>
                                            <div class="right-side">
                                                <input type="hidden" id="student-id" value="{{$student->id}}">
                                                <a class="btn theme-btn btn-sm donate" data-toggle="modal" data-target="#donate-modal">@lang('messages.Sponsor')</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                        {{--//.......English part end.............--}}
                    @endif
                </div> <!-- end row -->
            </section>
            <!-- end blog-main-content -->
        </div>
    </div>



    <!--Donate Modal-->
    <!-- Modal -->
    @include('website.scholarship.scholarship_donate_modal')
    <!--Donate Modal-->


@endsection

@push('scripts')

@endpush