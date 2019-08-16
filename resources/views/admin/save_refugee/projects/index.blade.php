@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Projects"))
@section("contentheader_description", trans("messages.Projects listing"))
@section("section", trans("messages.Projects"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Projects listing"))

@section("headerElems")
    @la_access("Sr_Projects", "create")

    <a href="{{ url(config('laraadmin.adminRoute') . '/sr_projects/create') }}"
       class="btn btn-success btn-sm pull-right"> @lang("messages.Add Project")</a>
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
    <?php $yes_no_arr = array(1 => "Yes", 2 => "No");?>
    <div class="box box-success">
        <!--<div class="box-header"></div>-->
        <div class="box-body">
            <table id="example1" class="table table-bordered">
                <thead>
                <tr class="success">
                    <th>Serial</th>
                    <th>Project Name</th>
                    <th>Projects Title</th>
                    <th>Menu</th>
                    <th>Home</th>
                    <th>Show</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($values as $key=>$value)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$value->translation->name or null}}</td>
                        <td>{{$value->translation->title or null}}</td>
                        <td>{{$yes_no_arr[$value->is_menu ]}}</td>
                        <td>{{$yes_no_arr[$value->is_home]}}</td>
                        <td>{{$yes_no_arr[$value->is_show]}}</td>
                        <td style="vertical-align: middle;" align="center"><img src="{{asset($value->project_image)}}" alt="image" style="margin: 0 auto; height: 50px; width: 50px; border-radius: 50%"></td>
                        <td style="min-width: 80px!important;">
                            <a href="{{url(config('laraadmin.adminRoute').'/sr_projects/'.$value->id.'/edit')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Add Language Content"
                               style="display:inline;padding:2px 5px 3px 5px;"> <i class="fa fa-language"></i></a>
                            @la_access("Sr_Projects", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/sr_projects/'.$value->id.'/edit')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"> <i class="fa fa-edit"></i></a>
                            @endla_access
                            @la_access("Sr_Projects", "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.sr_projects.destroy', $value->id], 'method' => 'delete', 'style'=>'display:inline'])}}
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
