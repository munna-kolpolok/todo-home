@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Contact Messages"))
@section("contentheader_description", trans("messages.Contact Messages listing"))
@section("section", trans("messages.Contact Messages"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Contact Messages listing"))

@section("main-content")

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

    <div class="box box-success">
        <!--<div class="box-header"></div>-->
        <div class="box-body">
            <table id="example1" class="table table-bordered">
                <thead>
                <tr class="success">
                    <th>@lang('messages.Serial No.')</th>
                    <th>@lang('messages.Subject')</th>
                    <th>@lang('messages.Message')</th>
                    <th>@lang('messages.Name')</th>
                    <th>@lang('messages.Email')</th>
                    <th>Website</th>
                    <th>@lang('messages.Action')</th>
                </tr>
                </thead>
                <tbody>

                @foreach($contact_messages as $key=>$value)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $value->subject or null}}</td>
                        <td>{{ $value->message or null}}</td>
                        <td>{{ $value->name or null }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->website->name or null }}</td>
                        <td>
                            @if(empty($value->reply_subject))
                                <input type="hidden" name="id" value="{{$value->id}}">
                                <a href="" data-toggle="modal" data-target="#modalCompose" class="btn btn-success send">
                                    Response
                                    <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                </a>
                            @else
                                <input type="hidden" id="replied_subject" value="{{$value->reply_subject}}">
                                <input type="hidden" id="replied_message" value="{{$value->reply_message}}">
                                <a href="" data-toggle="modal" data-target="#replaiedModal" class="btn btn-info replied">
                                    Replied &nbsp;
                                    <i class="fa fa-book" aria-hidden="true"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" id="modalCompose">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Send Message</h4>
                </div>
                {!! Form::open(['action' => 'Admin\ContactMessageController@store', 'id' => 'scholarship-add-form', 'class' => 'form-horizontal']) !!}
                <div class="modal-body">
                {{ csrf_field() }}
                <!--hidden field-->
                    <input type="hidden" name="contact_id" class="form-control contact_id" value="">
                    <div class="form-group">
                        <label class="col-sm-2" for="subject">Subject</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="subject"
                                   required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12" for="message">Message</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" name="message" placeholder="Message.." id="message" rows="5"
                                      required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancel</button>
                    {{--<button type="button" class="btn btn-warning pull-left">Save Draft</button>--}}
                    <button style="margin-right: 10px" type="submit" class="btn btn-primary pull-right">Send <i
                                class="fa fa-arrow-circle-right fa-lg"></i></button>

                </div>
                {!! Form::close() !!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="replaiedModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Message</h4>
                </div>
                {!! Form::open(['id' => 'scholarship-add-form', 'class' => 'form-horizontal']) !!}
                <div class="modal-body">
                <!--hidden field-->
                    <div class="form-group">
                        <label class="col-sm-2" for="subject">Subject</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="subject" id="replied_show_subject" placeholder="subject"
                                   required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12" for="message">Message</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" name="message" placeholder="Message.." id="replied_show_message" rows="5"
                                      required></textarea>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
    $(function () {
        /*Modal set dynamic contact id*/
        $('.send').on('click', function (e) {
            var contact_id = $(this).prev().val();
            var id = $('.contact_id').val(contact_id);
            //console.log(id.val());
        });

        $('.replied').on('click', function (e) {
            var message = $(this).prev().val();
            var subject = $(this).prev().prev().val();
            $('#replied_show_subject').val(subject);
            $('#replied_show_message').val(message);
        });


        $('#example1').DataTable({
            responsive: false,
            stateSave: true,
            columnDefs: [{orderable: false, targets: [-1]}]
        });
    });
</script>
@endpush
