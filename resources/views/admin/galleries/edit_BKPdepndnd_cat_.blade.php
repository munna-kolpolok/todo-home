@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/galleries') }}">@lang('messages.Gallery')</a> :
@endsection
@section("section", trans("messages.Gallery"))
@section("section_url", url(config('laraadmin.adminRoute') . '/galleries'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", trans("messages.Edit Galley Image"))

@section("main-content")
    <style type="text/css">
        #save_div {
            display: none;
        }
        .suggestion_text{
            color: green;
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
        {!! Form::model($galleries, ['route' => [config('laraadmin.adminRoute') . '.galleries.update', $galleries->id ],'method' =>'PUT','files' => true,'role'=>"form"]) !!}

        <div class="box-body">
            <div style="border: 1px solid #eeeeee; padding: 20px; margin: 10px 0;box-shadow: 0 0px 0 2px rgba(0,0,0,.2)"
                 class="vgallery_wrapper">

            <div class="row">
                <div class="col-md-6">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="website">@lang('messages.Website')<span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="form-group">
                                <select class="form-control websiteRow" name="website"  id="websiteRow" onchange="get_Cat(this.id,this.value)">
                                    <option value="1" {{$galleries->website==1?  "selected": ""}}>Bidyanondo</option>
                                    <option value="2" {{$galleries->website==2?  "selected": ""}}>One Taka Ahar</option>
                                </select>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="form-group">
                            <label for="parent">@lang('messages.Gallery Category')<span
                                                    class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">

                            <select class="form-control gallery-category" name="gallery_category_id" id="CatRow" required>
                                <option value="{{$galleries->gallery_category_id}}">{{$galleries->gallery_category->name}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="image">@lang('messages.Gallery Image')<span class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="file" class="form-control image" name="image">
                            
                            <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size:1200X833px
                            </span>
                        </div>
                    </div>
                   
                </div>

                 <div class="col-md-6">  
                      <div class="col-md-12">
                            <div class="form-group">
                                @if(!is_null($galleries->gallery_image))
                                    <img src="{{asset($galleries->gallery_image)}}" alt="Image" width="200px" height="138px">
                                @else
                                    <img src="{{asset('uploads/students/default/default.png')}}" alt="No Image" width="50px" height="40px">
                                @endif
                            </div>
                        </div>                    
                    </div>
            </div>

            </div>
            <div class="row" id="press-submit-wrapper">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                        <a class="btn btn-default"
                           href="{{ url(config('laraadmin.adminRoute') .'/galleries') }}">@lang('messages.Cancel')</a>
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
            url: "{{url(config('laraadmin.adminRoute').'/get_gallery_cat_ajax/')}}",
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
