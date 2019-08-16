@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Wedding Slider"))
@section("contentheader_description", trans("messages.Wedding Slider Details"))
@section("section", trans("messages.Wedding Slider"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Wedding Slider Details"))

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
                <h3 class="text-center" style="background-color: #ECF0F5; padding: 5px;"><strong>Wedding Slider Info</strong></h3>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                        	<tr>
                        		<td colspan="2">
                        			<div style="background-image: url('{{asset($wedding_sliders->image)}}'); width: 100%; height: 300px; background-size: cover;padding-top: 50px; " >
                        				<h2 style="background-color: #0e01014a; color: white; border: 1px solid #ECF0F5; padding: 30px ; margin: 0 auto; max-width: 400px;">Slider Background Image</h2>
                        			</div>
                        		</td>
                        	</tr>
                            <tr>
                                <th width="200">@lang('messages.Slider Title')</th>
                                <td style="font-size: 16px; font-weight: bold;">{{ $wedding_sliders->title or null }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('messages.Slider Sub-Title')</th>
                                <td style="font-size: 16px; font-weight: bold;">{{ $wedding_sliders->subtitle or null }}</td>
                            </tr>
                            <tr>
                                <th >@lang('messages.Slider Up Description')</th>
                                <td style="font-size: 14px; font-weight: bold;">{{ $wedding_sliders->description_up or null }}</td>
                            </tr>
                            <tr>
                                <th >@lang('messages.Slider Down Description')</th>
                                <td>{{ $wedding_sliders->description_down or null }}</td>
                            </tr>
                            <tr>
                                <th >@lang('messages.Button Label') (Benglali)</th>
                                <td>{{ $wedding_sliders->button_label or null }}</td>
                            </tr>
                             <tr>
                                <th >@lang('messages.Button Link')</th>
                                <td>{{ $wedding_sliders->button_link or null }}</td>
                            </tr>
                             <tr>
                                <th >@lang('messages.Button Color') (Benglali)</th>
                                <td>
                                    <input type="color" disabled name="button_color" class="form-control" value="{{$wedding_sliders->button_color or '#ff0000'}}">
                                </td>
                            </tr>
                            <tr>
                                <th >Slider Status</th>
                                @if($wedding_sliders->is_show==1)
                                <td><span style="color: white; background: green; padding:3px  5px;">Show In Website</span></td>
                                @else
                                    <td> <span style="color: red; background: green; padding:3px  5px;">Not Show In Website</span></td>
                                 @endif
                            </tr>
                            <tr>
                                <th >@lang('messages.Slider Background Image')</th>
                                <td style="">
                                    @if(!is_null($wedding_sliders->image))
                                       <a ><img src="{{asset($wedding_sliders->image)}}" alt="Image" width="90px"
                                             height="50px"></a> 
                                    @else
                                        <img src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="No Image" width="50px"
                                             height="30px">
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
