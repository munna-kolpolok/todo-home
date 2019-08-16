@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/accounts') }}">@lang('messages.Account')</a> :
@endsection
@section("contentheader_description", $account->$view_col)
@section("section", trans("messages.Accounts"))
@section("section_url", url(config('laraadmin.adminRoute') . '/accounts'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Accounts Edit : ".$account->$view_col)

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
			
				{!! Form::model($account, ['route' => [config('laraadmin.adminRoute') . '.accounts.update', $account->id ], 'method'=>'PUT', 'id' => 'account-edit-form']) !!}
					{{--@ la_form($module) --}}
					
					
					@la_edit_input($module, 'website_id')
					@la_edit_input($module, 'type')
					@la_edit_input($module, 'name')
					@la_edit_input($module, 'bn_name')
					
                    <div class="col-md-12">
					<div class="form-group">
						{!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a class="btn btn-default" href="{{ url(config('laraadmin.adminRoute') . '/accounts') }}">@lang('messages.Cancel')</a>
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
	$("#account-edit-form").validate({
		
	});
});
</script>
@endpush
