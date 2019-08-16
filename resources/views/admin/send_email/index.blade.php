@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/scholarships') }}">@lang('messages.Scholarship')</a>
@endsection
@section("contentheader_description")
@section("section", trans("messages.Scholarship"))
@section("section_url", url(config('laraadmin.adminRoute') . '/scholarships'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", "Scholarship Add")

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

    @if(Session::has('seccess_msg'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{ Session::get('seccess_msg') }}</strong>
        </div>
    @endif

    <?php
    $donor_options = null;
    foreach ($donors as $donor) {
        $donor_options .= '<option value="' . $donor->id . '">' . $donor->name .' ('.$donor->email.')</option>';
    }

    ?>
    <div class="box box-success">
        <div class="box-header">
        </div>
        {!! Form::open(['url' => config('laraadmin.adminRoute') . '/send-donor-mail', 'id' => 'send-mail']) !!}
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="recipient_option">@lang('messages.Recipient')<span
                                    class="la-required">*</span></label>
                        <select class="form-control" rel="select2" required="1" name="recipient_option"
                                id="recipient_option"
                                onchange="recipientWiseDonorLoad(this.value)">
                            <option value="">Select Recipient</option>
                            <option value="1">All donors</option>
                            <option value="2">Active donors</option>
                            <option value="3">Scholarship donors</option>
                            <option value="4">Exclude Scholarship donors</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="donors">@lang('messages.Select Donors')</label>
                        <select class="form-control" rel="select2" name="donors[]" id="donors" multiple="multiple">
                            <?php echo $donor_options;?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mail_option">@lang('messages.Mail')<span class="la-required">*</span></label>
                        <select class="form-control" rel="select2" required="1" name="mail_option" id="mail_option"
                                onchange="showOrHideTemplateManual(this.value)">
                            <option value="">Select your mailing option.</option>
                            <option value="1">System</option>
                            <option value="2">Manual</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6" id="mail-template" style="display: none">
                    <div class="form-group">
                        <label for="template_id">@lang('messages.Mail Template')<span
                                    class="la-required">*</span></label>
                        <select class="form-control" rel="select2" name="template_id" id="template_id">
                            <option value="">Select a mail template.</option>
                            <option value="1">Send Scholarship Donors User Email And Password.</option>
                            <option value="2">Send Exclude Scholarship Donors User Email And Password.</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row row-centered" id="mail-layout" style="display: none">
                <div class="col-md-8 col-centered">
                    <div class="form-group">
                        <label for="subject">@lang('messages.Mail Subject')<span class="la-required">*</span></label>
                        <input type="text" name="subject" placeholder="Enter Mail Subject" class="form-control"
                               id="subject">
                    </div>
                </div>
                <div class="col-md-8 col-centered">
                    <div class="form-group">
                        <label for="body">@lang('messages.Mail Body')<span class="la-required">*</span></label>
                        <textarea name="body" id="body" cols="5" placeholder="Enter Mail Body" rows="3"
                                  class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div id="save_div">
                <a href="#" class="btn btn-success" onclick="save()">
                    <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                    @lang('messages.Send')
                </a>
                <a href="{{ url(config('laraadmin.adminRoute') . '/send_mail') }}"
                   class="btn btn-default">@lang('messages.Cancel')</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>


@endsection

@push('scripts')
<script type="text/javascript">
    $(function () {
        $('#donors').select2({
            multiple: true,
            placeholder: {
                text: 'Select Donors'
            },
            allowClear: true
        });
        $("#send-mail").validate({});

    });


    function save() {
        const msg = 'Are you sure you want to send email?';
        $.confirm({
            title: 'Confirm!',
            content: msg,
            buttons : {
                yes : function () {
                    $("#send-mail").submit();
                },
                no : function () {
                    return;
                }
            }
        });
    }

    function showOrHideTemplateManual(mail_options) {
        if (mail_options == 1) {
            $('#mail-layout').hide();
            $('#mail-template').show();
            $("#template_id").prop('required', "1");
            $("#subject").prop('required', false);
            $("#body").prop('required', false);
        } else if(mail_options == 2){
            $('#mail-template').hide();
            $('#mail-layout').show();
            $("#template_id").prop('required', false);
            $("#subject").prop('required', true);
            $("#body").prop('required', true);
        } else  {
            $('#mail-template').hide();
            $('#mail-layout').hide();
            $("#template_id").prop('required', false);
            $("#subject").prop('required', false);
            $("#body").prop('required', false);
        }
    }

    function recipientWiseDonorLoad(recipient_id) {
        var url = "{{ url(config('laraadmin.adminRoute') .'/recipientWiseDonorLoad') }}";
        $.post(url, {'recipient_id': recipient_id}, function (data) {
            $('#donors')
                .find('option')
                .remove()
                .end()
                .append(data);
        });
    }

</script>
@endpush

@push('styles')
<style>
    .row-centered {
        text-align: center;
    }

    .col-centered {
        float: none;
        margin: 0 auto;
    }
</style>
@endpush
