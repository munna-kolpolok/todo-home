@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Gifts"))
@section("contentheader_description", trans("messages.Gifts listing"))
@section("section", trans("messages.Gifts"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Gifts listing"))

@section("headerElems")
    @la_access("Gift_Report", "create")
    <!-- <label>Select: </label> -->
    <select class="form-control" name="marriage_id" id="marriage_id" onchange="load_profile(this.value)">
        @foreach ($marriage_profiles as $marriage_profile)
        <?php
        
        if($marriage_profile->type=='1')
        {
            $type_label='Wedding';
        }
        else if($marriage_profile->type=='2')
        {
            $type_label='Anniversary';
        }
        else if($marriage_profile->type=='3')
        {
            $type_label='Birthday';
        }
        else if($marriage_profile->type=='4')
        {
            $type_label='Other';
        }
        ?>
        <option value="{{$marriage_profile->id}}" @if($id==$marriage_profile->id) selected @endif>
            <?php echo $marriage_profile->groom_email.'-'.$type_label.'-'.$marriage_profile->marriage_date;?>            
        </option>
        @endforeach
    </select>
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
                    <th>@lang('messages.Donation Date')</th>
                    <th>Donor Email</th>
                    <th>@lang('messages.Donor Name')</th>
                    <th>Gift</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>@lang('messages.Total')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($donation_lists as $key=>$gift)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ App\Helpers\CommonHelper::showDateTimeFormat($gift->payment_date) }}</td>
                        <td>{{ $gift->payer_email or null }}</td>
                        <td>{{ $gift->payer_name or null }}</td>

                        <td><img alt="img"src="{{ asset($gift->image)}}" height="30px" width="30px"> {{ $gift->name or null }}
                        </td>
                        <td align="right">{{ App\Helpers\CommonHelper::bd_money_format($gift->price) }} {{ $gift->currency_code or null }}</td>
                        <td align="center">{{ $gift->quantity or null }}</td>

                        <td align="right"><b>{{ App\Helpers\CommonHelper::bd_money_format($gift->price*$gift->quantity) }} {{ $gift->currency_code or null }}</b></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <!-- modal-start -->
    <div class="modal fade" id="modalCompose">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Gift Donors List - <span id="gift_name_label"></span></h4>
                </div>
                <div class="modal-body">
                    
                    <div class="box-body">
                        <table class="table table-bordered" id="t-user-list">
                            <thead>
                            <tr class="success">
                                <!-- <th>Serial</th> -->
                                <th>Date</th>
                                <th>Donor Email+Name</th>
                                <th>Payer Email+Name</th>
                                <th>Gifted Qty</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Currency</th>
                                <th>Comments</th>
                            </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>

                        <div class="loading" style="text-align: center;color: #DFF0D8">
                            <label><i class="fa fa-spinner fa-5x fa-spin success" aria-hidden="true"></i></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- modal-end -->

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
    $(function () {
        $('#example1').DataTable({
            
        });
    });

    function load_gift_donors(gift_id,gift_name)
    {
        $("#gift_name_label").html(gift_name);
        var marriage_id=$("#marriage_id").val();
        var url = "{{url(config('laraadmin.adminRoute') .'/gift_donor_list')}}";
        $("#t-user-list tbody").empty();
        $.ajax({
            type: "POST",
            data:{'gift_id': gift_id,'marriage_id':marriage_id},
            dataType: "json",
            url: url,
            beforeSend: function(){
                $(".loading").show();
            },
            complete: function(){
                $(".loading").hide();
            },
            success: function (data) {
                $("#t-user-list tbody").append(data);
            }
        });
    }
    function load_profile(profile_id)
    {
        var url = "{{url(config('laraadmin.adminRoute') .'/donation_list')}}"+'/'+profile_id;
        $(location).attr('href', url);
    }
</script>
@endpush
