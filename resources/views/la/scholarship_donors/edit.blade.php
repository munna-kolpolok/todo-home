@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/scholarship_donors') }}">@lang('messages.Scholarship Donor')</a> :
@endsection
@section("contentheader_description", $scholarship_donor->$view_col)
@section("section", trans("messages.Scholarship Donors"))
@section("section_url", url(config('laraadmin.adminRoute') . '/scholarship_donors'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Scholarship Donors Edit : ".$scholarship_donor->$view_col)

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

<div class="box box-success">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			
				{!! Form::model($scholarship_donor, ['route' => [config('laraadmin.adminRoute') . '.scholarship_donors.update', $scholarship_donor->id ], 'method'=>'PUT', 'id' => 'scholarship_donor-edit-form']) !!}
					{{--@ la_form($module) 
					
					
					@la_edit_input($module, 'student_id')
					@la_edit_input($module, 'user_id')
					--}}

					<div class="col-md-2">
						<div class="form-group">
							<label for="item_cat">@lang('messages.Student')<span class="la-required">*</span></label>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<input type="hidden" name="student_id" id="student_id" value="{{$scholarship_donor->student_id}}">
							<input  class="form-control" type="text" name="student_id_id_card" value="{{$scholarship_donor->student->id_card or null}}" readonly="1">
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group">
							<label for="item_cat">@lang('messages.Donor')<span class="la-required">*</span></label>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
						<select id="user_id" name="user_id" rel="select2" class="form-control">
							@foreach($donors as $donor)
							<option value="{{$donor->id}}"
								@if($donor->id==$scholarship_donor->user_id)
									selected="selected"
								@endif
							>{{ $donor->email or null}}</option>
							@endforeach
						</select>
						</div>
					</div>

					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/scholarship_donors') }}">@lang('messages.Cancel')</a>
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
	$("#scholarship_donor-edit-form").validate({
		
	});
});
</script>
@endpush
