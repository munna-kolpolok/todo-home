@extends('website.layouts.app')

@section('main-content')
    <!-- start page-title -->
    <section class="page-title">
        <div class="page-title-bg"
             style="background: url({{asset($setting->faq_background_image)}}) center center/cover no-repeat local;"></div>
        <div class="container">
            <div class="title-box">
                <h1><span class="title-custom-color">@lang('messages.Frequently')</span> @lang('messages.Asked Questions')</h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}">@lang('messages.Home')</a></li>
                    <li class="active">@lang('messages.FAQ')</li>
                </ol>
                {{--<a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">Donate</a>--}}
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->


    <!-- start about-details -->
    <section class="about-us-st section-padding" id="faq">
        <div class="container">
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
        <!-- <h2><span>About</span> us</h2> -->
            @if(request()->cookie('locale')=='bn')
            <div style="margin-bottom: 20px" class="row">
                <div class="col-md-6">
                    <div class="panel-group" id="accordion">
                        @foreach($faqs as $key=>$faq)
                            @if($key%2==0)
                                @if($key==0)
                                    <div class="panel panel-default current">
                                        <div class="panel-heading" id="headingOne">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                               aria-expanded="true">{{ $faq->bn_question or null}} <i
                                                        class="fa fa-angle-down"></i></a>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="img-holder">
                                                    <strong>@lang('messages.Answer') :</strong>
                                                </div>
                                                <div class="details">
                                                    <p>{{ $faq->bn_answer or null}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="panel panel-default">
                                        <div class="panel-heading" id="heading-{{$key}}">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                               href="#collapse-{{$key}}">{{ $faq->bn_question or null}} <i
                                                        class="fa fa-angle-down"></i></a>
                                        </div>
                                        <div id="collapse-{{$key}}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="img-holder">
                                                    <strong>@lang('messages.Answer') :</strong>
                                                </div>
                                                <div class="details">
                                                    <p>{{ $faq->bn_answer or null}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div> <!-- end left-col -->
                </div>
                <div class="col-md-6">
                    <div class="panel-group" id="accordion-right">
                        @foreach($faqs as $key=>$faq)
                            @if($key%2!=0)
                                <div class="panel panel-default">
                                    <div class="panel-heading" id="heading-{{$key}}">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion-right"
                                           href="#collapse-right-{{$key}}">{{ $faq->bn_question or null}} <i
                                                    class="fa fa-angle-down"></i></a>
                                    </div>
                                    <div id="collapse-right-{{$key}}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="img-holder">
                                                <strong>@lang('messages.Answer') :</strong>
                                            </div>
                                            <div class="details">
                                                <p>{{ $faq->bn_answer or null}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div> <!-- end left-col -->
                </div>
            </div> <!-- end row -->
            @else
            <div style="margin-bottom: 20px" class="row">
                <div class="col-md-6">
                    <div class="panel-group" id="accordion">
                        @foreach($faqs as $key=>$faq)
                            @if($key%2==0)
                                @if($key==0)
                                    <div class="panel panel-default current">
                                        <div class="panel-heading" id="headingOne">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                               aria-expanded="true">{{ $faq->question or null}} <i
                                                        class="fa fa-angle-down"></i></a>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="img-holder">
                                                    <strong>@lang('messages.Answer') :</strong>
                                                </div>
                                                <div class="details">
                                                    <p>{{ $faq->answer or null}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="panel panel-default">
                                        <div class="panel-heading" id="heading-{{$key}}">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                               href="#collapse-{{$key}}">{{ $faq->question or null}} <i
                                                        class="fa fa-angle-down"></i></a>
                                        </div>
                                        <div id="collapse-{{$key}}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="img-holder">
                                                    <strong>@lang('messages.Answer') :</strong>
                                                </div>
                                                <div class="details">
                                                    <p>{{ $faq->answer or null}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div> <!-- end left-col -->
                </div>
                <div class="col-md-6">
                    <div class="panel-group" id="accordion-right">
                        @foreach($faqs as $key=>$faq)
                            @if($key%2!=0)
                                <div class="panel panel-default">
                                    <div class="panel-heading panel-heading-right" id="heading-{{$key}}">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion-right"
                                           href="#collapse-right-{{$key}}">{{ $faq->question or null}} <i
                                                    class="fa fa-angle-down"></i></a>
                                    </div>
                                    <div id="collapse-right-{{$key}}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="img-holder">
                                                <strong>@lang('messages.Answer') :</strong>
                                            </div>
                                            <div class="details">
                                                <p>{{ $faq->answer or null}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div> <!-- end left-col -->
                </div>
            </div> <!-- end row -->
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="contact-request">
                        <a href="{{url('/contact')}}" class="btn theme-btn btn-block">@lang('messages.Contact us')&rarr;</a>
                    </div>
                </div>
            </div>
            {{--<div class="row">
                <div class="faq-send-form">
                    {!! Form::open(['url' => 'faq/store','class'=>'form row']) !!}
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Asked Your Question</legend>
                        <div class="form-group">
                            <textarea class="form-control" name="question" rows="2" placeholder="Write here.." required></textarea>
                        </div>
                        <button type="submit" class="btn theme-btn">Send</button>
                    </fieldset>
                    {!! Form::close() !!}
                </div>
            </div>--}}
        </div> <!-- end container -->
    </section>
    <!-- end about-details -->
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('.panel-heading-right').on('click', function (e) {
            const accordion_right = $('#accordion-right');

            accordion_right.find('.current').removeClass('current');
            $(this).parent().addClass('current');
            //const parentFirstClass = $(this).parent().prop('className').split(' ')[0];

        })
    });
</script>

@endpush