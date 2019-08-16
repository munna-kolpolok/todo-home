@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Students"))
@section("contentheader_description", trans("messages.Students listing"))
@section("section", trans("messages.Students"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Students listing"))

<!-- <style type="text/css">
    table {
  table-layout:fixed;
}
table td {
  word-wrap: break-word;
  max-width: 400px;
}
#example td {
  white-space:inherit;
}
</style> -->

@section("headerElems")
    @la_access("students", "create")
    <a href="{{url(config('laraadmin.adminRoute').'/students/create')}}" class="btn btn-primary">Add Student</a>
    @endla_access
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

    @if(Session::has('seccess_msg'))
    <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>{{ Session::get('seccess_msg') }}</strong>
    </div>
    @endif


    <div class="box box-success">
        <!--<div class="box-header"></div>-->
        <div class="box-body">
            <table id="example1" class="table table-bordered">
                <thead>
                <tr>
                    <th>Serial</th>
                    <th>Name</th>
                    <th>Father Name</th>
                    <th>Date of Birth</th>
                    <th>Amount</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $key=>$student)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$student->name}}</td>
                        <td>{{$student->father_name	or null}}</td>
                        <td>{{$student->dob or null}}</td>
                        <td>{{$student->scholarship_amount}}</td>
                        <td>XXxX
                        </td>
                        <td>

asdasd

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
        $('#example1').DataTable( {
            responsive: false,
            columnDefs: [ { orderable: false, targets: [-1] }]
        } );
    });
</script>
@endpush
