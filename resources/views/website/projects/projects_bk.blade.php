@extends('website.layouts.app')


@section('main-content')
<!-- start page-title -->    
<section class="page-title">
    <div class="page-title-bg"></div>
    <div class="container">
        <div class="title-box">
            <h1>Our Projects and Programs</h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Projects and Programs</li>
            </ol>
        </div>
    </div> <!-- end container -->
</section>
<!-- end page-title -->


<!-- start event-2col-section -->
<section class="event-3col-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col col-xs-12 event-content event-grid-wrapper">

            	@foreach($projects as $project)
                <div class="event-grid wow slideInUpSlow">
                    <div class="event-box">
                        <div class="img-holder">
                            <a href="{{ url('projects/'.$project->id) }}">
                            <img src="{{asset($project->project_image)}}" alt="" class="img img-responsive">
                            </a>
                        </div>
                        <div class="event-details">
                            <!-- <span class="date">27,oct</span> -->
                            <h3><a href="{{ url('projects/'.$project->id) }}">{{ $project->name or null }}</a></h3>
                            <span class="location"><i class="fa fa-map-marker"></i> {{ $project->location or null }}</span>
                            <!-- <a href="#" class="btn">Join event</a> -->
                            <a href="#" class="btn theme-btn donate">Donate now</a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div> <!-- end event-content -->
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end event-2col-section -->

@endsection