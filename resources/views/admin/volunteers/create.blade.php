@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/videos') }}">@lang('messages.Volunteers')</a> :
@endsection
@section("section", trans("messages.Volunteers"))
@section("section_url", url(config('laraadmin.adminRoute') . '/volunteers'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Add volunteers"))

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
        {!! Form::open(['action' => 'Admin\VolunteerController@store','files'=>true, 'id' => 'video-add-form']) !!}
            <div class="box-body">
                <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="video_wrapper">
                    <div class="row">

                         <div class="col-md-1">
                            <div class="form-group">
                                <label for="name">@lang('messages.Name')<span
                                                    class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name"
                                       placeholder="@lang('messages.Name')"
                                       value="{{old('name')}}" required>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="email">@lang('messages.Email')<span
                                                    class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email"
                                       placeholder="@lang('messages.Email')"
                                       value="{{old('email')}}" required>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="contact_no">@lang('messages.Contact No')<span
                                                    class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="contact_no"
                                       placeholder="@lang('messages.Contact No')"
                                       value="{{old('contact_no')}}" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                         <div class="col-md-1">
                            <div class="form-group">
                                <label for="name">@lang('messages.Branch')<span
                                                    class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="contact_id" required="1" id="contact_id">
                                    <option value="">Select Branch</option>
                                    @foreach ($contacts as $contact)
                                        <option value="{{$contact->id}}">{{$contact->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="address">@lang('messages.Address')<span
                                                    class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="address"
                                       placeholder="@lang('messages.Address')"
                                       value="{{old('address')}}" required>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="interest">@lang('messages.Interest')<span
                                                    class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="interest"
                                       placeholder="@lang('messages.Interest')"
                                       value="{{old('interest')}}" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="block_image">@lang('messages.Image')<span
                                            class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-11">
                            <div class="form-group">
                                <input type="file" class="form-control" name="block_image" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="biography">@lang('messages.Biography')<span
                                            class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-11">
                            <div class="form-group">
                                <textarea name="biography" class="form-control" placeholder="Enter biography" required>{{old('biography')}}</textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row" id="video-submit-wrapper">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute') .'/volunteers') }}">@lang('messages.Cancel')</a>
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
        /*Add new row*/
        $('#add-row').on('click', function (e) {
            $('.video_wrapper:first').clone().insertBefore('#video-submit-wrapper');
            $("<a style='margin-top: 8px' class='btn btn-danger btn-sm pull-right remove' onclick='removeRow(this)'>Remove</a>").insertAfter(".video_link:last");
            $('.video_link:last').val('');
            $('.image:last').val('');

            e.preventDefault();
        });



        $("#video-add-form").validate({});
        $(".nav-tabs a").click(function () {
            $(this).tab('show');
        });

    });

    function removeRow(current) {
        current.parentElement.parentElement.parentElement.parentElement.remove();
    }


</script>
@endpush
