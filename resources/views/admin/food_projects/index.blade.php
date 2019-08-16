@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Food Projects"))
@section("contentheader_description", trans("messages.Food Projects listing"))
@section("section", trans("messages.Food Projects"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Food Projects listing"))

@section("headerElems")
    @la_access("Food_Projects", "create")
    <a href="{{ url(config('laraadmin.adminRoute') . '/food_projects/create') }}"
       class="btn btn-success btn-sm pull-right">@lang("messages.Add Food Projects")</a>
    <a style="margin: 0 10px" href="{{ url(config('laraadmin.adminRoute') . '/food_projects/order/change') }}"
       class="btn btn-warning btn-sm pull-right">Update Order</a>
    @endla_access
@endsection

@section("main-content")

    @if(session()->has('seccess_msg'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{ session()->get('seccess_msg') }}</strong>
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
                    <th>Description</th>
                    <th>Min No Unit</th>
                    <th>Menu</th>
                    <th>Food Menu</th>
                    <th>Home</th>
                    <th>Show</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($values as $key=>$value)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$value->name or null}}</td>
                        <td>
                            <a href="{{ url(config('laraadmin.adminRoute') .'/food_projects/'.$value->id) }}">{{str_limit($value->description, 50)}}</a>
                        </td>
                        <td>{{$value->min_no_unit or null}}</td>
                        <td>
                            @if($value->is_menu == 1)
                                <span class="label label-success">Yes</span>
                            @else
                                <span class="label label-warning">No</span>
                            @endif
                        </td>
                        <td>
                            @if($value->food_menu == 1)
                                <span class="">Regular food item</span>
                            @else
                                <span class="">Custom food item</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($value->is_home == 1)
                                <span class="label label-success">Yes</span>
                            @else
                                <span class="label label-warning">No</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($value->is_show == 1)
                                <span class="label label-success">Yes</span>
                            @else
                                <span class="label label-warning">No</span>
                            @endif
                        </td>
                        {{-- <td><img src="{{asset($value->image)}}" alt="image" width="60px" height="60px"></td>--}}
                        <td>
                            <a href="{{ url(config('laraadmin.adminRoute') .'/food_projects/'.$value->id) }}"
                               class="btn btn-success btn-xs" data-toggle="tooltip" title="Details"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>
                            @la_access("Food_Projects", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/food_projects/'.$value->id.'/edit')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
                            @endla_access
                            @la_access("Food_Projects", "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.food_projects.destroy', $value->id], 'method' => 'delete', 'style'=>'display:inline'])}}
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
