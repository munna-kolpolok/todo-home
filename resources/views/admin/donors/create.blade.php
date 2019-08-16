@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/donors') }}">@lang('messages.Donors')</a>
@endsection
@section("contentheader_description")
@section("section", trans("messages.Donors"))
@section("section_url", url(config('laraadmin.adminRoute') . '/donors'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", "Donor Add")

@section("main-content")
    <style type="text/css">
        /*#save_div{
            display: none;
        }*/
    </style>

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
        <div class="box-header">
        </div>
        {!! Form::open(['action' => 'Admin\DonorController@store', 'id' => 'donor-add-form']) !!}
        <div class="box-body">

            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="name">@lang('messages.Donor Name')</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name"
                               id="name"
                               placeholder="@lang('messages.Enter Donor Name')"
                               value="{{old('name')}}">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="bn_name">@lang('messages.Donor Name(bangla)')</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="text" class="form-control" name="bn_name"
                               id="bn_name"
                               placeholder="@lang('messages.Enter Donor Bangla Name')"
                               value="{{old('bn_name')}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="email">@lang('messages.Donor Email') <span
                                    class="la-required">*</span></label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="text" required="1" class="form-control" name="email"
                               id="name"
                               placeholder="@lang('messages.Enter Donor Email')"
                               value="{{old('email')}}">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="password">@lang('messages.Password')<span
                                    class="la-required">*</span></label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="password" class="form-control" name="password"
                               id="password"
                               placeholder="@lang('messages.Enter Password')"
                               value="{{old('password')}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="contact_no">@lang('messages.Contact No')</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="text" class="form-control" name="contact_no"
                               id="contact_no"
                               placeholder="@lang('messages.Enter Contact No')"
                               value="{{old('name')}}">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="address">@lang('messages.Donor Address')</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="text" required="1" class="form-control" name="address"
                               id="address"
                               placeholder="@lang('messages.Enter Donor Address')"
                               value="{{old('address')}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="bn_address">@lang('messages.Donor Address(Bangla)')</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="text" class="form-control" name="bn_address"
                               id="bn_address"
                               placeholder="@lang('messages.Enter Donor Address Bangla')"
                               value="{{old('bn_address')}}">
                    </div>
                </div>
            </div>

            <div id="save_div">
                <a href="#" class="btn btn-success" onclick="save()">@lang('messages.Save')</a>
                <a href="{{ url(config('laraadmin.adminRoute') . '/scholarships') }}"
                   class="btn btn-default">@lang('messages.Cancel')</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>


        @endsection

        @push('scripts')
        <script type="text/javascript">
            $(function () {
                $("#donor-add-form").validate({});

            });

        </script>
    @endpush
