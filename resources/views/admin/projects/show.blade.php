@extends("la.layouts.app")

@section("contentheader_title", trans("messages.projects"))
@section("contentheader_description", trans("messages.projects Details"))
@section("section", trans("messages.projects"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.projects Details"))

@section("headerElems")

@endsection

@section("main-content")

    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="box box-success">
        <!--<div class="box-header"></div>-->
        <div class="box-body">
            {{--Image Suggestion--}}
            <div class="row">
                <div class="col-md-4">
                    <div class="image-wrapper text-center">
                        @if(!is_null($project->project_image))
                            <img src="{{asset($project->project_image)}}" alt="{{$project->name}}" width="250px"
                                 height="200px">
                        @else
                            <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="250px"
                                 height="200px">
                        @endif
                        <h4 class="text-success">@lang('messages.Project Image')</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="image-wrapper text-center">
                        @if(!is_null($project->project_big_image))
                            <img src="{{asset($project->project_big_image)}}" alt="{{$project->name}}" width="250px"
                                 height="200px">
                        @else
                            <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="250px"
                                 height="200px">
                        @endif
                        <h4 class="text-success">@lang('messages.Project Poster Image')</h4>
                    </div>
                </div>
                <div class="col-md-4">

                </div>
            </div>
            <div>
                <h3>Student Info</h3>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-hover">
                            <tr>
                                <th>@lang('messages.Name')</th>
                                <td>{{ $project->name or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Bangla Name')</th>
                                <td>{{ $project->bn_name or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Project Start Date')</th>
                                <td>{{  $project->project_start_date or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Location')</th>
                                <td>{{  $project->location or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Location(Bangla)')</th>
                                <td>{{  $project->bn_location or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Description')</th>
                                <td>{{ $project->description or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Description(Bangla)')</th>
                                <td>{{ $project->bn_description or null }}</td>
                            </tr>

                            <tr>
                                <th>@lang('messages.Project type')</th>
                                <td>{{ $project->project_type->name or null}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Supervisor name')</th>
                                <td>{{ $project->supervisor_name or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Objective Bangla')</th>
                                <td>{{ $project->bn_objective or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Supervisor contact no')</th>
                                <td>{{ $project->supervisor_contact_no or null }}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Achievement Bangla')</th>
                                <td>{{ $project->bn_achievement or null }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-hover">
                            <tr>
                                <th>@lang('messages.Is Project')</th>
                                <td>{{ $project->is_project === 1 ? 'Yes': 'No'}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Is Menu')</th>
                                <td>{{ $project->is_menu === 1 ? 'Yes' : 'No'}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Is Urgent')</th>
                                <td>{{ $project->is_urgent === 1 ? 'Yes' : 'No'}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Is Home')</th>
                                <td>{{ $project->is_home === 1 ? 'Yes' : 'No'}}</td>
                            </tr>
                            <tr>
                                <th>@lang('messages.Is Show')</th>
                                <td>{{ $project->is_show === 1 ? 'Yes' : 'No'}}</td>
                            </tr>

                            <tr>
                                <th>@lang('messages.Project video link')</th>
                                <td>{{ $project->video_link or null }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
<script>

</script>
@endpush
