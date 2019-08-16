@extends('website.layouts.app')

@section('main-content')
<!-- start page-title -->    
<section class="page-title">
    <div class="page-title-bg" style="background: url({{asset($setting->payment_background_image)}}) center center/cover no-repeat local;"></div>
    <div class="container">
        <div class="title-box">
			<h1><span class="title-custom-color">{{ session()->get('donation_msg') }}</span> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">@lang('messages.Home')</a></li>
                <li class="active">{{ session()->get('donation_msg') }}</li>
            </ol>
           {{--  <a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">Donate</a> --}}
        </div>
    </div> <!-- end container -->
</section>
<!-- end page-title -->


<!-- start about-details -->
<section class="about-us-st " style="padding-top: 20px;">
    <div class="container" >
        <!-- <h2><span>About</span> us</h2> -->
        <div class="row">
            @if(session()->has('message'))
				<div class="alert alert-success">
				  <strong style="font-size: 22px; min-height: 90px;"> <img src="{{asset('la-assets/img/checkmark.png')}}" style="padding-right: 30px;" > {{ session()->get('message') }}</strong> 
				</div>
			@endif

			@if(session()->has('error'))
				<div class="alert alert-danger">
				  <strong>{{ session()->get('error') }}</strong>
				</div>
			@endif



            <!-- reoprt start -->
            @if(isset($payment->amount) || isset($payment->total_amount))
          <?php
          $donation_reason=null;
          $v_currency=null;
          $v_amount=0;
          $donor_name=null;
          $donor_email=null;

          if (request()->cookie('locale') == 'bn') {

            if(isset($payment->project->name))
            {
              $donation_reason=$payment->project->bn_name;
            }
            else if(isset($payment->student->id_card))
            { 
              $donation_reason=$payment->student->bn_name.' ('.$payment->student->id_card.')';
            }
            else
            {
              $donation_reason=Lang::get('messages.organization_name');
            }



              if($paypal_id>0)
              {
                $download_link=url('donation_receipt/2/'.$payment->id);
                $v_amount=App\Helpers\CommonHelper::en2bnNumber(App\Helpers\CommonHelper::bd_money_format($payment->amount));
                $v_currency=Lang::get('messages.Dollar_USD');
              }
              if($ssl_id>0)
              {
                $download_link=url('donation_receipt/3/'.$payment->id);
                $v_amount=App\Helpers\CommonHelper::en2bnNumber(App\Helpers\CommonHelper::bd_money_format($payment->total_amount));
                $v_currency=Lang::get('messages.Taka_BDT');
              }
          }
          else
          {
              if(isset($payment->project->name))
              {
                $donation_reason=$payment->project->name;
              }
              else if(isset($payment->student->id_card))
              { 
                $donation_reason=$payment->student->name.' ('.$payment->student->id_card.' )';
              }
              else
              {
                $donation_reason=Lang::get('messages.organization_name');
              }



              if($paypal_id>0)
              {
                $download_link=url('donation_receipt/2/'.$payment->id);
                $v_amount=App\Helpers\CommonHelper::bd_money_format($payment->amount);
                $v_currency=Lang::get('messages.Dollar_USD');
              }
              if($ssl_id>0)
              {
                $download_link=url('donation_receipt/3/'.$payment->id);
                $v_amount=App\Helpers\CommonHelper::bd_money_format($payment->total_amount);
                $v_currency=Lang::get('messages.Taka_BDT');
              }
          }


          if(isset($payment->user_id))
          {
            $donor_name=$payment->user->name;
            $donor_email=$payment->user->email;
          }
          else
          {
            if($paypal_id>0)
            {
                $donor_name=$payment->payer_first_name.' '.$payment->payer_last_name;
                $donor_email=$payment->payer_email;
            }

            if($ssl_id>0)
            {
                $donor_name=$payment->cus_name;
                $donor_email=$payment->cus_email;
            }
            
          }

          ?>

          <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                  <div class="panel-heading">
                    <label style="color: black;font-weight: bold;font-size:18px;">@lang('messages.Donation Information')</label>
                    <label class="pull-right">
                        <a class="btn btn-success" href="{{ $download_link }}" data-toggle="tooltip" data-placement="bottom" title="@lang('messages.Download Receipt')" style="color: #fff;background-color: #ea2c31;border-color: #ea2c31;font-weight: bold"><i class="fa fa-file-pdf-o pr-5"></i> @lang('messages.Download Receipt')</a>
                    </label>
                     </div>
                  <div class="panel-body">
                      <ul>
                          <li><label>@lang('messages.Donation Amount') :</label> <b>{{ $v_amount }} {{ $v_currency }}</b></li>

                          <li><label>@lang('messages.Donor Name') :</label> {{ $donor_name  or null}}</li>
                          <li><label>@lang('messages.Donor Email') :</label> {{ $donor_email or null}}</li>

                          <li><label>@lang('messages.Donation Description') :</label> {{ $donation_reason or null}}</li>

                          @if(!empty($payment->order->comments))
                          <li><label>@lang('messages.Comments') :</label><pre>{{ $payment->order->comments or null}}</pre>
                          </li>
                            @endif
                        </ul>
                        <h4 style="text-align: center;">@lang('messages.Thank You For Your Support')</h4>
                  </div>
                </div>
                


            </div>
          </div>

          @endif
            <!-- report end -->




        </div> <!-- end row -->
    </div> <!-- end container -->
</section>

<!-- Start suggested projects section-->

    <!-- start events-nearby -->
    <section class="events-nearby section-padding" id="latest-project" style=" padding-top: 20px;">
        <div class="container">
            <div class="row section-title-s2">
                <div class="col col-md-8 col-md-offset-2">
                    <h2><span>@lang('messages.You may be') </span> @lang('messages.interested in')</h2>

                </div>
            </div> <!-- end section-title -->

            <div class="row">
                <div class="col col-xs-12">
                    @if(request()->cookie('locale')=='bn'){{--Bangla start...--}}
                        <div class="events-nearby-slider event-grid-wrapper">
                        @foreach($projects as $project)
                        <div class="event-grid">
                            <div class="event-box">
                                <div class="img-holder">
                                    <a href="{{ url('projects/'.$project->id) }}">
                                    <img src="{{asset($project->project_image)}}" alt="" class="img img-responsive">
                                    </a>
                                </div>
                                <div class="event-details">
                                    <input type="hidden" id="project-id-{{$project->id}}"
                                               value="{{$project->id}}">
                                    <input type="hidden" id="modal-img-{{$project->id}}"
                                                       value="{{$project->project_image}}">
                                    <input type="hidden" id="project-name-{{$project->id}}"
                                                       value="{{$project->name}}">

                                    <!-- <span class="date">27,oct</span> -->
                                    <h3 style="margin-top: 0; margin-bottom: 10px"><a href="{{ url('projects/'.$project->id) }}">{{ $project->bn_name or null }}</a></h3>
                                    {{--<span class="location"><i class="fa fa-map-marker"></i> {{ $project->location or null }}</span>--}}
                                    <p id="text-with-link" style="text-align: justify;  text-justify: inter-word; padding: 0 10px">
                                        <a href="{{url('projects/'.$project->id)}}">
                                            {{ str_limit($project->bn_description, 100) }}
                                            <span style="color: #ed323799">@lang('messages.Read more')</span>
                                        </a>
                                    </p>
                                    <a href="#" class="btn theme-btn donate-project" data-toggle="modal" data-target="#donate-project-modal">@lang('messages.Donate now')</a>

                                </div>
                            </div>
                        </div>
                        @endforeach



                         @foreach($students as $student)
                        <div class="event-grid">
                            <div class="event-box">
                                <div class="img-holder">
                                    <a href="{{url('scholarship/details/'.$student->id)}}">
                                    <img src="{{asset($student->student_image)}}" alt="" class="img img-responsive" style="max-height: 246px;">
                                    </a>
                                </div>
                                <div class="event-details">
                                    <input type="hidden" id="smile-img-{{$student->id}}"
                                               value="{{$student->student_smile_image}}">
                                        <input type="hidden" id="base_url" value="{{url('/')}}">
                                        <input type="hidden" id="student-id" value="{{$student->id}}">

                                    <!-- <span class="date">27,oct</span> -->
                                    <h3 style="margin-top: 0; margin-bottom: 10px"><a href="{{url('scholarship/details/'.$student->id) }}">{{ $student->bn_name or null }}</a></h3>
                                   
                                    <p id="text-with-link" style="text-align: justify;  text-justify: inter-word; padding: 0 10px">
                                        <a href="{{url('scholarship/details/'.$student->id)}}">
                                            {{ str_limit($student->bn_biography, 100) }}
                                            <span style="color: #ed323799">@lang('messages.Read more')</span>
                                        </a>
                                    </p>
                                     <input type="hidden" id="smile-img-{{$student->id}}"
                                               value="{{$student->student_smile_image}}">
                                        <input type="hidden" id="base_url" value="{{url('/')}}">
                                        <input type="hidden" id="student-id" value="{{$student->id}}">

                                        <a class="btn theme-btn donate" data-toggle="modal" data-target="#donate-modal">@lang('messages.Sponsor')</a>

                                </div>
                            </div>
                        </div>
                        @endforeach

                        
                    </div> <!-- end events-nearby-slider -->
                    @else {{--English start...--}}
                        <div class="events-nearby-slider event-grid-wrapper">
                        @foreach($projects as $project)
                            <div class="event-grid">
                                <div class="event-box">
                                    <div class="img-holder">
                                        <a href="{{ url('projects/'.$project->id) }}">
                                            <img src="{{asset($project->project_image)}}" alt="" class="img img-responsive">
                                        </a>
                                    </div>
                                    <div class="event-details">
                                        <input type="hidden" id="project-id-{{$project->id}}"
                                               value="{{$project->id}}">
                                        <input type="hidden" id="modal-img-{{$project->id}}"
                                               value="{{$project->project_image}}">
                                        <input type="hidden" id="project-name-{{$project->id}}"
                                               value="{{$project->name}}">

                                        <!-- <span class="date">27,oct</span> -->
                                        <h3 style="margin-top: 0; margin-bottom: 10px"><a href="{{ url('projects/'.$project->id) }}">{{ $project->name or null }}</a></h3>
                                        {{--<span class="location"><i class="fa fa-map-marker"></i> {{ $project->location or null }}</span>--}}
                                        <p id="text-with-link" style="text-align: justify;  text-justify: inter-word; padding: 0 10px">
                                            <a href="{{url('projects/'.$project->id)}}">
                                                {{ str_limit($project->description, 100) }}
                                                <span style="color: #ed323799">@lang('messages.Read more')</span>
                                            </a>
                                        </p>
                                        <a href="#" class="btn theme-btn donate-project" data-toggle="modal" data-target="#donate-project-modal">@lang('messages.Donate now')</a>

                                    </div>
                                </div>
                            </div>
                        @endforeach



                        @foreach($students as $student)
                            <div class="event-grid">
                                <div class="event-box">
                                    <div class="img-holder">
                                        <a href="{{url('scholarship/details/'.$student->id)}}">
                                            <img src="{{asset($student->student_image)}}" alt="" class="img img-responsive" style="max-height: 246px;">
                                        </a>
                                    </div>
                                    <div class="event-details">
                                        <input type="hidden" id="smile-img-{{$student->id}}"
                                               value="{{$student->student_smile_image}}">
                                        <input type="hidden" id="base_url" value="{{url('/')}}">
                                        <input type="hidden" id="student-id" value="{{$student->id}}">

                                        <!-- <span class="date">27,oct</span> -->
                                        <h3 style="margin-top: 0; margin-bottom: 10px"><a href="{{url('scholarship/details/'.$student->id) }}">{{ $student->name or null }}</a></h3>

                                        <p id="text-with-link" style="text-align: justify;  text-justify: inter-word; padding: 0 10px">
                                            <a href="{{url('scholarship/details/'.$student->id)}}">
                                                {{ str_limit($student->biography, 100) }}
                                                <span style="color: #ed323799">@lang('messages.Read more')</span>
                                            </a>
                                        </p>
                                        <input type="hidden" id="smile-img-{{$student->id}}"
                                               value="{{$student->student_smile_image}}">
                                        <input type="hidden" id="base_url" value="{{url('/')}}">
                                        <input type="hidden" id="student-id" value="{{$student->id}}">

                                        <a class="btn theme-btn donate" data-toggle="modal" data-target="#donate-modal">@lang('messages.Sponsor')</a>

                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div> <!-- end events-nearby-slider -->
                    @endif
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end events-nearby -->

    
    <!-- end shop-main-content -->




<!-- End suggested projects section-->


<!-- end about-details -->
   <!--Donate Modal-->
    @include('website.scholarship.scholarship_donate_modal')
    <!--Donate Modal-->
@endsection

@push('style')

<link href="{{asset('site-assets/css/owl.carousel.css')}}" rel="stylesheet">
<!-- <link href="{{asset('site-assets/css/owl.theme.css')}}" rel="stylesheet"> -->
<!-- <link href="{{asset('site-assets/css/owl.transitions.css')}}" rel="stylesheet"> -->
@endpush