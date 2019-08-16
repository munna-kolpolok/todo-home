<!-- modal start -->
<div class="modal fade" id="EditSliderLanModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"> &times; </span></button>
                <h4 class="modal-title" id="myModalLabel" style="text-align: center">Edit Slider Details Language</h4>
            </div>

            {{ Form::open( array('url' => '', 'method'=>'PATCH', 'id' => 'slider-lan-edit-form'))}}

            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="sr_slider_id" value="{{$sr_slider->id}}">
                            <div class="form-group">
                                <label for="lang">@lang("messages.Language")<span
                                            class="la-required"> * </span>:</label>

                                <select class="form-control select2" rel="select2" required="1" name="lang"
                                        id="edit_lang" disabled>
                                    @foreach($languages as $language)
                                        {{--<option value="en">@lang("messages.English")</option>--}}
                                        <option value="{{ $language->code }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Slider Title<span
                                            class="la-required"> * </span>:</label><span class="suggestion_text"><i
                                            class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 25
                                         </span>

                                <input type="text" class="form-control " id="edit_title"
                                       placeholder="Enter Slider Title" name="title"
                                       required="1">

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="sub_title">Slider Sub Title<span
                                            class="la-required"> * </span>:</label><span class="suggestion_text"><i
                                            class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 80-100 for better looking
                                         </span>

                                <input type="text" class="form-control " id="edit_sub_title"
                                       placeholder="Enter Slider Sub Title" name="sub_title"
                                       required="1">

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description_up">Slider Description Up<span
                                            class="la-required"> * </span>:</label><span class="suggestion_text"><i
                                            class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 180-200 for better looking
                                         </span>

                                    <textarea type="text" class="form-control " id="edit_description_up"
                                              placeholder="Enter Slider Description Up" name="description_up"
                                              required="1">{{old('description_up')}}</textarea>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description_down">Slider Description Down<span
                                            class="la-required">*</span>:</label><span class="suggestion_text"><i
                                            class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 500-600 for better looking
                                         </span>
                                <textarea type="text" class="form-control"
                                          name="description_down" id="edit_description_down"
                                          placeholder="Enter Slider Description Down"
                                          required >{{old('description_down')}}</textarea>

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

        $("#slider-lan-edit-form").validate({});

    });
    function getSliderLang(val){
        var project_translation_id=val;
        /*Edit  modal value set*/


        $.ajax({
            type:"POST",
            url: "{{url('admin/get-slider-lang')}}",
            data: {id: project_translation_id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            beforeSend: function () {
                // $(".loading").html("<img src={{ URL::asset('la-assets/img/searching.gif') }} width='40' height='40' />");
            },

            success: function (data) {
                var slider_trns_id=(data.id);
                //$('id').val(data.id);
                //$('#sr_project_id').val(data.sr_project_id);
               // $('$edit_lang').val(data.locale).trigger('select','select2');
                $('#edit_lang').val(data.locale).trigger('change.select2');
                $('#edit_title').val(data.title);
                $('#edit_sub_title').val(data.sub_title);
                $('#edit_description_up').val(data.description_up);
                $('#edit_description_down').val(data.description_down);
                //console.log(date);
                $('#slider-lan-edit-form').attr('action', "{{url('/admin/sr_sliders_tranlation')}}" + '/' + slider_trns_id);


            }
        });
    }
</script>
@endpush