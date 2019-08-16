@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Weeding Slider"))
@section("contentheader_description", trans("messages.Weeding Slider listing"))
@section("section", trans("messages.Weeding Slider"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Weeding Slider listing"))

@section("headerElems")
    @la_access("Wedding_Sliders", "create")

    <a href="{{ url(config('laraadmin.adminRoute') . '/wedding_sliders/create') }}"
       class="btn btn-success btn-sm pull-right">
        <i class="fa fa-plus" aria-hidden="true"></i> @lang("messages.Add Wedding Slider")</a>
    <a style="margin: 0 10px" href="{{ url(config('laraadmin.adminRoute') . '/wedding_sliders/order/change') }}"
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
                    <th>Title</th>
                    <th>Sub Title</th>
                    <th>Status</th>
                    <th>Slider Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($sliders as $key=>$slider)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$slider->title or null}}</td>
                        <td>{{$slider->subtitle or null}}</td>
                        @if($slider->is_show==1)
                            <td class="success"><span style="text-align: center;">Show In Website</span>
                            </td>
                        @else
                            <td class="danger"><span style="text-align: center;">Not Show In Website</span>
                            </td>
                        @endif
                        <td><img src="{{asset($slider->image)}}" alt="image" width="60px" height="60px"></td>
                        <td style="min-width: 80px!important;">
                            <a href="{{ url(config('laraadmin.adminRoute') .'/wedding_sliders/'.$slider->id) }}"
                               class="btn btn-success btn-xs" data-toggle="tooltip" title="Details"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>
                            @la_access("Wedding_Sliders", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/wedding_sliders/'.$slider->id.'/edit')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
                            @endla_access
                            @la_access("Wedding_Sliders", "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.wedding_sliders.destroy', $slider->id], 'method' => 'delete', 'style'=>'display:inline'])}}
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
