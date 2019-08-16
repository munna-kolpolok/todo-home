@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Slider"))
@section("contentheader_description", trans("messages.Slider Details"))
@section("section", trans("messages.Slider"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Slider Details"))

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
                <h3 class="text-center" style="background-color: #ECF0F5; padding: 5px;"><strong>Slider Info</strong></h3>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                        	<tr>
                        		<td colspan="2">
                        			<div style="background-image: url('{{asset($sliders->image)}}'); width: 100%; height: 300px; background-size: cover;padding-top: 50px; " >
                        				<h2 style="background-color: #0e01014a; color: white; border: 1px solid #ECF0F5; padding: 30px ; margin: 0 auto; max-width: 400px;">Slider Background Image</h2>
                        			</div>
                        		</td>
                        	</tr>
                            <tr>
                            <tr>
                                <th width="200">@lang('messages.Slider Title')</th>
                                <td style="font-size: 16px; font-weight: bold;">{{ $sliders->up_title or null }}</td>  
                            </tr>
                            <tr>
                                <th >@lang('messages.Slider Title')(Bengaali)</th>
                                <td style="font-size: 14px; font-weight: bold;">{{ $sliders->bn_up_title or null }}</td>  
                            </tr>
                            <tr>
                                <th >@lang('messages.Slider Sub-Title')</th>
                                <td>{{ $sliders->down_title or null }}</td>  
                            </tr>
                            <tr>
                                <th >@lang('messages.Slider Sub-Title') (Benglali)</th>
                                <td>{{ $sliders->bn_down_title or null }}</td>  
                            </tr>
                             <tr>
                                <th >@lang('messages.Slider Message')</th>
                                <td>{{ $sliders->message or null }}</td>  
                            </tr>
                             <tr>
                                <th >@lang('messages.Slider Message') (Benglali)</th>
                                <td>{{ $sliders->bn_message or null }}</td>  
                            </tr>
                            <tr>
                                <th >@lang('messages.Slider Type')</th>
                                <td>{{ $slider_types_arr[$sliders->type] or null }}</td>  
                            </tr>
                            <tr>
                                <th >@lang('messages.Slider Background Image')</th>
                                <td style="">
                                    @if(!is_null($sliders->image))
                                       <a ><img src="{{asset($sliders->image)}}" alt="Image" width="90px"
                                             height="50px"></a> 
                                    @else
                                        <img src="{{asset('uploads/students/default/default.png')}}" alt="No Image" width="50px"
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
