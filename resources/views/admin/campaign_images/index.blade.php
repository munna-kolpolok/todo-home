@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Campaign Images"))
@section("contentheader_description", trans("messages.Campaign Images listing"))
@section("section", trans("messages.Campaign Images"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Campaign Images listing"))

@section("headerElems")
    @la_access("Camapaign_Images", "create")
    <a href="{{ url(config('laraadmin.adminRoute') . '/camapaign_images/create') }}"
       class="btn btn-success btn-sm pull-right">@lang("messages.Add Campaign Images")</a>
    @endla_access
    @la_access("Camapaign_Images", "edit")
    @if(!empty($firstCampaign))
        <a style="margin: 0 10px" id="update_order" href="{{ url(config('laraadmin.adminRoute') . '/camapaign_images/order/change/'.$firstCampaign->id) }}"
           class="btn btn-warning btn-sm pull-right">Update Order</a>
        <select style="padding: 5px" name="campaign" id="campaign">
            @foreach($campaigns as $campaign)
                <?php
                    $selected = ($firstCampaign->id == $campaign->id) ? 'selected' : '';
                ?>
                <option value="{{$campaign->id}}" {{$selected}}>{{$campaign->title}}</option>
            @endforeach
        </select>
    @endif
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
                    <th>Campaign Title</th>
                    <th>Order</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($images as $key=>$image)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$image->campaign->title or null}}</td>
                        <td>{{$image->serial_no or null}}</td>
                        <td>
                            <img src="{{asset($image->image)}}" alt="Project Image" width="80" height="70">
                        </td>
                        <td>
                            @la_access("Camapaign_Images", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/camapaign_images/'.$image->id.'/edit')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
                            @endla_access
                            @la_access("Camapaign_Images", "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.camapaign_images.destroy', $image->id], 'method' => 'delete', 'style'=>'display:inline'])}}
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
<!-- jQuery UI -->
<script type="text/javascript" src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
    $(function () {
        $('#campaign').on('change', function (e) {
            const project_id = e.target.value;
            const url = "{{url('admin/camapaign_images/order/change')}}"+'/'+project_id;
            $('#update_order').attr('href', url);
        });


        $('#example1').DataTable({
            responsive: false,
            stateSave: true,
            columnDefs: [{orderable: false, targets: [-1]}]
        });
    });
</script>
@endpush
