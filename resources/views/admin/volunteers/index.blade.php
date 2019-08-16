@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Volunteers"))
@section("contentheader_description", trans("messages.Volunteers listing"))
@section("section", trans("messages.Volunteers"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Volunteers listing"))

@section("headerElems")
    @la_access("volunteers", "create")
    {{--<a href="{{ url(config('laraadmin.adminRoute') . '/volunteers/create') }}"
       class="btn btn-success btn-sm pull-right">@lang("messages.Add Volunteers")</a>--}}
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
                    <th>Reg Date</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact No</th>
                    <th>Contact Branch</th>
                    <th>Volunteer</th>
                    <th>Website</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($volunteers as $key=>$volunteer)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{date("m-d-Y",strtotime($volunteer->created_at))}}</td>
                        <td>{{$volunteer->first_name.' '.$volunteer->last_name}}</td>
                        <td>{{$volunteer->email or null}}</td>
                        <td>{{$volunteer->contact_no or null}}</td>
                        <td>{{$volunteer->contact->name or null}}</td>
                        @if($volunteer->volunteer==1)
                            <td>Bangladeshi</td>
                        @else
                            <td class="warning">International</td>
                        @endif

                        @if($volunteer->website_id==1)
                            <td>Bidyanondo</td>
                        @elseif($volunteer->website_id==2)
                            <<td>OneTakaMeal</td>
                        @endif
                        <td style=" text-align: center">
                            @if(!empty($volunteer->profile_image))
                                <img style="border-radius: 50%" src="{{asset($volunteer->profile_image)}}"
                                     alt="{{$volunteer->name}}" width="60px" height="60px">
                            @else

                                <i class="fa fa-male" style="font-size:30px; color:darkorange;"></i>
                            @endif

                            @la_access("volunteers", "edit")
                            {{--<a href="{{url(config('laraadmin.adminRoute').'/volunteers/'.$volunteer->id.'/image')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Image Update"
                               style="display:inline;padding:2px 5px 3px 5px; float: right">
                                <i class="fa fa-picture-o"></i>
                            </a>--}}
                            @endla_access
                        </td>
                        <td>
                            <a href="{{ url(config('laraadmin.adminRoute') .'/volunteers/'.$volunteer->id) }}"
                               class="btn btn-success btn-xs" data-toggle="tooltip" title="Details" target="_blank"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>
                           {{-- @la_access("volunteers", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/volunteers/'.$volunteer->id.'/edit')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
                            @endla_access
                            @la_access("volunteers", "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.volunteers.destroy', $volunteer->id], 'method' => 'delete', 'style'=>'display:inline'])}}
                            <button class="btn btn-danger btn-xs" type="submit" data-toggle="tooltip" title="Delete"
                                    onclick="return confirm('Are you sure to delete this entry?')"><i
                                        class="fa fa-times" title="Delete"></i></button>
                            {{Form::close()}}
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
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>

{{--Data table export options--}}
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/buttons.print.min.js') }}"></script>
<script>
    $(function () {
        $('#example1').DataTable({
            responsive: false,
            stateSave: true,
            columnDefs: [{orderable: false, targets: [-1]}],
            dom: '<"top"Bf>rt<"bottom"lip><"clear">',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
@endpush
