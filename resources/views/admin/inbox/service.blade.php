@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/inboxes') }}">@lang('messages.Service')</a>
@endsection
@section("contentheader_description")
@section("section", trans("messages.Service"))
@section("section_url", url(config('laraadmin.adminRoute') . '/inboxes'))

@section("htmlheader_title", "Service")

@section("main-content")
    <style type="text/css">
        .preview-container {
            background-color: green;
        }
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
        {!! Form::open(['url' => config('laraadmin.adminRoute').'/service_store','files'=>true, 'id' => 'service-add-form']) !!}
        <input type="hidden" name="type" value="{{ $type }}">
        <input type="hidden" name="id" value="{{ $inbox_id }}">
        <input type="hidden" name="user_id" value="{{ $user_id }}">
        <input type="hidden" name="service_id" value="{{ $service_data->id or null }}">

        <div class="box-body">

            <div class="row">

                <div class="col-md-1">
                    <div class="form-group">
                        <label for="receive_voucher_no">@lang('messages.Date')</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <input type='text' class="form-control" name="date" id="date"
                                   placeholder="@lang('messages.Enter Date')"
                                   value="{{ isset($service_data->date)?App\Helpers\CommonHelper::showDateFormat($service_data->date):App\Helpers\CommonHelper::showDateFormat(date('Y-m-d')) }}"/>
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
                        </div>
                    </div>
                </div>


                <div class="col-md-1">
                    <div class="form-group">
                        <label for="venue">@lang('messages.Vanue')<span class="la-required">*</span></label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input class="form-control" type="text" name="venue" id="venue" value="{{$service_data->venue or null}}" placeholder="Enter Vanue" required>
                    </div>
                </div>

                <div class="col-md-1">
                    <div class="form-group">
                        <label for="send_mail">@lang('messages.Status')</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select name="service" id="service" class="form-control">
                            <option value="1" {{$service==1? "selected":""}}>Not Served</option>
                            <option value="2" {{$service==2? "selected":""}}>Served</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-1">
                    <div class="form-group">
                        <label for="send_mail">@lang('messages.Send Mail')</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select name="send_mail" id="send_mail" class="form-control" onchange="mail_send(this.value)">
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

                <div id="recipient_row" style="display: none">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="recipient_id">@lang('messages.Recipient')<span class="la-required">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="recipient_id" id="recipient_id" class="form-control"
                                    data-placeholder="Select recipient" onchange="recipient_func(this.value)" required>
                                {{-- <option value=""></option>--}}
                                @if($user_id!='')
                                    <option value="1">Donor</option>
                                    <option value="2">Branch</option>
                                    <option value="3">Both</option>
                                @else
                                    <option value="">Select</option>
                                    <option value="2" >Branch</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" id="branch_row" style="display: none;">
                    <div class="col-md-12 col-lg-1">
                        <div class="form-group">
                            <label for="recipient_id">@lang('messages.Select Branch') <span
                                        class="la-required">*</span></label>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3">
                        <select name="contact_id" id="contact_id" class="form-control contact_id" rel="select2"
                                data-placeholder="Select Branch" required>
                            <option value=""></option>
                            @foreach($branchs as $brach)
                                <option value="{{$brach->id}}">{{$brach->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


            </div>


            <div class="row" id="sub_row" style="display: none">
                <div class="col-md-2">
                    <div class="form-group" style="vertical-align: middle;">
                        <label for="subject" >@lang('messages.Subject') <span class="la-required">*</span> </label>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <input type="text" class="form-control" id="subject" name="subject"
                                  placeholder="Enter Subject" required />
                    </div>
                </div>

            </div>
            <div class="row" id="des_row" style="display: none">
                <div class="col-md-2">
                    <div class="form-group" style="vertical-align: middle;">
                        <label for="description" >@lang('messages.Description')<span class="la-required">*</span></label>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <textarea type="text" id="description" class="form-control" name="description" rows="5"
                                  placeholder="Enter Description" required></textarea>
                    </div>
                </div>

            </div>
            <div class="row" id="img_container" style="display: none" ;>
                <div class="col-md-12">
                    <div class="form-group">
                        {{--<label for="img">Insert Image</label>--}}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group" style="text-align: center;">
                        <div id="drop_zone" class="drop-zone">
                            <p class="title">Drop file here</p>

                            <div class="preview-container"></div>
                        </div>
                        <input id="file_input" {{--accept="image/*"--}} type="file" multiple="" name="file[]">
                    </div>
                </div>
            </div>


            <div id="save_div">
                <a href="#" class="btn btn-success" onclick="save()">@lang('messages.Save')</a>
                <a href="{{ url(config('laraadmin.adminRoute') . '/inboxes') }}"
                   class="btn btn-default">@lang('messages.Cancel')</a>
            </div>
            {!! Form::close() !!}
        </div>


        <div class="box-body">
        <table id="example1" class="table table-bordered">
        <thead>
        <tr class="success">
            <th>@lang('messages.Serial No.')</th>
            <th>Service Date</th>
            <th>Venue</th>
            <th>Subject</th>
            <th>Description</th>
            <th>Mail sent</th>
        </tr>
        </thead>
        <tbody>
            
            @foreach($service_data_all as $key=>$value)
            <tr>
                <td>{{ ++$key }}</td>
                <td>
                    <?php
                    if(isset($value->date)){
                        echo App\Helpers\CommonHelper::showDateFormat($value->date);
                    }?>
                </td>
                <td>{{ $value->venue or null}}</td>
                <td>{{ $value->subject or null}}</td>
                <td><pre>{{ $value->description or null}}</pre></td>
                <td>
                    @if($value->recipient_id == 1)
                        <span class="">Donor</span>
                    @elseif($value->recipient_id == 2)
                        <span class="">Branch</span>
                    @elseif($value->recipient_id == 3)
                        <span class="">Donor & Branch</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>

    </div>
    <?php
    $branchsArr = array();
    foreach ($branchs as $val) {
        $branchsArr[$val->id] = str_replace("'", "", $val->name);
    }
    $json_data = json_encode($branchsArr);
    // echo $json_data;
    ?>

@endsection


@push('styles')
<link href="{{ asset('la-assets/css/smartuploader.css') }}" rel="stylesheet">
@endpush
@push('scripts')
<script type="text/javascript" src="{{ asset('la-assets/plugins/smartuploader/jquery.smartuploader.js') }}"></script>
<script type="text/javascript">


    $(function () {
        $("#service-add-form").validate({});

    });

    function save() {
        $("#service-add-form").submit();
    }

    function studentWiseDonorLoad(student_id) {
        var url = "{{ url(config('laraadmin.adminRoute') .'/studentWiseDonorLoad') }}";
        $.post(url, {'student_id': student_id}, function (data) {
            $("#user_id").val(data.id)
            $("#user_id_email").val(data.email)
        });
    }
    function mail_send(val) {
        if (val == 1) {
            /*send mail */
            var user_id='<?php echo $user_id;?>';
            $('#img_container').show();
            $('#recipient_row').show();
            $('#sub_row').show();
            $('#des_row').show();
            if(user_id!=''){
                $("#recipient_id").val(1);
            }else{
                $("#recipient_id").val('');
            }
        } else {
            $('#img_container').hide();
            $('#recipient_row').hide();
            $('#branch_row').hide();
            $('#sub_row').hide();
            $('#des_row').hide();
            /*clear value*/
            $("#recipient_id").val('');
            $('#file_input').val('');
            $('#contact_id').val('');
            $('#subject').val('');
            $('#description').val('');
        }
    }
    function recipient_func(val) {
        if(val!=''){
            if (val != 1) {
                $('#branch_row').show();
                get_br_option();
            } else {
                $('#branch_row').hide();
            }
        }
    }

    /*Multiple img upload*/
    var result = $("#file_input").withDropZone("#drop_zone", {

        action: function (fileIndex) {
            // you can change your file
            // for example:
            var convertTo;
            var extension;
            if (this.files[fileIndex].type === "image/png") {
                convertTo = {
                    mimeType: "image/jpeg",
                    maxWidth: 150,
                    maxHeight: 150,
                };
                extension = ".jpg";
            }
            else {
                convertTo = null;
                extension = null;
            }

            return {
                name: "image",
                rename: function (filenameWithoutExt, ext, fileIndex) {
                    return filenameWithoutExt + (extension || ext)
                },
                params: {
                    preview: true,
                    convertTo: convertTo,
                }
            }
        },
        ifWrongFile: "show",
        wrapperForInvalidFile: function (fileIndex) {
            return `<
            div
            style = "margin: 20px 0; color: red;" > File
            :
            "${this.files[fileIndex].name}"
            doesn
            't support</div>`
        },
    });

    function get_br_option() {
        var contacts = JSON.parse('<?php echo $json_data;?>');
        var $el = $("#contact_id");
        $el.empty(); // remove old options
        $('#contact_id').append($('<option>', {
            value: '',
            text: ''
        }));
        $.each(contacts, function (key, value) {
            $el.append($("<option></option>")
                    .attr("value", key).text(value));
        });

    }

</script>
@endpush
