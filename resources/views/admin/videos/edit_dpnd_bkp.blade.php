@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/videos') }}">@lang('messages.Videos')</a> :
@endsection
@section("section", trans("messages.Videos"))
@section("section_url", url(config('laraadmin.adminRoute') . '/videos'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", trans("messages.Edit Video"))

@section("main-content")
    <style type="text/css">
        #save_div {
            display: none;
        }
        .suggestion_text{
        color:green;
        font-size: 12px;
    }
    </style>
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
        {!! Form::model($videos, ['route' => [config('laraadmin.adminRoute') . '.videos.update', $videos->id ],'method' =>'PUT','files' => true,'role'=>"form"]) !!}

        <div class="box-body">
            <div style="border: 1px solid #eeeeee; padding: 20px; margin: 10px 0;box-shadow: 0 0px 0 2px rgba(0,0,0,.2)"
                 class="video_wrapper">
                <div class="row">

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="website">@lang('messages.Website')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-group">
                                <select class="form-control websiteRow" name="website"  id="websiteRow" onchange="get_Cat(this.id,this.value)">
                                    <option value="1" {{$videos->website==1?  "selected": ""}}>Bidyanondo</option>
                                    <option value="2" {{$videos->website==2?  "selected": ""}}>One Taka Ahar</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="parent">@lang('messages.Video Category')<span class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control video-category" name="video_category_id" id="CatRow" required>
                               <option value="{{$videos->video_category_id}}">{{$videos->video_category->name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                   
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="image">@lang('messages.Video Image')<span class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">

                            <input type="file" class="form-control image" name="image">
                            <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:348X235px
                            </span>
                            @if(!is_null($videos->image))
                                <img src="{{asset($videos->image)}}" alt="Image" width="60px"
                                     height="50px">
                            @else
                                <img src="{{asset('uploads/students/default/default.png')}}" alt="No Image" width="50px"
                                     height="40px">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="video_link">@lang('messages.Video Link')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="url" class="form-control video_link" name="video_link"
                                   placeholder="@lang('messages.Enter Valid Url')"
                                   value="{{$videos->video_link or null}}" required>
                        </div>
                    </div>

                </div>
               
            </div>
            <div class="row" id="press-submit-wrapper">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                        <a class="btn btn-default"
                           href="{{ url(config('laraadmin.adminRoute') .'/videos') }}">@lang('messages.Cancel')</a>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>


@endsection

@push('scripts')
<script type="text/javascript">

    function get_Cat(row_id, val) {
        //alert(val); return;
        var site_name='';
        if(val==1){
            site_name='Bidyanondo';
        }else{
            site_name='One Taka Ahar';
        }
        var row_id=row_id.split('_');
        var currnt_row_no=row_id[1];
        $.ajax({
            type:"GET",
            url: "{{url(config('laraadmin.adminRoute').'/get_video_cat_ajax/')}}",
            data: {website: site_name},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (data) {
                // alert(data); return;
                var options = $.parseJSON(data);//parse JSON
                var $cat_dropdown = $("#CatRow");

                //alert(data); return;
                $cat_dropdown.empty(); // remove old options
                $.each(options, function(key,value) {
                    $cat_dropdown.append($("<option></option>") .attr("value", key).text(value));
                });


            }
        });


    }


</script>
@endpush
