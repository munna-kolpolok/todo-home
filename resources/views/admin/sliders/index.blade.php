@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Slider"))
@section("contentheader_description", trans("messages.Slider listing"))
@section("section", trans("messages.Slider"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Slider listing"))

@section("headerElems")
    @la_access("sliders", "create")

    <a href="{{ url(config('laraadmin.adminRoute') . '/sliders/create') }}" class="btn btn-success btn-sm pull-right">
        <i class="fa fa-plus" aria-hidden="true"></i> @lang("messages.Add Slider")</a>
    <a style="margin: 0 10px" href="{{ url(config('laraadmin.adminRoute') . '/sliders/order/change') }}"
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
                    <th>Slider Title</th>
                    <th>Slider Sub Title</th>
                    <th>Slider Message</th>
                    <th>Slider Type</th>
                    <th>Slider Image</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($values as $key=>$value)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$value->up_title}}</td>
                        <td>{{$value->down_title}}</td>
                        <td style="max-width: 350px!important;">{{$value->message}}</td>
                        <td>
                            <?php
                            $slider_types_arr = array(1 => "Donate", 2 => "Scholarship", 3 => "Sign in", 4 => "Volunteer", 5 => "Rohinga camp");echo $slider_types_arr[$value->type]; unset($slider_types_arr);
                            ?>
                        </td>
                        <td><img src="{{asset($value->image)}}" alt="image" width="60px" height="60px"></td>

                        @if($value->status==2)
                            <td class="danger">Inactive</td>
                        @else
                            <td class="success">Active</td>
                        @endif

                        <td style="min-width: 80px!important;">
                            <a href="{{ url(config('laraadmin.adminRoute') .'/sliders/'.$value->id) }}"
                               class="btn btn-success btn-xs" data-toggle="tooltip" title="Details"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>
                            @la_access("sliders", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/sliders/'.$value->id.'/edit')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
                            @endla_access
                            @la_access("sliders", "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.sliders.destroy', $value->id], 'method' => 'delete', 'style'=>'display:inline'])}}
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
