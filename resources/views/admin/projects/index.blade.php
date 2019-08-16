@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Projects"))
@section("contentheader_description", trans("messages.Projects listing"))
@section("section", trans("messages.Projects"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Projects listing"))

@section("headerElems")
    @la_access("projects", "create")
    <a href="{{ url(config('laraadmin.adminRoute') . '/projects/create') }}"
       class="btn btn-success btn-sm pull-right">@lang("messages.Add Projects")</a>
    <a style="margin: 0 10px" href="{{ url(config('laraadmin.adminRoute') . '/projects/order/change') }}"
       class="btn btn-warning btn-sm pull-right">Update Order</a>
    @endla_access
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
                    <th>Name</th>
                    <th>Order</th>
                    <th>Project</th>
                    <th>Menu</th>
                    <th>parent</th>
                    <th>Project Start date</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $key=>$project)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$project->name}}</td>
                        <td>{{$project->serial_no}}</td>
                        <td>{{$project->is_project == 1 ? 'Yes' : 'No'}}</td>
                        <td>{{$project->is_menu == 1 ? 'Yes' : 'No'}}</td>
                        <td>{{$project->parent_project->name or null}}</td>
                        <td>{{$project->project_start_date or null}}</td>
                        <td>

                            @la_access("Projects", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/projects/'.$project->id.'/image')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Image Update"
                               style="display:inline;padding:2px 5px 3px 5px;">
                                <i class="fa fa-picture-o"></i>
                            </a>
                            @endla_access
                        </td>
                        <td>
                            <a href="{{ url(config('laraadmin.adminRoute') .'/projects/'.$project->id) }}"
                               class="btn btn-success btn-xs" data-toggle="tooltip" title="Details" target="_blank"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>
                            @la_access("Projects", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/projects/'.$project->id.'/edit')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
                            @endla_access
                            @la_access("Projects", "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.projects.destroy', $project->id], 'method' => 'delete', 'style'=>'display:inline'])}}
                            <button class="btn btn-danger btn-xs" type="submit" data-toggle="tooltip" title="Delete"
                                    onclick="return confirm('Are you sure to delete this entry?')"><i
                                        class="fa fa-times" title="Delete"></i></button>
                            {{Form::close()}}
                            @endla_access
                            {{--@la_access("projects", "create")
                            <a href="{{url(config('laraadmin.adminRoute').'/projects/details/'.$project->id)}}"
                               class="btn btn-info btn-xs"  data-toggle="tooltip" title="Edit" style="display:inline;padding:2px 5px 3px 5px;" ><i class="fa fa-edit" ></i>Info</a>
                            @endla_access--}}


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
<!-- jQuery UI -->
<script type="text/javascript" src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
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
