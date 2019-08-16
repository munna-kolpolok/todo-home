@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Students"))
@section("contentheader_description", trans("messages.Students listing"))
@section("section", trans("messages.Student"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Students listing"))

@section("headerElems")
    @la_access("Students", "create")
    <a href="{{ url(config('laraadmin.adminRoute') . '/students/create') }}"
       class="btn btn-success btn-sm pull-right">@lang("messages.Add Student")</a>
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
                    <th>Id Card</th>
                    <th>Name</th>
                    <th>Orphange</th>

                    <th>Date of Birth</th>
                    <th>Amount</th>
                    <th>Scholarship</th>
                    <th>Website</th>
                  {{--  <th>Image</th>--}}
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($students as $key=>$student)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>
                            <a href="{{ url(config('laraadmin.adminRoute') .'/students/'.$student->id) }}">{{$student->id_card}}</a>
                        </td>
                        <td>{{$student->name}}</td>
                        <td>{{$student->orphange->name or null}}</td>
                        <td>{{$student->dob or null}}</td>
                        <td>{{$student->scholarship_amount}}</td>
                        <td class="text-center">
                            @if($student->is_scholarship == 1)
                                <span class="label label-success">Given</span>
                            @else
                                <span class="label label-warning">Not Given</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($student->is_website == 1)
                                <span class="label label-success">Show</span>
                            @else
                                <span class="label label-warning">Not show</span>
                            @endif
                        </td>
                       {{-- <td><img style="border-radius: 50%" src="{{asset($student->student_image)}}"
                                 alt="{{$student->name}}" width="60px" height="60px">

                            @la_access("students", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/students/'.$student->id.'/image')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Image Update"
                               style="display:inline;padding:2px 5px 3px 5px;">
                                <i class="fa fa-picture-o"></i>
                            </a>
                            @endla_access
                        </td>--}}
                        <td>
                            <a href="{{ url(config('laraadmin.adminRoute') .'/students/'.$student->id) }}"
                               class="btn btn-success btn-xs" data-toggle="tooltip" title="Details"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>
                            @la_access("students", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/students/'.$student->id.'/edit')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
                            <a href="{{url(config('laraadmin.adminRoute').'/students/'.$student->id.'/image')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Image Update">
                                <i class="fa fa-picture-o"></i>
                            </a>
                            @endla_access
                            @la_access("students", "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.students.destroy', $student->id], 'method' => 'delete', 'style'=>'display:inline'])}}
                            <button class="btn btn-danger btn-xs" type="submit" data-toggle="tooltip" title="Delete"
                                    onclick="return confirm('Are you sure to delete this entry?')"><i
                                        class="fa fa-times" title="Delete"></i></button>
                            {{Form::close()}}
                            @endla_access
                            @la_access("students", "create")
                            <a href="{{url(config('laraadmin.adminRoute').'/students/details/'.$student->id)}}"
                               class="btn btn-info btn-xs" data-toggle="tooltip" title="Notice"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i>Notice</a>
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
            ],
        });
    });
</script>
@endpush
