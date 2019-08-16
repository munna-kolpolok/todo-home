@extends("la.layouts.app")

@section("contentheader_title", trans("messages.Project FAQS"))
@section("contentheader_description", trans("messages.Project FAQS listing"))
@section("section", trans("messages.Project FAQS"))
@section("sub_section", trans("messages.Listing"))
@section("htmlheader_title", trans("messages.Project FAQS listing"))

@section("headerElems")
    @la_access('sr_project_faqs', "create")
    <a data-toggle="modal" data-target="#AddModal"
       class="btn btn-success btn-sm  pull-right">  @lang("messages.Add Project FAQS")</a>

    {{-- <a href="{{ url(config('laraadmin.adminRoute') . '/sr_project_objectives/create') }}"
        class="btn btn-success btn-sm pull-right"> @lang("messages.Add Project Sliders")</a>--}}
    @endla_access
@endsection

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
                    <th>Serial</th>
                    <th>Language</th>
                    <th style="min-width: 150px">Project</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($values as $key=>$value)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$value->project_language->name or null}}</td>
                        <td>{{$value->sr_project_faq->sr_project_translation->name or 'General'}}</td>
                        <td>{{$value->question or null}}</td>
                        <td>{{$value->answer or null}}</td>

                        <td style="min-width: 80px!important;">

                            @la_access('sr_project_faqs', "edit")
                            <a data-toggle="modal" data-target="#FaqEditModal"
                               onclick="getFaq({{$value->id}})"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit Language Content"
                               style="display:inline;padding:2px 5px 3px 5px;"> <i class="fa fa-language"> </i></a>

                            <a data-toggle="modal" data-target="#FaqEditModal"
                               onclick="getFaq({{$value->id}})"
                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                               style="display:inline;padding:2px 5px 3px 5px;"> <i class="fa fa-edit"> </i></a>
                            @endla_access
                            @la_access('sr_project_faqs', "delete")
                            {{Form::open(['route' => [config('laraadmin.adminRoute') . '.sr_project_faqs.destroy', $value->id], 'method' => 'delete', 'style'=>'display:inline'])}}
                            <button class="btn btn-danger btn-xs" type="submit" data-toggle="tooltip" title="Delete"
                                    onclick="return confirm('Are you sure to delete this entry?')"><i
                                        class="fa fa-times" title="Delete"> </i></button>
                            {{Form::close()}}
                            @endla_access


                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- modal start -->
    <div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"> &times; </span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Add FAQs in
                        Language</h4>
                </div>
                {!! Form::open(['action' => 'Admin\Save_Refugee\ProjectFaqController@store', 'id' => 'project-faq-form']) !!}

                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lang">@lang("messages.Language")<span
                                                class="la-required"> * </span>:</label>

                                    <select class="form-control select2" rel="select2" required="1" name="lang"
                                            id="">
                                        @foreach($languages as $language)
                                            {{--<option value="en">@lang("messages.English")</option>--}}
                                            <option value="{{ $language->code }}">{{ $language->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sr_project_type">@lang("messages.Project Type")<span
                                                class="la-required"> * </span>:</label>

                                    <select class="form-control select2" rel="select2" required="1" name="type"
                                            id="sr_project_type" onchange="checkTypeFunc(this.value)">
                                        <option value="1">@lang("messages.Project")</option>
                                        <option value="2">@lang("messages.General")</option>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="row" id="project_select">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sr_project_id">@lang("messages.Project")<span
                                                class="la-required"> * </span>:</label>

                                    <select class="form-control select2" rel="select2" required="1" name="sr_project_id"
                                            id="sr_project_id">
                                        @foreach($projects as $project)
                                            {{--<option value="en">@lang("messages.English")</option>--}}
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="question">@lang('messages.Question') <span
                                                class="la-required">*</span>:</label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 100-150 for better looking
                                         </span>
                                    <input type="text" class="form-control"
                                           name="question"
                                           placeholder="@lang('messages.Enter Question')"
                                           required value="{{old('question')}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="answer">@lang('messages.Answer') <span
                                                class="la-required">*</span>:</label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 800-1000 for better looking
                                         </span>
                                <textarea type="text" class="form-control "
                                          name="answer"
                                          placeholder="@lang('messages.Enter Answer')"
                                          required rows="5">{{old('answer')}}</textarea>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.Close')</button>
                    {{--<button type="button" class="btn btn-success" onclick="add_lan()">@lang('messages.Save')</button>--}}
                    {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- modal end -->

    <!-- Edit modal start -->
    <div class="modal fade" id="FaqEditModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"> &times; </span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Edit FAQ</h4>
                </div>
                {{ Form::open( array('url' => '', 'method'=>'PATCH', 'id' => 'faq-edit-form'))}}

                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lang">@lang("messages.Language")<span
                                                class="la-required"> * </span>:</label>

                                    <select class="form-control select2" rel="select2" required="1" name="lang"
                                            id="edit-lang" disabled>
                                        @foreach($languages as $language)
                                            {{--<option value="en">@lang("messages.English")</option>--}}
                                            <option value="{{ $language->code }}">{{ $language->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_sr_project_type">@lang("messages.Project Type")<span
                                                class="la-required"> * </span>:</label>

                                    <select class="form-control select2" rel="select2" required="1" name="type"
                                            id="edit_sr_project_type" disabled>
                                        <option value="1">@lang("messages.Project")</option>
                                        <option value="2">@lang("messages.General")</option>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="row" id="edit_project_select">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="edit_sr_project_id">@lang("messages.Project")<span
                                                class="la-required"> * </span>:</label>

                                    <select class="form-control select2" rel="select2" required="1" name="sr_project_id"
                                            id="edit_sr_project_id" disabled>
                                        @foreach($projects as $project)
                                            {{--<option value="en">@lang("messages.English")</option>--}}
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="question">@lang('messages.Question') <span
                                                class="la-required">*</span>:</label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 100-150 for better looking
                                         </span>
                                    <input type="text" class="form-control"
                                           name="question" id="edit_question"
                                           placeholder="@lang('messages.Enter Question')"
                                           required value="{{old('question')}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="answer">@lang('messages.Answer') <span
                                                class="la-required">*</span>:</label><span class="suggestion_text"><i
                                                class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 800-1000 for better looking
                                         </span>
                                <textarea type="text" class="form-control "
                                          name="answer" id="edit_answer"
                                          placeholder="@lang('messages.Enter Answer')"
                                          required rows="5">{{old('answer')}}</textarea>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.Close')</button>
                    {{--<button type="button" class="btn btn-success" onclick="add_lan()">@lang('messages.Save')</button>--}}
                    {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- Edit modal end -->

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
    $(function () {
        $('#example1').DataTable({
            responsive: false,
            stateSave: true,
            columnDefs: [{orderable: false, targets: [-1]}]
        });
        $("#project-faq-form").validate({});
        $("#faq-edit-form").validate({});
    });

    /*Project type check*/
    function checkTypeFunc(val) {
        if (val == 2) {

            $('#project_select').hide();
            $('#sr_project_id').val('');

        } else {
            $('#project_select').show();
        }


    }

    /*Get Modal data ajax*/
    function getFaq(val) {
        var faq_id = val;
        /*Edit  modal value set*/

        $.ajax({
            type: "POST",
            url: "{{url('admin/get-faq')}}",
            data: {id: faq_id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (data) {
                var faq_id = data.faq_trns.id;
                $('#edit-lang').val(data.faq_trns.locale).trigger('change.select2');
                $('#edit_sr_project_type').val(data.faq.type).trigger('change.select2');

                if(data.faq.type==2){
                    $('#edit_project_select').hide();
                    $('#edit_sr_project_id').val('');

                } else {
                    $('#edit_project_select').show();
                    $('#edit_sr_project_id').val(data.faq.sr_project_id).trigger('change.select2');
                }

                $('#edit_question').val(data.faq_trns.question);
                $('#edit_answer').val(data.faq_trns.answer);
                $('#faq-edit-form').attr('action', "{{url('/admin/sr_project_faqs')}}" + '/' + faq_id);


            }
        });
    }
</script>
@endpush
