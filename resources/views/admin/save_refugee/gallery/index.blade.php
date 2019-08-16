@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Galleries"))
@section("contentheader_description", trans("messages.Galleries listing"))
@section("section", trans("messages.Galleries"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Galleries listing"))
<style>
    a {
        display: inline-block !important;
    }
</style>
@section("headerElems")
    @la_access("Sr_Galleries", "create")

    <a href="{{ url(config('laraadmin.adminRoute') . '/sr_galleries/create') }}"
       class="btn btn-success btn-sm pull-right"> @lang("messages.Add Gallery")</a>
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
                    <th>Album Name</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($galleries as $key=>$value)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$value->englishGallery->album_name or null}}</td>
                        <td style="vertical-align: middle;" align="center">
                            <img src="{{asset($value->mainImage->image)}}" alt="image"
                                 style="margin: 0 auto; height: 85px; width: 120px;">
                        </td>
                        <td style="min-width: 80px!important;">
                            @la_access("Sr_Galleries", "edit")
                            <a href="{{url(config('laraadmin.adminRoute').'/sr_galleries/'.$value->id.'/edit#translation')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Add Gallery Language Content"
                               style="display:inline;padding:2px 5px 3px 5px;"> <i class="fa fa-language"
                                                                                   aria-hidden="true"></i>
                            </a>
                            <a href="{{url(config('laraadmin.adminRoute').'/sr_galleries/'.$value->id.'/edit')}}"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"> <i class="fa fa-edit"></i>
                            </a>
                            @endla_access
                            @la_access("Sr_Galleries", "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.sr_galleries.destroy', $value->id], 'method' => 'delete', 'style'=>'display:inline'])}}
                            <button class="btn btn-danger btn-xs" type="submit" data-toggle="tooltip" title="Delete"
                                    onclick="return confirm('Are you sure to delete this entry?')"><i
                                        class="fa fa-times" title="Delete"></i>
                            </button>
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
