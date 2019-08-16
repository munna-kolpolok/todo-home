@extends('website.profile_layouts.app')

<?php
$bloodGroupOptions = '';
$selected = '';
if (request()->cookie('locale') == 'bn') {
    foreach ($bloodGroups as $bloodGroup) {
        if (!empty($user->profile)) {
            $selected = ($bloodGroup->id == $user->profile->blood_group_id) ? 'selected' : '';
        }
        $bloodGroupOptions .= "<option value='$bloodGroup->id' $selected>$bloodGroup->bn_name</option>";
    }


} else {
    foreach ($bloodGroups as $bloodGroup) {
        if (!empty($user->profile)) {
            $selected = ($bloodGroup->id == $user->profile->blood_group_id) ? 'selected' : '';
        }
        $bloodGroupOptions .= "<option value='$bloodGroup->id' $selected>$bloodGroup->name</option>";
    }
}

?>

@section('profile-content')
    <div class="col-md-9">
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
        <div class="profile-update-form">
            {{ Form::open( array('url' => '/donors/update/'.auth()->id(), 'files'=>true, 'method'=>'POST', 'id' => 'user-profile-form'))}}
            <div id="user-profile-wrapper">
                <div class="row">
                    <div class="profile-header">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="image">@lang('messages.Profile Image')</label>
                                @if(!empty($user->profile->image))
                                    <img style="margin-bottom: 10px" src="{{asset($user->profile->image)}}"
                                         alt="Profile Image" class="img-responsive">
                                @else
                                    <img style="margin-bottom: 10px"
                                         src="{{asset('site-assets/images/profile/profile.jpg')}}" alt="Profile Image"
                                         class="img-responsive">
                                @endif
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="email">@lang('messages.Email')</label>
                                <input type="text" disabled class="form-control" value="{{$user->email or null}}">
                            </div>
                            <div class="form-group">
                                <label for="name">@lang('messages.Name')<span style="color: red">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="@lang('messages.Enter Your Name')" value="{{$user->name or null}}" required>
                            </div>
                            <div class="form-group">
                                <label for="contact_no">@lang('messages.Contact No.')</label>
                                <input type="text" name="contact_no" placeholder="@lang('messages.your contact no..')" class="form-control"
                                       value="{{$user->profile->contact_no or null}}">
                            </div>
                            <div class="form-group">
                                <label for="blood_group_id">@lang('messages.Blood Groups')</label>
                                <select name="blood_group_id" class="form-control" id="blood_group_id">
                                    <option value="">Select Blood Group</option>
                                    {!! $bloodGroupOptions !!}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="occupation">@lang('messages.Occupation')</label>
                            <input type="text" name="occupation" placeholder="@lang('messages.Enter Your Occupation')" class="form-control" value="{{$user->profile->occupation or null}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="interest">@lang('messages.UserInterest')</label>
                            <input type="text" name="interest" placeholder="@lang('messages.interest')" class="form-control" value="{{$user->profile->interest or null}}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">@lang('messages.Address')</label>
                            <textarea name="address" class="form-control" placeholder="@lang('messages.Enter Your Address')" id="address" cols="5" rows="2">{{$user->profile->address or null}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            
                            <button type="submit" class="btn btn-info">@lang('messages.Update')</button>
                            <a class="btn btn-default"
                               href="{{ url('donors') }}">@lang('messages.Cancel')</a>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@push('style')
<link href="{{ asset('la-assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script>
    

    $("#user-profile-form").validate({
        submitHandler: function (form) {
            var form_btn = $(form).find('button[type="submit"]');
            form_btn.prop('disabled', true);
            form_btn.html("<?php echo Lang::get('messages.Processing');?> <i class='fa fa-spinner fa-spin'></i>");
            form.submit();
        }
    });
</script>
@endpush