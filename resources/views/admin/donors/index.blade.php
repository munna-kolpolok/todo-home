@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Donors"))
@section("contentheader_description", trans("messages.Donors listing"))
@section("section", trans("messages.Donors"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Donors listing"))

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
    @la_access("donors", "create")
    <a href="{{url(config('laraadmin.adminRoute').'/donors/create')}}" class="btn btn-primary">Add Donor</a>
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
                    <th>email</th>
                    <th>Contact No</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($donors as $key=>$donor)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$donor->name}}</td>
                        <td>{{$donor->email	or null}}</td>
                        <td>{{$donor->contact_no or null}}</td>
                        <td>{{$donor->address or null}}</td>
                        <td>
                            <a href="{{ url(config('laraadmin.adminRoute') .'/donors/'.$donor->id) }}" class="btn btn-success btn-xs" data-toggle="tooltip" title="Details" target="_blank" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>
                            @la_access("donors", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/donors/'.$donor->id.'/edit')}}"
                               class="btn btn-warning btn-xs"  data-toggle="tooltip" title="Edit" style="display:inline;padding:2px 5px 3px 5px;" ><i class="fa fa-edit" ></i></a>
                            @endla_access
                            @la_access("donors", "edit")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.donors.destroy', $donor->id], 'method' => 'delete', 'style'=>'display:inline'])}}
                            <button class="btn btn-danger btn-xs" type="submit"  data-toggle="tooltip" title="Delete"
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
            columnDefs: [ { orderable: false, targets: [-1] }]
        });

        //$('#example1 td').css('white-space','initial');

    });

</script>
@endpush
