@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Video Categories"))
@section("contentheader_description", "Video Categories Order Listing")
@section("section", trans("messages.Video Categories"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", "Project Order Listing")
@section("main-content")
    <div class="box box-success">
        <!--<div class="box-header"></div>-->
        <div class="box-body">
            <table id="example1" class="table table-bordered">
                <thead>
                <tr class="success">
                    <th><i class="fa fa-random" aria-hidden="true"></i> Sorting</th>
                    <th>Order</th>
                    <th class="success">Website</th>
                    <th>Name</th>
                </tr>
                </thead>
                <tbody id="tablecontents">
                @foreach($videoCategories as $key=>$categorie)
                    <tr class="row1" data-id="{{ $categorie->id }}">
                        <td><i class="fa fa-sort fa-2x" aria-hidden="true"></i></td>
                        <td>{{$categorie->serial_no}}</td>
                        <td>{{$categorie->website->name}}</td>
                        <td>{{$categorie->name}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('styles')
<style>
    tr:hover {
        cursor: -webkit-grab;
        cursor: -moz-grab;
        cursor: -o-grab;
        cursor: -ms-grab;
        cursor: grab;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<!-- jQuery UI -->
<script src="{{ asset('la-assets/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
    $(function () {
     /*   $('#example1').DataTable({
            responsive: false,
            stateSave: true,
            bPaginate: false,
            columnDefs: [{orderable: false, targets: [-1]}]
        });*/

        $("#tablecontents").sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.8,
            update: function () {
                sendOrderToServer();
            }
        }).disableSelection();

        function sendOrderToServer() {
            var order = [];
            $('tr.row1').each(function (index, element) {
                order.push({
                    id: $(this).attr('data-id'),
                    position: index + 1
                });
            });

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ url('admin/video_categories/food-projects-order-update') }}",
                data: {
                    order: order,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    //alert(response);
                    if (response == "Update Successfully.") {
                        location.reload();
                    } else {
                        console.log(response);
                    }
                }
            });

        }
    });
</script>
@endpush
