<!-- modal start -->
<div class="modal fade" id="edit-project-obj-modal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"> &times; </span></button>
                <h4 class="modal-title" id="myModalLabel" style="text-align: center">Edit Objective Details</h4>
            </div>

            {{ Form::open( array('url' => '', 'method'=>'PATCH', 'id' => 'project-lan-edit-form'))}}

            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sr_project_id">@lang("messages.Project")<span
                                            class="la-required"> * </span>:</label>

                                <select class="form-control select2" rel="select2" required="1" name="sr_project_id"
                                        id="sr_project_id_edit" disabled>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name or null }}</option>
                                    @endforeach
                                </select>
                               {{-- <input type="text" class="form-controll" disabled>--}}

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lang">@lang("messages.Language")<span
                                            class="la-required"> * </span>:</label>

                                <select class="form-control select2" rel="select2" required="1" name="lang"
                                        id="langSelect" disabled>
                                    @foreach($languages as $language)
                                        <option value="{{ $language->code }}">{{ $language->name }}</option>
                                    @endforeach


                                </select>

                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="objective">@lang('messages.Project Objective') <span
                                            class="la-required">*</span>:</label><span class="suggestion_text"><i
                                            class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 150 for better looking
                                         </span>
                                <textarea type="text" class="form-control objective"
                                          name="objective"
                                          placeholder="@lang('messages.Enter Project Objective')"
                                          required rows="5">{{old('objective')}}</textarea>

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



@push('scripts')
    <script>
    $(function () {

        $("#project-lan-edit-form").validate({});

    });

    function getObjData(val){
        var translation_id=val;
        /*Edit  modal value set*/

        $.ajax({
            type:"POST",
            url: "{{url('admin/get-project-obj')}}",
            data: {id: translation_id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (data) {
                var project_obj_lang_id=(data.trns.id);
                $('.objective').val(data.trns.objective);
                $('#sr_project_id_edit').val(data.proj.sr_project_id).trigger('change.select2');
                $('#langSelect').val(data.trns.locale).trigger('change.select2');
                $('#project-lan-edit-form').attr('action', "{{url('/admin/sr_project_objectives')}}" + '/' + project_obj_lang_id);


            }
        });
    }
</script>
@endpush