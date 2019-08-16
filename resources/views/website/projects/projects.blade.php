@extends('website.layouts.app')


@section('main-content')

    <!-- start page-title -->
    {{--<section class="page-title">
        <div class="page-title-bg" style="background: url({{asset($setting->project_background_image)}}) center center/cover no-repeat local;"></div>
        <div class="container">
            <div class="title-box">
                <h1><span class="title-custom-color">Our</span> Projects</h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Projects</li>
                </ol>
                <a href="#" class="btn theme-btn" data-toggle="modal" data-target="#donate-simple-modal">Donate</a>
            </div>
        </div> <!-- end container -->
    </section>--}}
    <!-- end page-title -->


    <!-- start blog-main-content -->
    <section class="blog-main-content section-padding">
        <div class="container">
            <?php $sl=0;?>
            @if(request()->cookie('locale')=='bn')
                <div class="row blog-grid">
                    @foreach($projects as $key => $project)
                        <?php
                        $sl++;
                        $key = $key + 5;
                        $time = "0.{$key}s";
                        ?>
                        <div class="col col-md-4 wow fadeInLeftSlow" data-wow-delay="{{$time}}"
                             style="margin-bottom: 30px">
                            <div class="post">
                                <div class="entry-media">
                                    <!--Image overlay-->
                                    {{-- <div class="image-overlay">
                                         <div class="display-details-text">
                                             <a href="{{ url('projects/'.$project->id)}}">
                                                 &nbsp; &nbsp;{{str_limit($project->description, 300)}}
                                                 <span style="color: red">continue reading..</span>
                                             </a>
                                         </div>
                                     </div>--}}

                                    <a href="{{ url('projects/'.$project->id) }}">
                                        <img src="{{asset($project->project_image)}}" alt="" class="img img-responsive">
                                    </a>
                                </div>
                                <div class="entry-body">
                                    <div class="entry-title text-center">
                                        <h3><a href="{{ url('projects/'.$project->id) }}">{{ $project->bn_name or null }}</a>
                                        </h3>
                                    </div>
                                    {{--<div class="entry-date-author">
                                        <ul>
                                            <li><i class="fa fa-map-marker"></i> {{ $project->location or null }}</li>
                                            <!-- <li><a href="#">by <span>Hasib sharif</span></a></li> -->
                                        </ul>
                                    </div>--}}
                                    <div style="text-align: center">
                                        <!-- <a href="{{ url('projects/'.$project->id) }}">Continue reading..</a> -->
                                        <input type="hidden" id="project-id-{{$project->id}}"
                                               value="{{$project->id}}">
                                        <input type="hidden" id="modal-img-{{$project->id}}"
                                               value="{{$project->project_image}}">
                                        <input type="hidden" id="project-name-{{$project->id}}"
                                               value="{{$project->name}}">
                                        <p id="text-with-link" style="text-align: justify;  text-justify: inter-word;">
                                            <a href="{{url('projects/'.$project->id)}}">
                                                {{ str_limit($project->bn_description, 95) }}
                                                <span style="color: #ed323799">@lang('messages.Read more')</span>
                                            </a>
                                        </p>
                                        <a href="#" class="btn theme-btn donate-project" data-toggle="modal"
                                           data-target="#donate-project-modal">@lang('messages.Donate now')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <?php if($sl%3==0) echo '<p style="display: block;  width: 100%; float: left;"></p>';?>
                    @endforeach
                </div> <!-- end row -->
            @else
                <div class="row blog-grid">
                    @foreach($projects as $key => $project)
                        <?php
                        $sl++;
                        $key = $key + 5;
                        $time = "0.{$key}s";
                        ?>
                        <div class="col col-md-4 wow fadeInLeftSlow" data-wow-delay="{{$time}}"
                             style="margin-bottom: 30px;">
                            <div class="post">
                                <div class="entry-media">
                                    <!--Image overlay-->
                                    {{-- <div class="image-overlay">
                                         <div class="display-details-text">
                                             <a href="{{ url('projects/'.$project->id)}}">
                                                 &nbsp; &nbsp;{{str_limit($project->description, 300)}}
                                                 <span style="color: red">continue reading..</span>
                                             </a>
                                         </div>
                                     </div>--}}

                                    <a href="{{ url('projects/'.$project->id) }}">
                                        <img src="{{asset($project->project_image)}}" alt="" class="img img-responsive">
                                    </a>
                                </div>
                                <div class="entry-body">
                                    <div class="entry-title text-center">
                                        <h3><a href="{{ url('projects/'.$project->id) }}">{{ $project->name or null }}</a>
                                        </h3>
                                    </div>
                                    {{--<div class="entry-date-author">
                                        <ul>
                                            <li><i class="fa fa-map-marker"></i> {{ $project->location or null }}</li>
                                            <!-- <li><a href="#">by <span>Hasib sharif</span></a></li> -->
                                        </ul>
                                    </div>--}}
                                    <div style="text-align: center">
                                        <!-- <a href="{{ url('projects/'.$project->id) }}">Continue reading..</a> -->
                                        <input type="hidden" id="project-id-{{$project->id}}"
                                               value="{{$project->id}}">
                                        <input type="hidden" id="modal-img-{{$project->id}}"
                                               value="{{$project->project_image}}">
                                        <input type="hidden" id="project-name-{{$project->id}}"
                                               value="{{$project->name}}">
                                        <p id="text-with-link" style="text-align: justify;  text-justify: inter-word;">
                                            <a href="{{url('projects/'.$project->id)}}">
                                                {{ str_limit($project->description, 95) }}
                                                <span style="color: #ed323799">@lang('messages.Read more')</span>
                                            </a>
                                        </p>
                                        <a href="#" class="btn theme-btn donate-project" data-toggle="modal"
                                           data-target="#donate-project-modal">@lang('messages.Donate now')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                           <?php if($sl%3==0) echo '<p style="display: block;  width: 100%; float: left;"></p>';?>
                    @endforeach
                </div> <!-- end row -->
            @endif

        </div> <!-- end container -->
    </section>
    <!-- end blog-main-content -->

@endsection
