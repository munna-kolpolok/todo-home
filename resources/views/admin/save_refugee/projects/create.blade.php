@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/sr_projects') }}">@lang('messages.Project')</a> :
@endsection
@section("section", trans("messages.Project"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sr_projects'))
@section("sub_section", trans("messages.Add"))

@section("htmlheader_title", trans("messages.Add Project"))

@section("main-content")
    <style type="text/css">
        #save_div {
            display: none;
        }
        .suggestion_text{
        color:green;
        font-size: 12px;
    }
    </style>
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="box box-success">
        {!! Form::open(['action' => 'Admin\Save_Refugee\ProjectsController@store','files'=>true, 'id' => 'projects-add-form']) !!}
            <div class="box-body">
                <div style="border: 1px solid gray; padding: 20px; margin: 10px 0" class="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="up_title">@lang('messages.Project Target Amount')  <span class="la-required">*</span></label>
                                <input type="number"  class="form-control up_title" name="target" placeholder="@lang('messages.Enter Amount in USD')"  value="{{old('target')}}"  required>
                                <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    Must be a number.
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="project_image">@lang('messages.Project Image') <span class="la-required">*</span></label>
                                <div style="margin-top: 0" class="media">
                                    <div class="media-left">

                                    </div>
                                    <div class="media-body project_image">
                                        <input type="file" id="" class="form-control image" name="project_image" accept="image/png,image/gif,image/jpeg,image/jpg" required>
                                         <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Type: jpeg,jpg,png,gif. Size: 320X240px
                                         </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image">@lang('messages.Video Link') <span class="la-required">*</span></label>
                                <div class="form-group">
                                    <input type="url" class="form-control video_link" name="video_link"
                                           placeholder="@lang('messages.Enter Valid Url')"
                                           value="{{old('video_link')}}" required>
                                     <span class="suggestion_text">
                                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                         @lang('messages.Enter Valid Url')
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="is_menu">@lang('messages.Menu')<span
                                            class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="is_menu" id="is_menu" required>
                                    <option selected value="1">Show in menu</option>
                                    <option  value="2">Not show in menu</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="is_home">@lang('messages.Home')<span
                                            class="la-required">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="is_home" id="is_home" required>
                                    <option value="1">Show in home page</option>
                                    <option selected value="2">Not show in home page</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="is_show">@lang('messages.Show')<span
                                            class="la-required">*</span></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="is_show" id="is_show" required>
                                    <option selected value="1">Show in website</option>
                                    <option value="2">Not show in website</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <h4 style="background-color: lightgray; text-align: center; padding: 5px;">Project Details in English</h4>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="up_title">@lang('messages.Project Name') <span
                                                class="la-required">*</span></label> <span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 25 for better looking
                                         </span>
                                    <input type="text" class="form-control up_title"
                                           name="name" placeholder="@lang('messages.Enter Project Name in English')"
                                           value="{{old('name')}}" required>

                                </div>
                            </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">@lang('messages.Project Title') <span
                                            class="la-required">*</span></label><span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 80-100 for better looking
                                         </span>
                                <input type="text" class="form-control "
                                       name="title" placeholder="@lang('messages.Enter Project Title in English')"
                                       value="{{old('title')}}" required>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">@lang('messages.Project Description') <span
                                            class="la-required">*</span></label><span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 180-200 for better looking
                                         </span>
                                <textarea type="text"  class="form-control up_title"
                                          name="description" placeholder="@lang('messages.Enter Project Description in English')"
                                          required  rows="3">{{old('description')}}</textarea>

                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subtitle">@lang('messages.Project Sub-Title') <span
                                            class="la-required">*</span></label><span  class="suggestion_text"><i class="fa fa-hand-o-right" aria-hidden="true"> </i>  Max character 500-600 for better looking
                                         </span>
                                <textarea type="text" class="form-control "
                                       name="subtitle" placeholder="@lang('messages.Enter Project Sub-Title in English')"
                                        required rows="3">{{old('subtitle')}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-md-12">
                        <div class="form-group" style="text-align: center">
                            {!! Form::submit( Lang::get('messages.Save'), ['class'=>'btn btn-success']) !!}
                            <a class="btn btn-default"
                               href="{{ url(config('laraadmin.adminRoute') .'/sr_projects') }}">@lang('messages.Cancel')</a>
                            <!-- <button class="btn btn-info pull-right" id="add-row">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add row
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>


@endsection

@push('scripts')
<script type="text/javascript">
    $(function () {

        $("#projects-add-form").validate({});
        $(".nav-tabs a").click(function () {
            $(this).tab('show');
        });

    });

</script>
@endpush
