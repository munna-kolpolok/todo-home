@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Presses"))
@section("contentheader_description", trans("messages.Presses listing"))
@section("section", trans("messages.Presses"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Presses listing"))

@section("headerElems")
    @la_access("presses", "create")
    <a href="{{ url(config('laraadmin.adminRoute') . '/presses/create') }}"
       class="btn btn-success btn-sm pull-right">@lang("messages.Add Presses")</a>
    <a style="margin: 0 10px" href="{{ url(config('laraadmin.adminRoute') . '/presses/order/change') }}"
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
                    {{--<th>Wesite</th>--}}
                    <th>Category</th>
                    <th>Published</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Video</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($values as $key=>$value)
                    <tr>
                        <td>{{++$key}}</td>
                        {{--<td>{{$value->website_id==1? "Bidyanondo":"One Taka Ahar"}}</td>--}}
                        <td>{{$value->press_category->name or null}}</td>
                        <td>{{$value->published_date or null}}</td>
                        <td>
                            <a href="{{ url(config('laraadmin.adminRoute') .'/presses/'.$value->id) }}">{{str_limit($value->description, 50)}}</a>
                        </td>
                        <td><img src="{{asset($value->image)}}" alt="image" width="60px" height="60px">
                        <td class="text-center">
                            @if($value->is_video == 1)
                                <span class="label label-success">Yes</span>
                            @else
                                <span class="label label-warning">No</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url(config('laraadmin.adminRoute') .'/presses/'.$value->id) }}"
                               class="btn btn-success btn-xs" data-toggle="tooltip" title="Details"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>
                            @la_access("presses", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/presses/'.$value->id.'/edit')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
                            @endla_access
                            @la_access("presses", "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.presses.destroy', $value->id], 'method' => 'delete', 'style'=>'display:inline'])}}
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
