@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/sectors') }}">@lang('messages.Sector')</a> :
@endsection
@section("contentheader_description", $sector->$view_col)
@section("section", trans("messages.Sectors"))
@section("section_url", url(config('laraadmin.adminRoute') . '/sectors'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Sectors Edit : ".$sector->$view_col)

@section("main-content")
    @php
        $projectsArr=array();
        foreach ($projects as $project)
        {
        $projectsArr[$project->id]=$project->name;
        }
    $projectsJson=json_encode($projectsArr);
    @endphp

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
            <div class="row">

                {!! Form::model($sector, ['route' => [config('laraadmin.adminRoute') . '.sectors.update', $sector->id ], 'method'=>'PUT', 'id' => 'sector-edit-form']) !!}
                {{--@ la_form($module) --}}


                {{-- @la_edit_input($module, 'website_id')
                 @la_edit_input($module, 'name')
                 @la_edit_input($module, 'bn_name')
                  @la_edit_input($module, 'project_id')--}}

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="website_id">Website<span class='la-required'>* </span>:</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control" required="1" data-placeholder="Enter Website" rel="select2" id="website_id" onchange="loadProjects()" name="website_id">
                            @foreach($websites as $website)
                                <option value="{{$website->id}}" @php echo $sector->website_id==$website->id? "selected":"" @endphp>{{$website->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="name">Name<span class='la-required'>* </span>:</label>
                    </div></div><div class="col-md-4"><div class="form-group">
                        <input class="form-control" placeholder="Enter Name" data-rule-maxlength="256"   required="1" id="name" name="name" type="text" value="{{$sector->name}}">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group"><label for="bn_name">Bangla Name<span class='la-required'>* </span>:</label>
                    </div></div><div class="col-md-4"><div class="form-group">
                        <input class="form-control" placeholder="Enter Bangla Name" data-rule-maxlength="256"  required="1" id="bn_name" name="bn_name" type="text" value="{{$sector->bn_name}}">
                    </div>
                </div>
                <div class="projects-row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="project_id">Project<span class='la-required'>* </span>:</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control" required="1" data-placeholder="Enter Project" rel="select2" id="project_id" onchange="checkWebsite()" name="project_id">
                            @foreach($projects as $project)
                                <option value="{{$project->id}}" @php echo $sector->project_id==$project->id? "selected":"" @endphp>{{$project->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                </div>


                <div class="col-md-2">
                    <div class="form-group">
                        <label for="status">Status <span
                                    class="la-required">*</span></label>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control select2" name="is_show" id="is_show">
                            <option @if($sector->is_show == 1) selected @endif value="1">Active</option>
                            <option @if($sector->is_show == 0) selected @endif value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a
                                class="btn btn-default"
                                href="{{ url(config('laraadmin.adminRoute') . '/sectors') }}">@lang('messages.Cancel')</a>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(function () {
        $("#sector-edit-form").validate({});
       // loadProjects();
        checkWebsite()

    });

    function loadProjects(){
        var website=$('#website_id').val();

        var items = $.parseJSON('<?php echo $projectsJson;?>');//parse JSON
        if(website==1){
            $('#project_id').empty();
            $.each(items, function (k, v) {
                var item_list_option = "<option value=" + k + ">" + v + "</option>";
                $(item_list_option).appendTo('#project_id');
                $('.projects-row').show()

            });
        }else {
            $('#project_id').empty();
            var item_list_option = "<option value='1'>One Taka Meal</option>";
            $(item_list_option).appendTo('#project_id');
            $('.projects-row').hide()


        }
    }
    function checkWebsite() {
        var website=$('#website_id').val();
        if(website!=1){
            loadProjects();
        }
    }

</script>
@endpush
