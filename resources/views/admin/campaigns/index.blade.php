@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Campaigns"))
@section("contentheader_description", trans("messages.Campaigns listing"))
@section("section", trans("messages.Campaigns"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Campaigns listing"))

@section("headerElems")
    @la_access("campaigns", "create")
    <a href="{{ url(config('laraadmin.adminRoute') . '/campaigns/create') }}"
       class="btn btn-success btn-sm pull-right">@lang("messages.Add campaign")</a>
    <a style="margin: 0 10px" href="{{ url(config('laraadmin.adminRoute') . '/campaigns/order/change') }}"
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
                    <th>Website</th>
                    <th>Order</th>
                    <th>Home</th>
                    <th>Show</th>
                    <th>Campaign date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($campaigns as $key=>$campaign)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$campaign->title or null}}</td>
                        <td>{{$campaign->website->name or null}}</td>
                        <td>{{$campaign->serial_no}}</td>
                        @if($campaign->is_home == 1)
                            <td class="success">Yes</td>
                        @else
                            <td class="danger">No</td>
                        @endif
                        @if($campaign->is_show == 1)
                            <td class="success">Yes</td>
                        @else
                            <td class="danger">No</td>
                        @endif
                        <td>{{$campaign->date or null}}</td>
                        <td>
                            <a href="{{ url(config('laraadmin.adminRoute') .'/campaigns/'.$campaign->id) }}"
                               class="btn btn-success btn-xs" data-toggle="tooltip" title="Details" target="_blank"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>
                            @la_access("Campaigns", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/campaigns/'.$campaign->id.'/edit')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
                            @endla_access
                            @la_access("Campaigns", "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.campaigns.destroy', $campaign->id], 'method' => 'delete', 'style'=>'display:inline'])}}
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
        $('#example1').DataTable({
            responsive: false,
            stateSave: true,
            columnDefs: [{orderable: false, targets: [-1]}]
        });
    });
</script>
@endpush
