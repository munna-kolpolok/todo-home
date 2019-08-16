@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Latest News"))
@section("contentheader_description", trans("messages.Latest News listing"))
@section("section", trans("messages.Latest News"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Latest News listing"))

@section("headerElems")
    @la_access("Latest_News", "create")
    <button class="btn btn-success btn-sm pull-right" data-toggle="modal"
            data-target="#AddModal">@lang("messages.Add Latest News")</button>
    <a style="margin: 0 10px" href="{{ url(config('laraadmin.adminRoute') . '/latest_news/order/change') }}"
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
                    @foreach( $listing_cols as $col )
                        @if($col=='id')
                            <th>@lang('messages.Serial No.')</th>
                        @else
                            <th>
                                @php
                                    if(isset($module->fields[$col]['label']))
                                    {
                                        $v_col=$module->fields[$col]['label'];
                                    }
                                    else
                                    {
                                        $v_col=ucfirst($col);
                                    }
                                @endphp
                                {{ Lang::get('messages.'.$v_col) }}
                            </th>
                        @endif
                    @endforeach
                    @if($show_actions)
                        <th>@lang('messages.Actions')</th>
                    @endif
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    @la_access("Latest_News", "create")
    <div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">@lang("messages.Add Latest News")</h4>
                </div>
                {!! Form::open(['action' => 'LA\Latest_NewsController@store', 'id' => 'latest_news-add-form']) !!}
                <div class="modal-body">
                    <div class="box-body">
                        {{--@la_form($module)--}}
                        @la_input($module, 'website_id')
                        @la_input($module, 'news')
                        @la_input($module, 'bn_news')
                        <div class="form-group">
                            <label for="name">Status<span
                                        class="la-required">*</span></label>
                            <select class="form-control select2" name="status" id="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.Close')</button>
                    {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @endla_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
    $(function () {
        var t = $("#example1").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url(config('laraadmin.adminRoute') . '/latest_news_dt_ajax') }}",
            language: {
                lengthMenu: "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Search"
            },
            @if($show_actions)
            columnDefs: [{orderable: false, targets: [-1]}],
            @endif
        });
        t.on('order.dt search.dt', function () {
            t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
        $("#latest_news-add-form").validate({});
    });
</script>
@endpush
