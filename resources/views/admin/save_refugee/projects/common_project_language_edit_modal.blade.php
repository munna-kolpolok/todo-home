<!-- modal start -->
<div class="modal fade" id="edit-project-lang-modal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"> &times; </span></button>
                <h4 class="modal-title" id="myModalLabel" style="text-align: center">Edit Project Details Language</h4>
            </div>

            {{ Form::open( array('url' => '', 'method'=>'PATCH', 'id' => 'project-lan-edit-form'))}}

            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="id" type="hidden" id="" name="id" value="">
                                <input type="hidden" value="" name="sr_project_id">
                                <label for="lang">@lang("messages.Language")<span
                                            class="la-required"> * </span>:</label>

                                <select type="text" class="form-control local" name="local" id="edit_lang" disabled>
                                    @foreach($languages as $language)
                                        <option value="en">@lang("messages.English")</option>
                                        <option value="{{ $language->code }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">@lang("messages.Project Name")<span
                                            class="la-required"> * </span>:</label>
                                <span  class="suggestion_text"><i class="fa fa-hand-o-right name" aria-hidden="true"> </i>  Max character 25
                                         </span>

                                <input type="text" class="form-control name" id=""
                                       placeholder="@lang("messages.Enter project Name")" value="" name="name"
                                       required="1">

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">@lang("messages.Project Title")<span
                                            class="la-required"> * </span>:</label><span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 80-100 for better looking
                                         </span>

                                <input type="text" class="form-control title" id=""
                                       placeholder="@lang("messages.Enter Project Title")" name="title"
                                       required="1">

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="subtitle">@lang("messages.Project Sub-Title")<span
                                            class="la-required"> * </span>:</label><span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 180-200 for better looking
                                         </span>

                                <input type="text" class="form-control subtitle" id=""
                                       placeholder="@lang("messages.Enter Project Sub-Title")" name="subtitle"
                                       required="1">

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="description">@lang('messages.Project Description') <span
                                            class="la-required">*</span> : </label><span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 500-600 for better looking
                                         </span>
                                <textarea type="text" class="form-control description" id=""
                                          name="description"
                                          placeholder="@lang('messages.Enter Project Description')"
                                          required rows="5">{{old('description')}}</textarea>

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
    function getProjecLang(val){
        var project_translation_id=val;
        /*Edit  modal value set*/


        $.ajax({
            type:"POST",
            url: "{{url('admin/get-project-lang')}}",
            data: {id: project_translation_id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            beforeSend: function () {
                // $(".loading").html("<img src={{ URL::asset('la-assets/img/searching.gif') }} width='40' height='40' />");
            },

            success: function (data) {
                var project_lang_id=(data.id);

                $('.id').val(data.id);
                //$('#sr_project_id').val(data.sr_project_id);
                $('#edit_lang').val(data.locale).trigger('change.select2');
                $('.name').val(data.name);
                $('.title').val(data.title);
                $('.description').val(data.description);
                $('.subtitle').val(data.subtitle);
                //console.log(date);
                $('#project-lan-edit-form').attr('action', "{{url('/admin/sr_projects_tranlation')}}" + '/' + project_lang_id);


            }
        });
    }
</script>
@endpush