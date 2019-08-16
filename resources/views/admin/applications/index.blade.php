@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Applications"))
@section("contentheader_description", trans("messages.Applications listing"))
@section("section", trans("messages.Applications"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Applications listing"))

@section("headerElems")
@endsection

@section("main-content")
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

    <div class="box box-success">
        <!--<div class="box-header"></div>-->
        <div class="box-body">
            <table id="example1" class="table table-bordered">
                <thead>
                <tr class="success">
                    <th>Serial</th>
                    <th>Marriage Date</th>
                    <th>Groom Name</th>
                    <th>Bride Name</th>
                    <th>Contact No</th>
                    <th>Verified Status</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($applications as $key=>$application)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$application->marriage_date or null}}</td>
                        <td>{{$application->groom_name or null}}</td>
                        <td>{{$application->bride_name or null}}</td>
                        <td>{{$application->contact_no or null}}</td>
                        @if($application->is_verified == 1)
                            <td class="success">Verified</td>
                        @else
                            <td class="danger">Not Verified</td>
                        @endif
                        @if($application->is_show == 1)
                            <td class="success">Active</td>
                        @else
                            <td class="danger">Inactive</td>
                        @endif
                        <td>
                            <a href="{{ url(config('laraadmin.adminRoute') .'/applications/'.$application->id) }}"
                               class="btn btn-success btn-xs" data-toggle="tooltip" title="Details"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>
                            @if($application->is_verified == 2)
                                <a href="{{ url(config('laraadmin.adminRoute') .'/applications/'.$application->id.'/need-verify/1') }}"
                                   class="btn btn-primary btn-xs" data-toggle="tooltip" title="Click to verify"
                                   style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-check" aria-hidden="true"></i> Verify</a>
                            @else
                                <a href="{{ url(config('laraadmin.adminRoute') .'/applications/'.$application->id.'/need-verify/2') }}"
                                   class="btn btn-danger btn-xs" data-toggle="tooltip" title="Click to cancel verification"
                                   style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-times" aria-hidden="true"></i> Not Verify</a>
                            @endif
                            @if($application->is_show == 1)
                                <a href="{{ url(config('laraadmin.adminRoute') .'/applications/'.$application->id.'/show/2') }}"
                                   class="btn btn-danger btn-xs" data-toggle="tooltip"
                                   title="Click to hide from website"
                                   style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-arrow-down" aria-hidden="true"></i> Inactive</a>
                            @else
                                <a href="{{ url(config('laraadmin.adminRoute') .'/applications/'.$application->id.'/show/1') }}"
                                   class="btn btn-success btn-xs" data-toggle="tooltip"
                                   title="Click to show in website"
                                   style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-arrow-up" aria-hidden="true"></i> Active</a>
                            @endif
                            @la_access("applications", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/applications/'.$application->id.'/edit')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
                            @endla_access
                            @la_access("applications", "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.applications.destroy', $application->id], 'method' => 'delete', 'style'=>'display:inline'])}}
                            <button class="btn btn-danger btn-xs" type="submit" data-toggle="tooltip" title="Delete"
                                    onclick="return confirm('Are you sure to delete this entry?')"><i
                                        class="fa fa-times" title="Delete"></i></button>
                            {{Form::close()}}
                            @endla_access

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
    $(function () {
        $('#example1').DataTable({
            responsive: false,
            stateSave: true,
            columnDefs: [{orderable: false, targets: [-1]}]
        });
    });
</script>
@endpush
