@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/users') }}">@lang('messages.User')</a> :
@endsection
@section("contentheader_description", trans("messages.User Edit"))
@section("section", trans("messages.Users"))
@section("section_url", url(config('laraadmin.adminRoute') . '/users'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "User Edit")

@section("main-content")

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
        <div class="box-body">

            {!! Form::model($user, ['route' => [config('laraadmin.adminRoute') . '.users.update', $user->id ], 'method'=>'PUT', 'id' => 'user-edit-form']) !!}
            {{--@ la_form($module) --}}


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name <span class="la-required">*</span></label>
                        <input class="form-control" placeholder="Enter Name" data-rule-minlength="2"
                               data-rule-maxlength="250" required="1" id="name" name="name" type="text" value="{{$user->name}}"
                               aria-required="true">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="name">Email <span class="la-required">*</span></label>
                    <input class="form-control" placeholder="Enter Email" data-rule-maxlength="250"
                           data-rule-unique="true" required="1" data-rule-email="true" id="email" name="email"
                           type="email" aria-required="true" aria-invalid="true" value="{{$user->email}}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Password</label>
                        <input class="form-control" placeholder="Enter Password" data-rule-minlength="6"
                               data-rule-maxlength="250" id="password" name="password" type="password"
                               value="" aria-required="true"></div>
                </div>
                <div class="col-md-6">
                    <label for="name">User Level <span class="la-required">*</span></label>
                    <select class="form-control select2" name="user_level" required="1" id="user_level">
                        <?php
                        $level_options = App\Models\Common_Model::common_dropdown('user_levels', 'id', 'name', $user->user_level, 'level');
                        echo $level_options;
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="is_verified">Verified</label>
                        <select class="form-control select2" name="is_verified" id="is_verified">
                            <option @if($user->is_verified == 1) selected @endif value="1">Verified</option>
                            <option @if($user->is_verified == 0) selected @endif value="0">Not Verified</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Donor</label>
                        <select class="form-control select2" name="is_donor" id="is_donor">
                            <option @if($user->is_donor == 1) selected @endif value="1">Donor</option>
                            <option @if($user->is_donor == 0) selected @endif value="0">Not Donor</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Id Card</label>
                        <input class="form-control" placeholder="Enter Unique Id" data-rule-maxlength="150" id="id_card"
                               name="id_card" type="text" value="{{$user->id_card}}" aria-required="true">
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!}
                    <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/users') }}">@lang('messages.Cancel')</a>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(function () {
        $("#user-edit-form").validate({});
    });
</script>
@endpush
