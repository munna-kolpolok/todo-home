@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/gifts') }}">@lang('messages.Gifts')</a> :
@endsection
@section("section", trans("messages.Gifts"))
@section("section_url", url(config('laraadmin.adminRoute') . '/gifts'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Add Gift"))
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
        {!! Form::open(['action' => 'Admin\Marriage_Management\GiftsController@store','files'=>true, 'id' => 'gifts-add-form']) !!}
            <div class="box-body">
                <div style="border: 1px solid #eeeeee; padding: 20px; margin: 10px 0;box-shadow: 0 0px 0 2px rgba(0,0,0,.2)" class="gifts_wrapper">
                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="parent">@lang('messages.Name')<span
                                            class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Enter Name" id="name" name="name" value="{{old('name')}}" required>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="bn_name">@lang('messages.Name (Bangla)')<span
                                            class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Enter name" id="bn_name" name="bn_name" value="{{old('bn_name')}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="price">@lang('messages.Price')<span
                                            class="la-required">*</span><span
                                            class="la-required"></span></label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="number" class="form-control price" name="price"
                                       placeholder="@lang('messages.Enter Price')" value="{{old('price')}}" required>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="image">@lang('messages.Gift Image')<span
                                            class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="file" class="form-control image" name="image" required>
                                <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg. Size:405X330px
                                </span>
                            </div>
                        </div>

                    </div>
                <div class="row" id="gifts-submit-wrapper">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" id="total_row" value="1">
                            {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute') .'/gifts') }}">@lang('messages.Cancel')</a>
                        </div>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>
@endsection

@push('scripts')
<script type="text/javascript">

    $(function () {
        $("#gifts-add-form").validate({});
    });





</script>
@endpush
