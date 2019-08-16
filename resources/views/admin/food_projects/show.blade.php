@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Food Projects"))
@section("contentheader_description", trans("messages.Food Projects Details"))
@section("section", trans("messages.Food Projects"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Food Projects Details"))

@section("headerElems")

@endsection

@section("main-content")

    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
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
            <div>
                <h3 class="text-center">Food Projects Info</h3>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tr>
                                <th width="20%" style="vertical-align: middle">Food Projects Image</th>
                                <td style=" text-align: center" colspan="4">
                                    @if(!is_null($food_projects->image))
                                        <img src="{{asset($food_projects->image)}}" alt="Image" width="150px"
                                             height="100px">
                                    @else
                                        <img src="{{asset('uploads/students/default/default.png')}}" alt="No Image" width="250px"
                                             height="200px">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th  width="15%">Name </th>
                                <td  width="35%">{{ $food_projects->name or null }}</td>
                                <th  width="15%">Bangla Name</th>
                                <td  width="35%">{{ $food_projects->bn_name or null }}</td>
                            </tr>
                            <tr>
                                <th style="vertical-align: middle;">Description</th>
                                <td><div style="background-color: #fbfffd; padding: 10px 5px; border:1px solid lightgray; border-radius: 5px;">{{ $food_projects->description or null }}</div></td>
                                <th style="vertical-align: middle;">BN Description</th>
                                <td> <div style="background-color: #fbfffd; padding: 10px 5px; border:1px solid lightgray; border-radius: 5px;">{{ $food_projects->bn_description or null }}</div></td>
                            </tr>
                            <tr>
                                <th>Number Of Unit</th>
                                <td>{{ $food_projects->min_no_unit or null }}</td>
                                <th>Home</th>
                                <td>
                                    @if($food_projects->is_home == 1)
                                        <span class="panel panel-success">Yes</span>
                                    @else
                                        <span class="panel panel-danger">No</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Show</th>
                                <td>
                                    @if($food_projects->is_show == 1)
                                        <span class="panel panel-success">Yes</span>
                                    @else
                                        <span class="panel panel-danger">No</span>
                                    @endif
                                </td>
                                <th>Menu</th>
                                <td>
                                    @if($food_projects->is_menu == 1)
                                        <span class="panel panel-success">Yes</span>
                                    @else
                                        <span class="panel panel-danger">No</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th  style="vertical-align: middle;">Food Menu</th>
                                <td  style="vertical-align: middle;">
                                    @if($food_projects->food_menu == 1)
                                       Regular food item
                                    @else
                                        Custom food item
                                    @endif
                                </td>
                                @if($food_projects->food_menu == 0)
                                <th  style="vertical-align: middle;">Food Items</th>
                                <td>
                                    <div>
                                        @foreach($selected_food_items as $items)
                                            @foreach($food_items as $all_item)
                                                @if($items->food_item_id==$all_item->id)
                                                    <span class="panel panel-danger" style="padding:0 2px; margin:2px 2px;">{{ $all_item->name or null }} </span>

                                                @endif
                                            @endforeach
                                        @endforeach
                                    </div>
                                </td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
